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
        Schema::create('customers_info', function (Blueprint $table) {
            $table->string('customer_id', 100)->primary(); // Primary Key
            $table->string('customer_name', 120);
            $table->string('phone_number', 20)->nullable();
            $table->string('pppoe', 100)->nullable();
            $table->string('province', 50)->nullable();
            $table->string('address_line_1');
            $table->string('currency');
            $table->string('internet_fee');
            $table->string('ip_fee');
            $table->integer('ip_quantity');
            $table->integer('bill_cycle');
            $table->string('alt_customer_name');
            $table->string('lat_long', 50)->nullable();
            $table->string('alt_address_line_1');
            $table->string('agent');
            $table->string('tariff_name');
            $table->string('bandwidth');
            $table->string('installation_fee');

            // Optional fields            
            $table->date('first_start_date');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('complete_date')->nullable();
            $table->string('status')->default('Active');
            
            // Custom fields for tracking
            $table->timestamp('last_updated')->nullable();
            $table->integer('update_attempts')->default(0);
            $table->string('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('updated_by')->nullable();
            $table->integer('number_of_invoices')->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers_info');
    }
};