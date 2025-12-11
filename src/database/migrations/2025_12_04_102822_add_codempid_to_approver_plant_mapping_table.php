<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodempidToApproverPlantMappingTable extends Migration
{
    public function up()
    {
        Schema::table('approver_plant_mapping', function (Blueprint $table) {
            $table->string('codempid', 20)->nullable()->after('role_id');
        });
    }

    public function down()
    {
        Schema::table('approver_plant_mapping', function (Blueprint $table) {
            $table->dropColumn('codempid');
        });
    }
}
