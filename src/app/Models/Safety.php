<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Safety extends Model
{
    protected $table = 'safety_report';
    protected $fillable = [
    'safety_code',
    'report_empid',
    'report_name', 
    'report_email',
    'report_tel',
    'report_department', 
    'report_plant',
    'report_date',
    'location_view',
    'location_dept_view',
    'cause_id',
    'event_id',
    'event_note',
    'report_detail',
    'report_img_before',
    'solve_status',
    'solve_date',
    'safety_status',
    'report_img_after',
    'rank_id',
    'suggestion', 
    'status'];
}
