<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('teeth_procedures', function (Blueprint $table) {
    $table->id();
    $table->foreignId('patient_id')->constrained()->cascadeOnDelete(); 
    $table->text('tooth_number'); // رقم السن
    $table->string('procedure')->nullable();               // نوع الإجراء الحالي
    $table->text('notes')->nullable();         // ملاحظات الإجراء الحالي
    $table->string('next_procedure')->nullable();  // الإجراء المخطط للزيارة القادمة
    $table->text('next_notes')->nullable();       // ملاحظات الزيارة القادمة
    $table->string('w_l', 5, 2)->nullable();     // طول العصب (Root Length)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teeth_procedures');
    }
};
