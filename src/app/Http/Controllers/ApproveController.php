<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\MailHelper;
use App\Models\Approve;
use App\Models\Cause;
use App\Models\Event;
use App\Models\GroupSpecial;
use App\Models\Rank;
use App\Models\Safety;
use App\Models\Tracking;
use App\Models\User;
use App\Models\Valldataemp;  
use Carbon\Carbon; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\ApproverHelper; 

class ApproveController extends Controller
{

    public function index()
    {
        return view('approve.approve');
    }

    public function show($id)
    {
        $nextempid = '';
        $nextemail = '';
        $nextfullname = '';
        $nextStepApprove = '';
        $nextempid = '';
        $nextemail = '';
        $nextfullname = '';

        $Tracking = Tracking::findOrFail($id);   
        $exMail = '';
        $exName = '';

         if ($Tracking) {
            $Safety =  Safety::where('safety_code', $Tracking->safety_code)->first();
        }else if(!$Tracking){
            return response()->view('approve.approve_expired', [
                'message' => 'Token หมดอายุหรือไม่ถูกต้อง'
            ]);
        }
       
        if($Safety){
            $Cause = Cause::where('id', $Safety->cause_id)->first();  
            $Event = Event::where('id', $Safety->event_id)->first();  
            $Rank = Rank::where('id', $Safety->rank_id)->first();  
            
        }       


            if ($Rank->id == 1) {
            $Class_rank = 'card-border-shadow-danger';
            $Class_rank_label = 'bg-label-danger';
            } elseif ($Rank->id == 2) {
                $Class_rank = 'card-border-shadow-warning';
                $Class_rank_label = 'bg-label-warning';
            } elseif ($Rank->id == 3) {
                $Class_rank = 'card-border-shadow-info';
                $Class_rank_label = 'bg-label-info';
            } else {
                $Class_rank = '';
                $Class_rank_label = '';
            }

       
        //'approve'=> $approve,
        //'user'=> $user,

        return view('approve.approve', compact('Tracking', 'Safety', 'Cause','Event','Rank', 'Class_rank','Class_rank_label','exMail', 'exName'))
            ->with([
                'nextempid' => $nextempid,
                'nextemail' => $nextemail,
                'nextfullname' => $nextfullname,
                'nextStepApprove' => $nextStepApprove,
            ]);
        
    }




    public function store(Request $request)
    {

        $sDateEdit      = $request->input('sDateEdit');     // วันที่จะแก้ไข
        $sSafety_code   = $request->input('safety_code');
        $note           = $request->input('note');
        $iMsCheck       = $request->input('msCheck');      // เมลผู้รายงาน
        $iSafety_id       = $request->input('safety_id');      // เมลผู้รายงาน

        $approve        = Tracking::findOrFail($iSafety_id);
        $token          = $approve->login_token;

        // token หมดอายุ
        if (now()->greaterThan($approve->token_expires_at)) {
             return response()->json([
                'message' => 'ลิงก์หมดอายุแล้ว',
                'class'   => 'error',
            ]);
        }

        // =========================
        // 1) อัปเดตผลของ SHE-Plant
        // =========================
        $todaySend = Carbon::now()->format('Ymd');
        $approve->assign_status       =  $iMsCheck; // 1=อนุมัติ/แก้ไขแล้ว อนุมัติ
        $approve->assign_solve_date   =  $sDateEdit; // วันที่กำหนดเสร็จ
        $approve->assign_solve_detail =  $note; // แนวทางรายละเอียดการแก้ไข
        $approve->updated_at           =  Carbon::now(); // วันที่แก้ไข
        if ($iMsCheck == 1) {
            $approve->she_success_date  = Carbon::now(); // วันที่แก้ไขสำเร็จ 
        }

        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('images/head_solve_img', $filename, 'public');
                $approve->assign_solve_img = $path ;                 
            }
        } 
        



        try {
            $isSaved = $approve->save();

            if (!$isSaved) {
                return response()->json([
                    'message' => 'บันทึกสถานะ SHE-Plant ไม่สำเร็จ',
                    'class'   => 'error'
                ]);
            }

            $safety = Safety::where('safety_code', $approve->safety_code)->first();
            if (!$safety) {
                 return response()->json([
                    'message' => 'ไม่พบข้อมูลรายงานหลัก (safety_report)',
                    'class'   => 'error',
                ]);
            }
         
            $safety->safety_status = 2;    // 2 = ส่งต่อ SHE-Plant
            if ($request->hasFile('files')) {
                // foreach ($request->file('files') as $file) {
                //     $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                //     $path = $file->storeAs('images/head_solve_img', $filename, 'public');
                    $safety->report_img_after = $path;
                // }
            }
           
            $safety->save();
            
            $plantCode = $safety->location_view; // เช่น   BGC 
          
            // **ตรงนี้ให้เช็คในตาราง approver_role_master ว่า role_code จริงชื่ออะไร**       
            $sheApprover = ApproverHelper::getApproversByPlantCode($plantCode);

            // dd($sheApprover);

            if (!$sheApprover) {
              return response()->json([
                    'message' => 'ไม่พบผู้รับผิดชอบ SHE-Plant ของ ' . $plantCode,
                    'class'   => 'error',
                ]);
            }

            $link = route('sheapprove.magic.login', ['token' => $token]);

            $data = [
                'headname'      => $sheApprover['she']->emp_name, // คนที่จะได้รับเรื่อง (SHE-Plant)
                'name'          => $safety->report_name,
                'sDateEdit'     => $sDateEdit ?? $todaySend,
                'remark'        => 'เหตุการณ์ไม่ปลอดภัยได้รับการแก้ไขเรียบร้อยแล้ว',
                'safety_code'   => $approve->safety_code,
                'link'          => $link,
                'safety_status' => $safety->safety_status,
            ];

            MailHelper::sendExternalMail(
               $sheApprover['she']->emp_email,
                'แจ้งการรายงาน Magic Finger ให้ SHE-Plant',
                'mails.notify_assign_edit',   // หรือ mails.notify_she_end ถ้าแยก template
                $data,
                'Magic Finger System'
            );

             return response()->json([
                'message' => 'บันทึกผลอนุมัติเรียบร้อย และส่งเมลให้ SHE-Plant แล้ว',
                'class'   => 'success',
            ]);


            // เช็คว่ามี field ถูกเปลี่ยนจริงไหม
            if (!$approve->wasChanged()) {
                logger("Approve updated but no fields actually changed");
             }
         } catch (\Exception $e) {
             return response()->json([
              'message' => 'เกิดข้อผิดพลาด : ' . $e->getMessage(),
              'class'   => 'error'
           ]);
         }
      }

   
}
