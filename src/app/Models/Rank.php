<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $table = 'safety_rank';
    protected $fillable = ['rank','rank_mening','rank_action','status','created_by'];

}
