<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
       
            if (!Schema::hasColumn('appointments', 'teeth_length')) {
                $table->string('teeth_length')->nullable()->after('teeth_number'); // طول السنة
            }
            if (!Schema::hasColumn('appointments', 'next_session')) {
                $table->text('next_session')->nullable()->after('teeth_length'); // كلام الجلسة القادمة
            }
            if (!Schema::hasColumn('appointments', 'notes')) {
                $table->text('notes')->nullable()->after('next_session'); // ملاحظات عامة
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'teeth_length',
                'next_session',
                'notes',
            ]);
        });
    }
};