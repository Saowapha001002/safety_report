<?php

namespace App\Http\Controllers\Front;

use App\Helpers\MailHelper;
use App\Helpers\ApproverHelper;
use App\Http\Controllers\Controller;
use App\Models\Cause;
use App\Models\Event;
use App\Models\PlantMaster;
use App\Models\Rank;
use App\Models\Safety;  
use App\Models\Tracking; 
use App\Models\ApproverPlantMapping; 

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
 

class FromController extends Controller
{

    public function index()
    {
        $event = Event::where('status','1')->get();
        $ranks = Rank::where('status','1')->get();
        $cause = Cause::where('status','1')->get();
        $plants = PlantMaster::all();
        return view('front.from.magic',compact('cause','event','ranks','plants'));
    }
   /**
     * Show the form for creating a new resource.
     */

  
 
    public function create()
    {
        $event = Event::where('status','1')->get();
        $ranks = Rank::where('status','1')->get();
        $cause = Cause::where('status','1')->get();
        $plants = PlantMaster::all();
        return view('front.from.magic',compact('cause','event','ranks','plants'));
    }


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        // 1) Validate ข้อมูลที่จำเป็น
        $request->validate([
            'sLocation_view'     => 'required|string|max:255',  // plant_code
            // ถ้ามี field ที่ต้อง required เพิ่มเติมให้ใส่ตรงนี้
            // 'EmpLoc'           => 'required|string',
            // 'msCauseCheck'     => 'required|integer',
            // 'msEventCheck'     => 'required|integer',
        ]);

        $todaySend   = Carbon::now()->format('Ymd');

        $empid       = Auth::user()->empid;
        $empemail    = Auth::user()->email;
        $empfullname = Auth::user()->fullname;

        $todayPrefix = Carbon::now()->format('Ymd');

        $latestSafety = Safety::where('safety_code', 'like', 'ST' . $todayPrefix . '%')
            ->orderByDesc('safety_code')
            ->first();

        if ($latestSafety) {
            // ตัด ‘ST’ ออก → ตัด 10 ตัวแรก STYYYYMMDD
            $lastNumber = (int) substr($latestSafety->safety_code, 10, 4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $newSafetyCode = 'ST' . $todayPrefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        // ------------------ บันทึก safety_report ------------------
        $safety = new Safety();
        $safety->safety_code        =  $newSafetyCode;
        $safety->report_empid       = $empid;
        $safety->report_name        = $empfullname;
        $safety->report_email       = $empemail;
        $safety->report_plant       = $request->EmpLoc;
        $safety->report_date        = $todaySend;
        $safety->cause_id           = $request->msCauseCheck;
        $safety->event_id           = $request->msEventCheck;
        $safety->report_detail      = $request->MsDetail;
        $safety->location_view      = $request->sLocation_view;
        $safety->location_dept_view = $request->sLocation_dept_view;
        $safety->safety_status      = 1;

        // รูปก่อนเหตุการณ์
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                $path     = $file->storeAs('images/before', $filename, 'public');
                $safety->report_img_before = $path;
            }
        }

        $safety->solve_status = $request->msCheck;
        $safety->rank_id      = $request->rdRank;
        $safety->suggestion   = $request->MsSuggestion;

        try {
            $saved = $safety->save();

            if (!$saved) {
                return response()->json([
                    'status'  => 500,
                    'success' => 'error11',
                    'message' => 'ไม่สามารถบันทึกข้อมูลได้',
                ]);
            }

            // ================== หา Manager / SHE ตาม Plant ==================
            $plantCode = $request->sLocation_view;                // เช่น BGPU, BGC ฯลฯ
            $approvers = ApproverHelper::getApproversByPlantCode($plantCode);
            $manager   = $approvers['manager'];
            $she       = $approvers['she'];

            if (!$manager) {
                return response()->json([
                    'status'  => 500,
                    'success' => 'error',
                    'message' => 'ไม่พบผู้อนุมัติ (Manager) ของ Plant นี้',
                ]);
            }

            if (!$she) {
                return response()->json([
                    'status'  => 500,
                    'success' => 'error',
                    'message' => 'ไม่พบผู้รับผิดชอบ SHE ของ Plant นี้',
                ]);
            }

            $token = Str::random(64);

            // ================== บันทึก tracking ==================
            $tracking = new Tracking();
            $tracking->safety_code      =  $newSafetyCode;
            $tracking->report_date      = $todaySend;

            // ฝั่ง Manager
            $tracking->assign_id        = $manager->codempid ?? null;
            $tracking->assign_name      = $manager->emp_name;
            $tracking->assign_email     = $manager->emp_email;
            $tracking->assign_status    = 0; // ยังไม่ดำเนินการ

            // ฝั่ง SHE
            $tracking->she_id           = $she->codempid ?? null;
            $tracking->she_name         = $she->emp_name;
            $tracking->she_email        = $she->emp_email;
            $tracking->she_status       = 0;

            // token สำหรับลิงก์อนุมัติของ Manager รอบแรก
            $tracking->login_token      = $token;
            $tracking->token_expires_at = now()->addDays(7);

            $tracking->save();

            // ลิงก์ให้ Manager กดอนุมัติ
            $link = route('approve.magic.login', ['token' => $tracking->login_token]);

            // ================== เตรียมข้อมูลส่งเมล ==================
            $data = [
                'headname'      => $manager->emp_name, // คนที่จะได้รับเรื่อง (Manager)
                'name'          => $empfullname,       // คนรายงาน
                'departuredate' => $todaySend,
                'remark'        => 'แก้ไขเหตุการณ์ไม่ปลอดภัย',
                'safety_code'   => $safety->safety_code,
                'link'          => $link,
                'safety_status' => 1,
            ];

            MailHelper::sendExternalMail(
                $manager->emp_email,
                'แจ้งการรายงาน Magic Finger ',
                'mails.notify',
                $data,
                'Magic Finger System'
            );

            return response()->json([
                'status'  => 200,
                'success' => 'success',
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'success' => 'error33',
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function success()
    {
        return view('front.from.success');
    }
   
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
