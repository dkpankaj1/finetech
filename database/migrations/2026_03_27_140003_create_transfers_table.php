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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no', 30)->unique();

            $table->foreignId('source_account_id')->constrained('accounts');
            $table->foreignId('source_customer_id')->constrained('customers');
            $table->foreignId('source_branch_id')->constrained('branches');
            $table->foreignId('currency_id')->constrained('currencies');

            $table->enum('transfer_type', ['internal', 'external']);
            $table->foreignId('destination_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->string('destination_bank_name')->nullable();
            $table->string('destination_account_number')->nullable();
            $table->string('destination_ifsc')->nullable();
            $table->string('beneficiary_name')->nullable();

            $table->decimal('amount', 15, 2);
            $table->text('remarks')->nullable();
            $table->timestamp('transferred_at');
            $table->foreignId('transferred_by')->constrained('users');

            $table->foreignId('source_transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->foreignId('destination_transaction_id')->nullable()->constrained('transactions')->nullOnDelete();

            $table->timestamps();

            $table->index(['source_account_id', 'transferred_at']);
            $table->index(['transfer_type', 'transferred_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
