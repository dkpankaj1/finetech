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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            // ── Localisation ──────────────────────────────────────────────────
            $table->string('language')->default('en');
            $table->string('timezone')->default('UTC');
            $table->string('date_format')->default('Y-m-d');
            $table->string('time_format')->default('H:i:s');
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->nullOnDelete();
            $table->string('decimal_separator')->default('.');
            $table->string('thousands_separator')->default(',');
            $table->tinyInteger('decimal_places')->default(2);

            // ── Security ─────────────────────────────────────────────────────
            $table->integer('session_timeout')->default(60)->comment('minutes');
            $table->tinyInteger('max_login_attempts')->default(5);
            $table->tinyInteger('enable_two_factor')->default(0);

            // ── Pagination ───────────────────────────────────────────────────
            $table->tinyInteger('per_page')->default(25);

            // ── Maintenance ──────────────────────────────────────────────────
            $table->tinyInteger('enable_maintenance')->default(0);
            $table->string('maintenance_message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
