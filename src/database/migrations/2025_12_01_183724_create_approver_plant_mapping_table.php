<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approver_plant_mapping', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('plant_id'); // FK -> plant_master.id
            $table->unsignedBigInteger('role_id');  // FK -> approver_role_master.id

            $table->string('emp_name', 255);
            $table->string('emp_email', 255);

            $table->tinyInteger('status')->default(1);   // 1 = active
            $table->tinyInteger('deleted')->default(0);  // 0 = not deleted

            $table->timestamps();

            $table->foreign('plant_id')
                  ->references('id')->on('plant_master')
                  ->onDelete('cascade');

            $table->foreign('role_id')
                  ->references('id')->on('approver_role_master')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approver_plant_mapping');
    }
};
