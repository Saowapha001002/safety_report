<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproverRoleMaster extends Model
{
    protected $table = 'approver_role_master';
    protected $fillable = ['role_code', 'role_name', 'status'];

    public function mappings()
    {
        return $this->hasMany(ApproverPlantMapping::class, 'role_id');
    }
}
