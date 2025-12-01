<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::table('plant_master', function (Blueprint $table) {

         if (!Schema::hasColumn('plant_master', 'status')) {
            $table->tinyInteger('status')
                  ->default(1);
        }

        if (!Schema::hasColumn('plant_master', 'deleted')) {
            $table->tinyInteger('deleted')
                  ->default(0)
                  ->after('status');
        }

       

        
    });
}
};
