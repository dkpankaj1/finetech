<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('e.g. Savings Account');
            $table->string('code')->unique()->comment('e.g. SAV, CUR, FD');

            // Rates & Limits
            $table->decimal('interest_rate', 5, 2)->default(0.00)->comment('Annual interest rate %');
            $table->decimal('minimum_balance', 15, 2)->default(0.00);
            $table->decimal('maximum_balance', 15, 2)->nullable();
            $table->decimal('daily_deposit_limit', 15, 2)->nullable();
            $table->decimal('daily_withdrawal_limit', 15, 2)->nullable();
            $table->unsignedInteger('monthly_free_transactions')->default(0);

            // Flags
            $table->boolean('requires_kyc')->default(true);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_types');
    }
};
