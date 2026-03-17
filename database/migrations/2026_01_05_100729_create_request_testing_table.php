<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_testing', function (Blueprint $table) {
            $table->id();
            $table->string('request_type');

            $table->string('customer_id', 100);
            $table->foreign('customer_id')->references('customer_id')->on('customers_info')->onDelete('cascade');

            // Old values
            $table->string('old_customer_name')->nullable();
            $table->string('old_tariff')->nullable();
            $table->string('old_bandwidth')->nullable();
            $table->string('old_pppoe')->nullable();
            $table->string('old_pw')->nullable();
            $table->string('old_router')->nullable();

            // New values
            $table->string('new_customer_name')->nullable();
            $table->string('new_tariff')->nullable();
            $table->string('new_bandwidth')->nullable();
            $table->string('new_pppoe')->nullable();
            $table->string('new_pw')->nullable();
            $table->string('new_router')->nullable();

            $table->date('request_date')->nullable();
            $table->date('end_testing_date')->nullable();
            $table->string('remark')->nullable();
            $table->string('status'); // Assuming this is a typo and should be 'time_lapse'

            $table->string('created_by')->nullable();   // Who created the request

            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('request_testing');
    }
};
