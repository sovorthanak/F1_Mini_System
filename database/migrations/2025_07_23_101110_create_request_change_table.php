<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestChangeTable extends Migration
{
    public function up()
    {
        Schema::create('request_change', function (Blueprint $table) {
            $table->id();
            $table->string('request_type');

            $table->string('customer_id', 100);
            $table->foreign('customer_id')->references('customer_id')->on('customers_info')->onDelete('cascade');

            // Old values
            $table->string('old_customer_name')->nullable();
            $table->string('old_tariff')->nullable();
            $table->string('old_bandwidth')->nullable();
            $table->decimal('old_internet_fee', 10, 2)->nullable();
            $table->string('old_address')->nullable();
            $table->string('old_alt_address')->nullable();
            $table->string('old_ip_address')->nullable();
            $table->string('old_province')->nullable();
            $table->string('old_pppoe')->nullable();
            $table->string('old_pw')->nullable();
            $table->string('old_customer_status')->nullable();
            $table->string('old_router')->nullable();
            $table->text('old_remark')->nullable();

            // New values
            $table->string('new_customer_name')->nullable();
            $table->string('new_tariff')->nullable();
            $table->string('new_bandwidth')->nullable();
            $table->decimal('new_internet_fee', 10, 2)->nullable();
            $table->string('new_address')->nullable();
            $table->string('new_alt_address')->nullable();
            $table->string('new_ip_address', 1000)->nullable();
            $table->string('new_province')->nullable();
            $table->string('new_pppoe')->nullable();
            $table->string('new_pw')->nullable();
            $table->string('new_customer_status')->nullable();
            $table->string('new_router')->nullable();
            $table->text('new_remark')->nullable();

            $table->date('date')->nullable();
            $table->string('status'); // Assuming this is a typo and should be 'time_lapse'

            $table->string('created_by')->nullable();   // Who created the request
            $table->string('approved_by')->nullable();  // Who approved the request

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_change');
    }
}