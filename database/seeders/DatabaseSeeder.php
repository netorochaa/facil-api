<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'christian.ramires@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            CitySeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
        ]);
    }
}
