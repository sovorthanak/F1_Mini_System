<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->id(); // ✅ Auto-increment primary key

            $table->string('customer_id', 100);
            $table->string('ip_address', 50);   // the IP
            $table->integer('position')->default(1);

            // Custom audit fields
            $table->timestamp('last_updated')->nullable();
            $table->integer('update_attempts')->default(0);
            $table->string('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('updated_by')->nullable();

            $table->foreign('customer_id')
                ->references('customer_id')->on('customers_info')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_addresses');
    }
};
