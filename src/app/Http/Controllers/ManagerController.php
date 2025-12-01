<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use App\Models\Event;
use App\Models\Rank;
use App\Models\Safety;
use App\Models\Tracking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ManagerController extends Controller
{
    public function index()
    {         
        return view('manager.manager');


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
            return response()->view('manager.manager_expired', [
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
 

        return view('manager.manager', compact('Tracking', 'Safety', 'Cause','Event','Rank', 'Class_rank','Class_rank_label','exMail', 'exName'))
            ->with([
                'nextempid' => $nextempid,
                'nextemail' => $nextemail,
                'nextfullname' => $nextfullname,
                'nextStepApprove' => $nextStepApprove,
            ]);
       
    }

}
