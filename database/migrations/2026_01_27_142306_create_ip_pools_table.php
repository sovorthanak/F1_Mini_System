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
        Schema::create('ip_pools', function (Blueprint $table) {
            $table->id();

            $table->string('name', 80);                 // e.g. "PPPoE Phnom Penh"
            $table->string('cidr', 32)->unique();       // e.g. "10.175.6.0/24"
            $table->boolean('is_active')->default(true); // better than visible for ops

            $table->text('description')->nullable();

            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();

            $table->timestamps();

            $table->index(['is_active']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_pools');
    }
};
