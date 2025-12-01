<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('approver_role_master', function (Blueprint $table) {
            // ถ้าอยากให้เหมือนโครงตารางอื่น ๆ ของคุณ
            if (!Schema::hasColumn('approver_role_master', 'deleted')) {
                $table->tinyInteger('deleted')
                      ->default(0)
                      ->after('status');
            }

            if (!Schema::hasColumn('approver_role_master', 'created_by')) {
                $table->string('created_by', 50)
                      ->nullable()
                      ->after('deleted');
            }

            if (!Schema::hasColumn('approver_role_master', 'updated_by')) {
                $table->string('updated_by', 50)
                      ->nullable()
                      ->after('created_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('approver_role_master', function (Blueprint $table) {
            // เวลาย้อน migration จะลบ column พวกนี้ออก
            if (Schema::hasColumn('approver_role_master', 'updated_by')) {
                $table->dropColumn('updated_by');
            }
            if (Schema::hasColumn('approver_role_master', 'created_by')) {
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('approver_role_master', 'deleted')) {
                $table->dropColumn('deleted');
            }
        });
    }
};
