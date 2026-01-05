<?php

namespace App\Http\Controllers\Back;
 
use App\Http\Controllers\Controller;
use App\Models\Cause;
use App\Models\Event;
use App\Models\Rank;
use App\Models\Safety;
use App\Models\Tracking;
use App\Models\PlantMaster; 
use Illuminate\Support\Str;
 use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckMagicFingerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $safeties = Safety::where('status', 1)->get();
    
        foreach ($safeties as $safety) {
            $safety->status_text = match ($safety->safety_status) {
                1 => 'พนักงาน แจ้งเหตุ',
                2 => 'หัวหน้า ตรวจสอบแล้ว',
                3 => 'SHE ตรวจสอบแล้ว',
                default => 'ไม่ทราบสถานะ',
            };

          
        }
    
        return view('back.checkmagicfinger.list', compact('safeties'));
    }
  

 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Tracking = Tracking::findOrFail($id);   
        $exMail = '';
        $exName = '';
        $Cause = '';       

         if ($Tracking) {
            $Safety =  Safety::where('safety_code', $Tracking->safety_code)->first();
        }else if(!$Tracking){
            return response()->view('manager.manager_expired', [
                'message' => 'Token หมดอายุหรือไม่ถูกต้อง'
            ]);
        }     

        if($Safety){
            $Cause = Cause::get();  
            $Event = Event::all() ;  
            $Rank = Rank::where('id', $Safety->rank_id)->first();  
            $selectedCauseId  = $Safety->cause_id ;  
            $selectedEventId  = $Safety->event_id ;  
        }  

         $plants = PlantMaster::all();

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
            
            return view('back.checkmagicfinger.checkmagicfinger', compact('Tracking', 'Safety', 'selectedCauseId', 'selectedEventId', 'Cause','Event','Rank', 'Class_rank','plants' ,'Class_rank_label','exMail', 'exName'));
            
       
    }

 
    public function update(Request $request, $id)
    {
         
        $todaySuccess = Carbon::now()->format('Ymd');
        // 1. ค้นหาข้อมูลในตาราง safety_report
        $safety = Safety::findOrFail($id);
        // 2. อัปเดตข้อมูลตาราง safety_report (ส่วนที่ 1)
        $safety->location_view = $request->sLocation_view;
        $safety->cause_id      = $request->msCauseCheck;
        $safety->report_date   = $request->report_date;
        $safety->report_detail = $request->report_detail;     

        // จัดการกรณีเลือก Unsafe Action (ID: 2) เพื่อบันทึก LSR
        if ($request->msCauseCheck == 2) {
            $safety->event_id   = $request->event_id;
            $safety->event_note = ($request->event_id == 6) ? $request->event_note : null;
        } else {
            $safety->event_id   = null;
            $safety->event_note = null;
        }
        // 1.ส่งรายงาน 2.หัวหน้ารับเรื่อง แก้ไข 3. รับเรื่องแก้ไข 4. ส่งเมล์ถึงผู้จัดการโรงงานปิดงาน 
        if($request->assign_status == 1){

            $safety->safety_status = 2;   //หัวหน้ารับเรื่อง
            $safety->solve_status  = 1; // อัปเดตสถานะการแก้ไขเป็น "แก้ไขเรียบร้อยแล้ว"

        }elseif($request->she_status == 1){

            $safety->safety_status = 3; // อัปเดตสถานะเป็น "SHE ตรวจสอบแล้ว"
            $safety->solve_status  = 1; 
        }
        $safety->save();

        // 3. อัปเดตข้อมูลตาราง safety_tracking (อ้างอิงตาม safety_code)
        $tracking = Tracking::where('safety_code', $safety->safety_code)->first();
        
        if ($tracking) {
            // ส่วนที่ 2: สำหรับผู้จัดการ
            $tracking->assign_solve_detail = $request->manager_suggestion;
            $tracking->assign_solve_date   = $request->assign_solve_date;

            // ส่วนที่ 3: สำหรับ SHE
            $tracking->she_status          = $request->she_status;
            $tracking->she_suggestion      = $request->she_suggestion;
            $tracking->she_solve_date      = $request->she_solve_date;       


            if ($request->hasFile('assign_solve_img')) {
                foreach ($request->file('assign_solve_img') as $file) {
                    $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('images/head_solve_img', $filename, 'public');
                    $tracking->assign_solve_img = $path;                      
                    $tracking->assign_success_date  =  $todaySuccess;
                }
            }

            if ($request->hasFile('she_img')) {
                foreach ($request->file('she_img') as $file) {
                    $filename = Str::random() . '.' . $file->getClientOriginalExtension();
                    $pathShe = $file->storeAs('images/she_solve_img', $filename, 'public');
                    $tracking->she_solve_img = $pathShe;
                }

                $tracking->she_success_date  =  $todaySuccess;
            } 


         
            $tracking->save();
        }

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
