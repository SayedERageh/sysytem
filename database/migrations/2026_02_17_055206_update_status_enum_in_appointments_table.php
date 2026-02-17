<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // خطوة 1: تحديث أي قيمة عربية موجودة للإنجليزي
        DB::table('appointments')->update([
            'status' => DB::raw("
                CASE
                    WHEN status = 'لم ياتي' THEN 'absent'
                    WHEN status = 'في الانتظار' THEN 'pending'
                    WHEN status = 'تم الكشف' THEN 'done'
                    ELSE status
                END
            ")
        ]);

        // خطوة 2: تعديل ENUM في الجدول
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['absent', 'pending', 'done'])->default('pending')->change();
        });
    }

    public function down(): void
    {
        // التراجع: ترجمة القيم الإنجليزية للعربية
        DB::table('appointments')->update([
            'status' => DB::raw("
                CASE
                    WHEN status = 'absent' THEN 'لم ياتي'
                    WHEN status = 'pending' THEN 'في الانتظار'
                    WHEN status = 'done' THEN 'تم الكشف'
                    ELSE status
                END
            ")
        ]);

        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('status', ['لم ياتي', 'في الانتظار', 'تم الكشف'])->default('في الانتظار')->change();
        });
    }
};
