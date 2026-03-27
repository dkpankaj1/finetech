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
        Schema::create('fixed_deposits', function (Blueprint $table) {
            $table->id();
            $table->string('fd_number', 30)->unique();

            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('currency_id')->constrained('currencies');

            $table->decimal('principal_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->unsignedInteger('tenure_months');
            $table->decimal('maturity_amount', 15, 2);

            $table->enum('status', ['active', 'matured', 'closed', 'premature_closed'])->default('active');
            $table->date('opened_at');
            $table->date('maturity_date');
            $table->date('closed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();

            $table->index(['account_id', 'status']);
            $table->index(['status', 'maturity_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_deposits');
    }
};
