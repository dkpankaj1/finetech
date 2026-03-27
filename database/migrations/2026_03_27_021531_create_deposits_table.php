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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('currency_id')->constrained('currencies');

            $table->string('reference_no', 30)->unique();
            $table->decimal('amount', 15, 2);
            $table->enum('source', ['cash', 'bank_transfer', 'cheque', 'online', 'other'])->default('cash');
            $table->text('remarks')->nullable();
            $table->timestamp('deposited_at');
            $table->foreignId('deposited_by')->constrained('users');

            $table->timestamps();

            $table->index(['account_id', 'deposited_at']);
            $table->index(['customer_id', 'deposited_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
