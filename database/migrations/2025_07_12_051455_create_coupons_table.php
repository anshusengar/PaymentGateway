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
    $table->enum('type', ['fixed', 'percentage']);
    $table->decimal('value', 8, 2);

    // Rule-based fields
    $table->decimal('min_cart_value', 8, 2)->nullable();     // cart condition
    $table->boolean('is_new_user_only')->default(false);     // only for new users
    $table->json('applicable_categories')->nullable();       // category restriction
    $table->json('applicable_products')->nullable();         // product restriction
    $table->json('applicable_users')->nullable();            // optional for personalized
    $table->json('payment_methods')->nullable();             // ex: ["razorpay", "hdfc", "cod"]

    $table->dateTime('start_date')->nullable();
    $table->dateTime('end_date')->nullable();
    $table->integer('usage_limit')->nullable();
    $table->integer('per_user_limit')->nullable();
    $table->integer('used_count')->default(0);
    $table->enum('status', ['active', 'inactive'])->default('active');

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
