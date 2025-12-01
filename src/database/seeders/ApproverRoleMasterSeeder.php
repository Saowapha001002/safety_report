<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ApproverRoleMasterSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('approver_role_master')->insert([
            [
                'role_code' => 'MANAGER',
                'role_name' => 'ผู้จัดการโรงงาน',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'role_code' => 'SHE',
                'role_name' => 'SHE-Plant',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
