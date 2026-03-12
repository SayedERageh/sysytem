<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            // إضافة الحقول الجديدة لتسجيل الدخول
            if (!Schema::hasColumn('doctors', 'email')) {
                $table->string('email')->nullable()->after('name');
            }
            if (!Schema::hasColumn('doctors', 'password')) {
                $table->string('password')->nullable()->after('email');
            }
            if (!Schema::hasColumn('doctors', 'remember_token')) {
                $table->rememberToken()->nullable()->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['email', 'password', 'remember_token']);
        });
    }
};