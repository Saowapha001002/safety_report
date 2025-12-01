<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cause extends Model
{
    protected $table = 'safety_cause';
    protected $fillable = ['cause','status'];
}


