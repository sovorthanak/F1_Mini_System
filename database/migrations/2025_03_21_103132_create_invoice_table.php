<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('invoice_id', 10)->primary(); // Custom primary key
            $table->string('customer_id', 100); // Must match customers.id
            $table->string('customer_name', 120);
            $table->string('address_line_1');
            $table->string('alt_customer_name');
            $table->string('alt_address_line_1');
            $table->string('tariff_name');
            $table->string('internet_fee');
            $table->integer('bill_cycle');
            $table->string('installation_or_not')->nullable();
            $table->string('installation_fee')->nullable();
            $table->integer("installation_quantity")->nullable();
            $table->string('ip_fee');
            $table->integer("ip_quantity");

            $table->decimal('total_amount', 10, 2);
            $table->string('payment_status')->default('Unpaid');
            $table->timestamp('payment_date')->nullable(); // Nullable for unpaid invoices

            $table->date('start_date');
            $table->date('end_date')->nullable();
            
            // Custom fields for tracking
            $table->timestamp('last_updated')->nullable();
            $table->integer('update_attempts')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();

            // ✅ Define foreign key constraints
            $table->foreign('customer_id')->references('customer_id')->on('customers_info')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }

};
