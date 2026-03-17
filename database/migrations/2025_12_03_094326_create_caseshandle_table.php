<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cases_handle', function (Blueprint $table) {
            $table->id('case_id');

            $table->string('case_type');

            $table->string('customer_id', 100);
            $table->foreign('customer_id')->references('customer_id')->on('customers_info')->onDelete('cascade');

            $table->string('status')->default('Pending');

            $table->date('create_date')->nullable();
            $table->text('remark')->nullable();
            $table->date('deadline')->nullable();
            $table->date('complete_date')->nullable();

            // normal fields
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();

            // custom audit fields
            $table->timestamp('last_updated')->nullable();
            $table->integer('update_attempts')->default(0);

            // timestamps
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases_handle');
    }
};
