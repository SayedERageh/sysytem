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
    Schema::create('insurance_prices', function (Blueprint $table) {
        $table->id();
        $table->string('service_name');
        $table->decimal('service_price', 10, 2);

        $table->foreignId('insurance_company_id')
              ->constrained('insurance_companies')
              ->onDelete('cascade');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurance_prices');
    }
};
