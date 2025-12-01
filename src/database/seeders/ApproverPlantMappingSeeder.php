<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ApproverPlantMappingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ดึง role ของ Manager / SHE
        $managerRoleId = DB::table('approver_role_master')
            ->where('role_code', 'MANAGER')
            ->value('id');

        $sheRoleId = DB::table('approver_role_master')
            ->where('role_code', 'SHE')
            ->value('id');

        // Helper หา plant_id จาก plant_code
        $plantId = function (string $code) {
            return DB::table('plant_master')
                ->where('plant_code', $code)
                ->value('id');
        };

        // ===========================
        // รายชื่อ Manager + SHE ต่อ Plant
        // ===========================

        $data = [

            // =======================
            // AGI
            // =======================
            [
                'plant_code' => 'AGI',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณณัชฌกิตติ์ สิรสภัสกุล',
                'emp_email' => 'Nutthakit.S@bgc.co.th',
            ],
            [
                'plant_code' => 'AGI',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณปภัสวรรณ บรรดาศักดิ์',
                'emp_email' => 'Papassawan.B@bgc.co.th',
            ],

            // =======================
            // AY1
            // =======================
            [
                'plant_code' => 'AY1',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณอาจารวิทย์ วิวัฒรประชา',
                'emp_email' => 'jaruwit.w@bgp.co.th',
            ],
            [
                'plant_code' => 'AY1',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณอนัญญา พิพัฒน์',
                'emp_email' => 'ananya.phi@bgp.co.th',
            ],

            // =======================
            // AY2
            // =======================
            [
                'plant_code' => 'AY2',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณณัฐพล หนูชัยแก้ว',
                'emp_email' => 'Nattapon.N@bgc.co.th',
            ],
            [
                'plant_code' => 'AY2',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณกนกวรรณ เพียโคตรแก้ว',
                'emp_email' => 'Kanokwan.Ph@bgp.co.th',
            ],

            // =======================
            // BGC
            // =======================
            [
                'plant_code' => 'BGC',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณกิตติพงษ์ สกุลพานิช',
                'emp_email' => 'Kittipong.S@bgc.co.th',
            ],
            [
                'plant_code' => 'BGC',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณทิพมล นิลน้ำเงิน',
                'emp_email' => 'Thippamol.N@bgc.co.th',
            ],

            // =======================
            // BGCG
            // =======================
            [
                'plant_code' => 'BGCG',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณยศพนธ์ เพชรพีรฒ',
                'emp_email' => 'Yodsaphon.P@bgc.co.th',
            ],
            [
                'plant_code' => 'BGCG',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณเกษนก วิทยาขาว',
                'emp_email' => 'Gatganok.W@bgc.co.th',
            ],

            // =======================
            // BGPU
            // =======================
            [
                'plant_code' => 'BGPU',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณกิตติพงษ์ สกุลพานิช',
                'emp_email' => 'Kittipong.S@bgc.co.th',
            ],
            [
                'plant_code' => 'BGPU',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณสิริวิมล กองแก้ว',
                'emp_email' => 'Siriwimol.K@bgc.co.th',
            ],

            // =======================
            // BVP
            // =======================
            [
                'plant_code' => 'BVP',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณวรวุฒิ จุฑาภัทร์',
                'emp_email' => 'Worawoot.J@bgc.co.th',
            ],
            [
                'plant_code' => 'BVP',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณศิริประภา พุ่งจันทร์',
                'emp_email' => 'Siriprapa.P@bgc.co.th',
            ],

            // =======================
            // Hospitality
            // =======================
            [
                'plant_code' => 'Hospitality',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณกิตติพงษ์ สกุลพานิช',
                'emp_email' => 'Kittipong.S@bgc.co.th',
            ],
            [
                'plant_code' => 'Hospitality',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณศจี รมเพ็ง',
                'emp_email' => 'Sajee.R@bgc.co.th',
            ],

            // =======================
            // KBI
            // =======================
            [
                'plant_code' => 'KBI',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณศราวุธ บุญยอด',
                'emp_email' => 'Sarawoot.B@bgiqlass.com',
            ],
            [
                'plant_code' => 'KBI',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณภัทรวัฒน์ สิงหะสุริยะ',
                'emp_email' => 'Phattarawat.S@bgiqlass.com',
            ],

            // =======================
            // PGI
            // =======================
            [
                'plant_code' => 'PGI',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณนพรนิภาร์ อาริยรัตนากุล',
                'emp_email' => 'Nopthanin.A@bgc.co.th',
            ],
            [
                'plant_code' => 'PGI',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณกฤตานน อารมณ์สุข',
                'emp_email' => 'kittanon.A@bgc.co.th',
            ],

            // =======================
            // Prime
            // =======================
            [
                'plant_code' => 'Prime',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณสุรชาติ ดำเอี่ยม',
                'emp_email' => 'Surachart.D@bgc.co.th',
            ],
            [
                'plant_code' => 'Prime',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณจุฑามาศ โจงทอง',
                'emp_email' => 'Chuthamat.H@bgc.co.th',
            ],

            // =======================
            // PTI
            // =======================
            [
                'plant_code' => 'PTI',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณวิสูตร เครือภาน',
                'emp_email' => 'wisoot.k@bgc.co.th',
            ],
            [
                'plant_code' => 'PTI',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณประจักษ์ เหมปินส์นน์',
                'emp_email' => 'Prajuk.H@bgc.co.th',
            ],

            // =======================
            // RBI
            // =======================
            [
                'plant_code' => 'RBI',
                'role_id' => $managerRoleId,
                'emp_name' => 'คุณภิรมย์ ฉันททอง',
                'emp_email' => 'Phirom@bgc.co.th',
            ],
            [
                'plant_code' => 'RBI',
                'role_id' => $sheRoleId,
                'emp_name' => 'คุณปาริชาติ เอี่ยมจิต',
                'emp_email' => 'Parichat.A@bgc.co.th',
            ],
        ];

        // Mapping plant_id ลง database
        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'plant_id'   => $plantId($item['plant_code']),
                'role_id'    => $item['role_id'],
                'emp_name'   => $item['emp_name'],
                'emp_email'  => $item['emp_email'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('approver_plant_mapping')->insert($rows);
    }
}
