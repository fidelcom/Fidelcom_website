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
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@fidelcom.org')],
            ['name' => 'Admin', 'password' => bcrypt(env('ADMIN_PASSWORD', 'Change_Me_Before_Production')), 'role' => 'admin']
        );

        $this->call([
            InitialDataSeeder::class,
            FidelcomContentSeeder::class,
        ]);
    }
}
