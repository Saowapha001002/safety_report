<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'safety_tracking';
    protected $fillable = [
        'safety_code',
        'report_date',
        'assign_id',
        'assign_name',
        'assign_email',
        'assign_status',
        'assign_success_date',
        'assign_solve_img',
        'assign_solve_date',
        'assign_solve_detail',
        'she_status',
        'she_solve_img',
        'she_success_date',
        'she_solve_date',
        'she_suggestion',
        'status' ,
        'created_by',
        'modified_by',
        'status',
        'deleted',
        'login_token',
        'token_expires_at',
        'remark'
];
}
