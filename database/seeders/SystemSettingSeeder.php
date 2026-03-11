<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::updateOrCreate(
            ['id' => 1],
            [
                'language' => 'en',
                'timezone' => 'UTC',
                'date_format' => 'Y-m-d',
                'time_format' => 'H:i:s',
                'currency_id' => 1, // Assuming USD is the default currency
                'decimal_separator' => '.',
                'thousands_separator' => ',',
                'decimal_places' => 2,
                'session_timeout' => 60,
                'max_login_attempts' => 5,
                'enable_two_factor' => 0,
                'per_page' => 25,
                'enable_maintenance' => 0,
                'maintenance_message' => null
            ]
        );
    }
}
