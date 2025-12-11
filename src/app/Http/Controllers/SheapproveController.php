<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Models\Cause;
use App\Models\Event;
use App\Models\Rank;
use App\Models\Safety;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SheapproveController extends Controller
{
     public function index()
    {
         return view('sheapprove.sheapprove');
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
            return response()->view('sheapprove.sheapprove_expired', [
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
 

        return view('sheapprove.sheapprove', compact('Tracking', 'Safety', 'Cause','Event','Rank', 'Class_rank','Class_rank_label','exMail', 'exName'))
            ->with([
                'nextempid' => $nextempid,
                'nextemail' => $nextemail,
                'nextfullname' => $nextfullname,
                'nextStepApprove' => $nextStepApprove,
            ]);
       
    }



     /** 
     * SHE Solve Add Status AND Send to Manager PLANT
     * 2025-05-19
     * Saowapha.k
     */
    public function update(Request $request)
    {             
        $todaySend = Carbon::now()->format('Ymd');
        $id = $request->input('safety_id')  ;
       
        $approveEdit = Safety::where('id', $id)->first();                 
        $approveEdit->safety_status =  3 ; // 3 = SHE APPROVE ส่งไปให้ผู้จัดการโรงงาน 
             
            try {
               $event_save =  $approveEdit->save();
                if ($event_save) {                
                    $safety_code = $request->input('safety_code') ;
                    $tracking = Tracking::where('safety_code', $safety_code)->first(); 
                    if (!$tracking) {
                        return response()->json([
                            'status'=> 500,
                            'success' => 'error',
                            'message' => 'ไม่พบข้อมูลการติดตาม'
                            ]);
                    } 
                    if ($tracking) {             
                  
                        if ($request->hasFile('files')) {
                            foreach ($request->file('files') as $file) {
                                $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                                $path = $file->storeAs('images/she_solve_img', $filename, 'public');
                                $tracking->she_solve_img = $path ;                 
                            }
                        } 
                        $tracking->she_success_date      = $todaySend ; 
                        $tracking->she_solve_date        = $request->input('sDateEdit')  ;  //กำหนดเสร็จ 
                        $tracking->she_status            =  1 ; 
                        $tracking->she_suggestion        = $request->input('sSHESuggestion')  ; 
                        $tracking->save(); // ✅ ถูกต้อง 
                    } 
                   
                    // $link = route('manager.magic.login', ['token' => $tracking->login_token]);
                    // $data = [
                    //     'headname' => 'saowapha', // คนที่ reject
                    //     'name' => 'saowapha khemlueang', // user
                    //     'departuredate' => $todaySend ,
                    //     'remark' => 'เหตุการณ์ไม่ปลอดภัยได้รับการแก้ไขเรียบร้อยแล้ว',
                    //     'safety_code' => $tracking->safety_code,
                    //     'link' => $link,
                    //     'safety_status' => $approveEdit->safety_status,
                    // ];

                    // MailHelper::sendExternalMail(
                    //     'saowapha.k@bgiglass.com',
                    //     'แจ้งการรายงาน Magic Finger',
                    //     'mails.notify_she_end', // ชื่อ blade view mail
                    //     $data,
                    //     'แจ้งการรายงาน Magic Finger',
                    // );
                    
                    return response()->json([
                        'status'=> 200,
                        'success' => 'success',
                        'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว'
                        ]);

                } else {
                     try {
                        return response()->json([
                            'status'=> 500,
                            'success' => 'error',
                            'message' => 'ไม่สามารถบันทึกข้อมูลได้'
                            ]);
                    } catch (\Exception $e) {
                        return response()->json([
                            'status'=> 500,
                            'success' => 'error',
                            'message' => $e->getMessage()
                            ]);
                    }
                }
              

            } catch (\Exception $e) {
                return response()->json([
                    'status'=> 500,
                    'success' => 'error',
                    'message' => $e->getMessage()
                    ]);
                
            }
           
       
    }


   

 
}
