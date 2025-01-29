<?php

namespace Tests\Feature\Controllers;

use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_list_of_doctors()
    {
        Doctor::factory()->count(5)->create();

        $response = $this->getJson(route('doctors.index'));

        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }

    public function test_it_returns_a_list_of_doctors_with_search()
    {
        Doctor::factory()->count(5)->create();

        $doctor = Doctor::factory()->create(['name' => 'Test Doctor']);

        $response = $this->getJson(route('doctors.index', ['nome' => 'Test Doctor']));

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $doctor->id, 'name' => $doctor->name]);
    }
}
