<?php

namespace App\Http\Controllers\Back;
 
use App\Http\Controllers\Controller;
use App\Models\Cause;
use App\Models\Event;
use App\Models\Rank;
use App\Models\Safety;
use App\Models\Tracking;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            //   dd($Cause);
            // $Cause = Cause::where('id', $Safety->cause_id)->first();  
            // $Event = Event::where('id', $Safety->event_id)->first();  
            $Rank = Rank::where('id', $Safety->rank_id)->first();  
            $selectedCauseId  = $Safety->cause_id ;  
            $selectedEventId  = $Safety->event_id ;  

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
 
            
        return view('back.checkmagicfinger.checkmagicfinger', compact('Tracking', 'Safety', 'selectedCauseId', 'selectedEventId', 'Cause','Event','Rank', 'Class_rank'
        ,'Class_rank_label','exMail', 'exName'));
            
       
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
