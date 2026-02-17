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
    Schema::create('lab_requests', function (Blueprint $table) {
        $table->id();

        $table->foreignId('lab_id')
              ->constrained('labs')
              ->onDelete('cascade');

        $table->foreignId('patient_id')
              ->constrained('patients')
              ->onDelete('cascade');

        $table->foreignId('appointment_id')
              ->nullable()
              ->constrained('appointments')
              ->nullOnDelete();

        $table->string('request_name');

        $table->enum('status', [
            'تم الطلب',
            'تم الاستلام',
            'تم الرفض'
        ])->default('تم الطلب');

        $table->decimal('price',10,2)->default(0);
        $table->decimal('paid',10,2)->default(0);
        $table->decimal('remaining',10,2)->default(0);

        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_requests');
    }
};
