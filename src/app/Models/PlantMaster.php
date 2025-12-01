<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantMaster extends Model
{
    protected $table = 'plant_master';
    protected $fillable = ['plant_code', 'plant_name', 'status'];

    public function approvers()
    {
        return $this->hasMany(ApproverPlantMapping::class, 'plant_id');
    }
}
