<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'patient_id' => Patient::factory(),
            'date' => $this->faker->dateTimeBetween('-1 month', '+1 year')->format('Y-m-d H:i:s'),
        ];
    }
}
