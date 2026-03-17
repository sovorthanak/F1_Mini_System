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
        Schema::create('ip_inventory', function (Blueprint $table) {
            $table->id();

            $table->string('ip_address', 45); // rename from "ip" (better) + IPv6 safe

            // Pool FK (standard)
            $table->foreignId('ip_pool_id')
                ->constrained('ip_pools')
                ->cascadeOnDelete();

            // Customer FK (string key)
            $table->string('customer_id', 100)->nullable();
            $table->foreign('customer_id')
                ->references('customer_id')
                ->on('customers_info')
                ->nullOnDelete(); // safer than cascade

            $table->enum('status', ['free','assigned','reserved','blocked'])->default('free');
            $table->string('note', 255)->nullable();

            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();

            $table->timestamps();

            $table->unique(['ip_pool_id', 'ip_address']);   
            $table->index(['ip_pool_id', 'status']); 
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_inventory');
    }
};
