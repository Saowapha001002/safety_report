<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PlantMasterSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $plants = [
            ['plant_code' => 'AGI', 'plant_name' => 'AGI Plant'],
            ['plant_code' => 'AY1', 'plant_name' => 'AY1 Plant'],
            ['plant_code' => 'AY2', 'plant_name' => 'AY2 Plant'],
            ['plant_code' => 'BGC', 'plant_name' => 'BGC Plant'],
            ['plant_code' => 'BGCG', 'plant_name' => 'BGCG Plant'],
            ['plant_code' => 'BGPU', 'plant_name' => 'BGPU Plant'],
            ['plant_code' => 'BVP', 'plant_name' => 'BVP Plant'],
            ['plant_code' => 'Hospitality', 'plant_name' => 'Hospitality Business'],
            ['plant_code' => 'KBI', 'plant_name' => 'KBI Plant'],
            ['plant_code' => 'PGI', 'plant_name' => 'PGI Plant'],
            ['plant_code' => 'Prime', 'plant_name' => 'Prime Plant'],
            ['plant_code' => 'PTI', 'plant_name' => 'PTI Plant'],
            ['plant_code' => 'RBI', 'plant_name' => 'RBI Plant'],
        ];

        foreach ($plants as &$p) {
            $p['created_at'] = $now;
            $p['updated_at'] = $now;
        }

        DB::table('plant_master')->insert($plants);
    }
}
