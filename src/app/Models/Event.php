<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'safety_event';
    protected $fillable = ['event','event_note','status'];
}
