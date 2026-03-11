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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number', 20)->unique()->comment('Auto-generated');

            // Relations
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('account_type_id')->constrained('account_types');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('currency_id')->constrained('currencies');

            // Balance
            $table->decimal('opening_balance', 15, 2)->default(0.00);
            $table->decimal('current_balance', 15, 2)->default(0.00);

            // Status
            $table->enum('status', ['active', 'frozen', 'dormant', 'closed'])->default('active');
            $table->text('status_reason')->nullable()->comment('Freeze/close reason');

            // Dates
            $table->timestamp('last_transaction_at')->nullable();
            $table->date('opened_at');
            $table->date('closed_at')->nullable();

            // Staff
            $table->foreignId('opened_by')->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('customer_id');
            $table->index(['branch_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
