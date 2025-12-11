<?php

namespace App\Helpers;

use App\Models\PlantMaster;
use App\Models\ApproverPlantMapping;

class ApproverHelper
{
    /**
     * ดึงผู้อนุมัติของ Plant ตาม plant_code
     * คืน ['manager' => ApproverPlantMapping|null, 'she' => ApproverPlantMapping|null]
     *
     * @param  string  $plantCode   เช่น 'BGPU', 'BGC01', ...
     * @return array{manager: ?\App\Models\ApproverPlantMapping, she: ?\App\Models\ApproverPlantMapping}
     */
    public static function getApproversByPlantCode(string $plantCode): array
    {
        // หา plant จาก plant_code
        $plant = PlantMaster::where('plant_code', $plantCode)->first();

        if (!$plant) {
            return [
                'manager' => null,
                'she'     => null,
            ];
        }

        // Manager (role_id = 1)
        $manager = ApproverPlantMapping::where('plant_id', $plant->id)
            ->where('role_id', 1)         // 1 = Manager
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();

        // SHE (role_id = 2)
        $she = ApproverPlantMapping::where('plant_id', $plant->id)
            ->where('role_id', 2)         // 2 = SHE
            ->where('status', 1)
            ->where('deleted', 0)
            ->first();

        return compact('manager', 'she');
    }
}
