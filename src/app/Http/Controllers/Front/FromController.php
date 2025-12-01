<?php

namespace App\Http\Controllers\Front;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Models\Cause;
use App\Models\Event;
use App\Models\Rank;
use App\Models\Safety;
use App\Models\Tracking;
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
        return view('front.from.magic',compact('cause','event','ranks'));
    }
   /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $event = Event::where('status','1')->get();
        $ranks = Rank::where('status','1')->get();
        $cause = Cause::where('status','1')->get();
        return view('front.from.magic',compact('cause','event','ranks'));
    }


    /**
     * Display the specified resource.
     */
    public function store(Request $request)
    {
        // dd($request->all()); 
        $event = Event::where('status','1')->get();
        $ranks = Rank::where('status','1')->get();
        $cause = Cause::where('status','1')->get();

        $request->validate([
            'sLocation_view' => 'required|string|max:255',
            // 'sLocation_dept_view' => 'required|string|max:500', 
            // 'EmpLoc' => 'required|string|max:255',
            // 'msCauseCheck' => 'required|array',
            // 'msCauseCheck.*' => 'exists:causes,id',
            // 'msEventCheck' => 'required|array',
            // 'msEventCheck.*' => 'exists:events,id',
            
        ] );
        $todaySend = Carbon::now()->format('Ymd');
        $empid = Auth::user()->empid;
        $empemail = Auth::user()->email;
        $empfullname = Auth::user()->fullname;

        $todayPrefix = Carbon::now()->format('Ymd');

        $latestId = Safety::where('id', 'like', $todayPrefix . '%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = $latestId ? ((int)substr($latestId->id, 8)) + 1 : 1;
        $newId = $todayPrefix  . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $token = Str::random(64);

        $event = new Safety();
        $event->safety_code = "ST" . $newId ;
        $event->report_empid = $empid ;
        $event->report_name =  $empfullname;
        $event->report_email = $empemail; 
        $event->report_plant =  $request->EmpLoc;
        $event->report_date =  $todaySend ; 
        $event->cause_id = $request->msCauseCheck;
        $event->event_id = $request->msEventCheck;
        $event->report_detail =  $request->MsDetail;
        $event->location_view =  $request->sLocation_view;
        $event->location_dept_view =  $request->sLocation_dept_view;
        $event->safety_status = 1 ;
        // 
 


        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                // $file->hashName();
                $path = $file->storeAs('images/before', $filename, 'public');
                $event->report_img_before = $path ;
                 
            }
        }
        $event->solve_status =$request->msCheck; 
        $event->rank_id = $request->rdRank;
        $event->suggestion = $request->MsSuggestion ;
         
            try {
               $event_save =  $event->save();
                if ($event_save) {
 
                    $tracking = new Tracking();
                    $tracking->safety_code      = $event->safety_code ;
                    $tracking->report_date      = $todaySend ;
                    $tracking->assign_id        = '63000455';
                    $tracking->assign_name      = 'เสาวภา เข็มเหลือง'; 
                    $tracking->assign_email     = 'saowapha.k@bgiglass.com';
                    $tracking->assign_status    =  0 ;  
                    $tracking->login_token      =  $token ;
                    $tracking->token_expires_at =   now()->addDays(7) ; 
                    $tracking->save();
 
                    $link = route('approve.magic.login', ['token' => $tracking->login_token]);
      


                    $data = [
                        'headname' => 'saowapha', // คนที่ reject
                        'name' => 'saowapha khemlueang', // user
                        'departuredate' => $todaySend ,
                        'remark' => 'แก้ไขเหตุการณ์ไม่ปลอดภัย',
                        'safety_code' => $event->safety_code,
                        'link' => $link,
                        'safety_status' => 2
                    ];

                    MailHelper::sendExternalMail(
                        'saowapha.k@bgiglass.com',
                        'แจ้งการรายงาน Magic Finger ',
                        'mails.notify', // ชื่อ blade view mail
                        $data,
                        'แจ้งการรายงาน Magic Finger',
                    );
                    
                    return response()->json([
                        'status'=> 200,
                        'success' => 'success',
                        'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว'
                        ]);

                } else {
                     try {
                        return response()->json([
                            'status'=> 500,
                            'success' => 'error11',
                            'message' => 'ไม่สามารถบันทึกข้อมูลได้'
                            ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            'status'=> 500,
                            'success' => 'error22',
                            'message' => $e->getMessage()
                            ]);
                    }
                }
              

            } catch (\Exception $e) {
                return response()->json([
                    'status'=> 500,
                    'success' => 'error33',
                    'message' => $e->getMessage()
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
