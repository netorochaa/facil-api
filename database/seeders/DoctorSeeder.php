<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\City;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::factory()->count(10)
            ->has(Appointment::factory()->count(rand(4, 20)))
            ->has(City::factory()->count(5))
            ->create();
    }
}
