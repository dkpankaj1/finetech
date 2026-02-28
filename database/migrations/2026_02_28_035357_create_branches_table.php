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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('name');
            $table->string('code')->unique()->comment('Unique branch code, e.g. BR001');
            $table->string('ifsc_code')->unique()->nullable()->comment('IFSC / routing code');
            $table->string('micr_code')->nullable()->comment('MICR code');
            $table->string('swift_code')->nullable()->comment('SWIFT/BIC for international transfers');

            // Location
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code', 20);
            $table->string('country')->default('India');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Contact
            $table->string('phone_number');
            $table->string('alternate_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();

            // Operations
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('manager_phone')->nullable();

            // Status
            $table->boolean('is_active')->default(true);
            $table->boolean('is_main_branch')->default(false);
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
