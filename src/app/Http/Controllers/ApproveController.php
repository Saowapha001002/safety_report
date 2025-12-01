<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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



     /**
     * Display the specified resource.
     */
   public function store(Request $request)
{ 
    $todaySend = Carbon::now()->format('Ymd');
    $id = $request->input('safety_id');
    $approveEdit = Safety::where('id', $id)->first();                 
    $approveEdit->safety_status = 2;     // 2 = Assign approve ส่งต่อไปให้ SHE
             
    try {
        $event_save = $approveEdit->save();

        if ($event_save) {                
            $safety_code = $request->input('safety_code');
            $tracking = Tracking::where('safety_code', $safety_code)->first(); 

            if (!$tracking) {
                return response()->json([
                    'status'=> 500,
                    'success' => 'error',
                    'message' => 'ไม่พบข้อมูลการติดตาม'
                ]);
            } 

            // ----- อัปเดต tracking -----
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('images/head_solve_img', $filename, 'public');
                    // ถ้ามีหลายไฟล์จริง ๆ อาจต้องเก็บเป็น JSON / ตารางแยก
                    $tracking->assign_solve_img = $path;                 
                }
            } 

            $tracking->assign_success_date = $todaySend;
            $tracking->assign_solve_date   = $request->input('sDateEdit');
            $tracking->assign_status       = 1; 
            $tracking->save();

            // ----- เตรียมข้อมูลเมล -----
            $link = route('sheapprove.magic.login', ['token' => $tracking->login_token]);

            $data = [
                'headname'      => 'saowapha', // คนที่ส่งต่อ/แก้ไข
                'name'          => 'saowapha khemlueang', // user
                'departuredate' => $todaySend,
                'remark'        => 'เหตุการณ์ไม่ปลอดภัยได้รับการแก้ไขเรียบร้อยแล้ว',
                'safety_code'   => $tracking->safety_code,
                'link'          => $link,
                'safety_status' => $approveEdit->safety_status,
            ];

            // แนบไฟล์ (ถ้าต้องแนบรูปที่บันทึกไปด้วย)
            $attachments = [];
            if ($tracking->assign_solve_img) {
                $attachments[] = storage_path('app/public/' . $tracking->assign_solve_img);
            }

            // ----- ส่งเมลแบบ queue -----
            MailHelper::queueSafetyMail(
                // ส่งได้หลายคน: ใส่เป็น array
                $to  = ['saowapha.k@bgiglass.com'],   // ปรับทีหลังให้ใช้เมล SHE จริง
                $cc  = null,                          // หรือ ['xxx@bgc.co.th']
                $bcc = null,
                $subject     = 'แจ้งการรายงาน Magic Finger SHE',
                $view        = 'mails.notify_assign_edit', // ใช้ template เดิมได้เลย
                $viewData    = $data,
                $attachments = $attachments
            );

            return response()->json([
                'status'=> 200,
                'success' => 'success',
                'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว'
            ]);

        } else {
            return response()->json([
                'status'=> 500,
                'success' => 'error',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้'
            ]);
        }

    } catch (\Exception $e) {
        return response()->json([
            'status'=> 500,
            'success' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}


    public function confirm(Request $request, $id)
    {
        $approve = Tracking::findOrFail($id);
        $action = $request->input('action');
        $reason = $request->input('reason');
        $typeapprove = $request->input('typeapprove');
        $expenseempid = $request->input('expenseempid');
        $departuredate = $request->input('departuredate');
        $approvename = $request->input('approvename');
        $expenseid = $request->input('expenseid');
        $empemail = $request->input('empemail');
        $empfullname = $request->input('empfullname');

        if ($approve->statusapprove !== 0) {
            return back()->with([
                'message' => 'คุณได้ดำเนินการไปแล้ว',
                'class' => 'error'
            ]);
        }

        if (now()->greaterThan($approve->token_expires_at)) {
            return back()->with([
                'message' => 'ลิงก์หมดอายุแล้ว',
                'class' => 'error'
            ]);
        }

        if ($action === 'reject' && empty($reason)) {
            return back()->with([
                'message' => 'กรุณากรอกเหตุผลที่ไม่อนุมัติ',
                'class' => 'error'
            ]);
        }

        $approve->statusapprove = $request->action === 'approve' ? 1 : 2;
        $approve->remark = $reason; // หรือ reject_reason
        $approve->save();

        // ✅ ส่งเมลเฉพาะกรณี reject
        if ($request->action === 'reject') {
            $data = [
                'headname' => $approvename, // คนที่ reject
                'name' => $empfullname, // user
                'expenseid' => $approve->exid, //exid
                'departuredate' => $departuredate,
                'remark' => $reason,
            ];

            MailHelper::sendExternalMail(
                $empemail, // ผู้รับ คือ ผู้ขอเบิก
                'แจ้งผลการไม่อนุมัติการเบิกเบี้ยเลี้ยง',
                'mails.reject', // ชื่อ blade view mail
                $data,
                'Expense Claim System EX' . $approve->exid,
            );
        }

        $nextempid = '';
        $nextemail = '';
        $nextfullname = '';

        if ($approve->typeapprove == 4 || $approve->typeapprove == 2) {
            // ✅ หากอนุมัติสำเร็จ สร้าง approve ถัดไป
            if ($approve->statusapprove === 1) {
 
                $nextempid = '66000510';
                $nextemail = 'kamolwan.b@bgiglass.com';
                $nextfullname = 'กมลวรรณ บรรชา';
                // ตั้งค่าข้อมูลผู้อนุมัติถัดไป (HR ผุู้จัดการฝ่าย)
                if($approve->typeapprove == 2){
                    $nextType = 1;
                }else{
                    $nextType = $approve->typeapprove + 1;
                }


                $token = Str::random(64);
                $nextApprove = Tracking::create([
                    'exid' => $approve->exid,
                    'typeapprove' => $nextType,
                    'empid' => $nextempid,
                    'email' => $nextemail,
                    'approvename' => $nextfullname,
                    'emailstatus' => 1,
                    'statusapprove' => 0,
                    'login_token' => $token,
                    'token_expires_at' => now()->addDays(10),
                ]);

                // ✅ ส่งอีเมลลิงก์อนุมัติรอบถัดไป
                $link = route('approve.magic.login', ['token' => $token]);

                $data = [
                    'type' => $nextType,
                    'title' => 'แจ้งเตือนการอนุมัติการเบิกเบี้ยเลี้ยง',
                    'name' => $nextfullname,
                    'full_name' => $empfullname,
                    'departuredate' => $departuredate ?? '',
                    'check_hr' => $approvename,
                    'link' => $link,
                ];

                MailHelper::sendExternalMail(
                    $nextemail,
                    'อนุมัติการเบิกเบี้ยเลี้ยง',
                    'mails.hrheadapprove',
                    $data,
                    'Expense Claim System EX' . $approve->exid,
                );
            }
        }

        if($approve->typeapprove == 5 && $approve->statusapprove === 1){
            // อนุมัติขั้นตอนสุดท้ายเสร็จ
            // $linksuccess = route('approve.magic.login', ['token' => $token]);

            $data = [
                'type' => 5,
                'title' => 'แจ้งเตือนการอนุมัติการเบิกเบี้ยเลี้ยง',
                'name' => $empfullname,
                'full_name' => $empfullname,
                'departuredate' => $departuredate ?? '',
            ];

            MailHelper::sendExternalMail(
                $empemail,
                'อนุมัติการเบิกเบี้ยเลี้ยง',
                'mails.success',
                $data,
                'Expense Claim System EX' . $approve->exid,
            );
        }

        return back()->with([
            'message' => 'บันทึกผลอนุมัติเรียบร้อย',
            'class' => 'success'
        ]);
    }

 
}
