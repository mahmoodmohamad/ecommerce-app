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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
             $table->string('code')->unique();
    $table->decimal('discount_amount', 8, 2)->nullable();
    $table->decimal('discount_percent', 5, 2)->nullable();
    $table->timestamp('expires_at')->nullable();
    $table->integer('usage_limit')->nullable();
    $table->integer('used')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
