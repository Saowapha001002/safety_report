<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproverPlantMapping extends Model
{
      protected $table = 'approver_plant_mapping';

    protected $fillable = [
        'plant_id',
        'role_id',
        'emp_name',
        'emp_email',
        'status',
        'deleted',
    ];

    public function plant()
    {
        return $this->belongsTo(PlantMaster::class, 'plant_id');
    }

    public function role()
    {
        return $this->belongsTo(ApproverRoleMaster::class, 'role_id');
    }
}
