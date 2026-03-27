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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('currency_id')->constrained('currencies');

            $table->string('reference_no', 30)->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('source', ['cash', 'bank_transfer', 'cheque', 'online', 'other'])->default('cash');
            $table->text('remarks')->nullable();
            $table->timestamp('withdrawn_at');
            $table->foreignId('withdrawn_by')->constrained('users');

            $table->timestamps();

            $table->index(['account_id', 'withdrawn_at']);
            $table->index(['customer_id', 'withdrawn_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
