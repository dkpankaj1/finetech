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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 30)->unique();

            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('currency_id')->constrained('currencies');

            $table->enum('transaction_type', ['deposit', 'withdrawal', 'transfer_out', 'transfer_in']);
            $table->enum('source', ['cash', 'bank_transfer', 'cheque', 'online', 'other', 'internal_transfer', 'external_transfer'])->default('other');

            $table->decimal('amount', 15, 2);
            $table->decimal('opening_balance', 15, 2);
            $table->decimal('closing_balance', 15, 2);

            $table->text('remarks')->nullable();
            $table->timestamp('transacted_at');
            $table->foreignId('created_by')->constrained('users');

            $table->nullableMorphs('transactionable');

            $table->foreignId('counterparty_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->string('counterparty_bank_name')->nullable();
            $table->string('counterparty_account_number')->nullable();
            $table->string('counterparty_ifsc')->nullable();

            $table->timestamps();

            $table->index(['account_id', 'transacted_at']);
            $table->index(['transaction_type', 'transacted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
