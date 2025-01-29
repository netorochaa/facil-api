<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'cpf' => fake()->randomNumber(11),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
