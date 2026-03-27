<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CurrencySeeder::class);
        $this->call(SystemSettingSeeder::class);
        $this->call(RolePermissionSeeder::class);

        # Create default super admin user 
        $superuser = User::create([
            'name' => 'Finetech admin',
            'email' => 'finetech@gmail.com',
            'password' => bcrypt('finetech123'),
        ]);
        $superuser->assignRole('super_admin');

        # Create default admin user
        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user123'),
        ]);
        $user->assignRole('admin');

        $this->call(TestDataSeeder::class);

    }
}
