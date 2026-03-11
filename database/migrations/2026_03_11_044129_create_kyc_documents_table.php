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
        Schema::create('kyc_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            // Document Details
            $table->enum('document_type', [
                'national_id',
                'passport',
                'driving_license',
                'voter_id',
                'aadhaar',
                'pan_card'
            ]);
            $table->string('document_number');
            $table->string('front_image')->comment('File path');
            $table->string('back_image')->nullable()->comment('File path');
            $table->date('expiry_date')->nullable();

            // Review
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('remark')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_documents');
    }
};
