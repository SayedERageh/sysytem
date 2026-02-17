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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('patient_id')
              ->constrained('patients')
              ->onDelete('cascade');

        $table->foreignId('doctor_id')
              ->constrained('doctors')
              ->onDelete('cascade');

        $table->dateTime('appointment_date');

        $table->string('service_name');
        $table->decimal('service_price',10,2);

        // status
        $table->enum('status', [
            'لم ياتي',
            'في الانتظار',
            'تم الكشف'
        ])->default('في الانتظار');

        $table->foreignId('insurance_company_id')
              ->nullable()
              ->constrained('insurance_companies')
              ->nullOnDelete();

        $table->decimal('paid',10,2)->default(0);
        $table->decimal('remaining',10,2)->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
