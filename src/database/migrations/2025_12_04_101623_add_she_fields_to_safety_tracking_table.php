<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSheFieldsToSafetyTrackingTable extends Migration
{
    public function up()
    {
        Schema::table('safety_tracking', function (Blueprint $table) {
            $table->string('she_id', 20)->nullable()->after('assign_email');
            $table->string('she_name', 255)->nullable()->after('she_id');
            $table->string('she_email', 255)->nullable()->after('she_name');
        });
    }

    public function down()
    {
        Schema::table('safety_tracking', function (Blueprint $table) {
            $table->dropColumn(['she_id', 'she_name', 'she_email']);
        });
    }
}
