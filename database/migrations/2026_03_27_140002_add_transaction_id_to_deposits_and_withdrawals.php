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
        Schema::table('deposits', function (Blueprint $table) {
            $table->foreignId('transaction_id')->nullable()->after('id')->constrained('transactions')->nullOnDelete();
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->foreignId('transaction_id')->nullable()->after('id')->constrained('transactions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('transaction_id');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropConstrainedForeignId('transaction_id');
        });
    }
};
