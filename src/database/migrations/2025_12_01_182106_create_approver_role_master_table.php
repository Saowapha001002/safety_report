<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('approver_role_master', function (Blueprint $table) {
            $table->id();
            $table->string('role_code', 20)->unique();   // MANAGER, SHE
            $table->string('role_name', 100)->nullable(); // ชื่อไทย
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('approver_role_master');
    }
};
