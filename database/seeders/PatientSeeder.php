<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        Patient::factory(10)
            ->has(Appointment::factory()->count(rand(4, 20)))
            ->create();
    }
}
