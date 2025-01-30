<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::factory()
            ->count(30)
            ->has(Doctor::factory()->count(rand(1, 4)))
            ->create();
    }
}
