<?php

namespace Tests\Feature\Controllers;

use App\Models\City;
use App\Models\Doctor;
use App\Traits\Tests\ActingJwt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorControllerTest extends TestCase
{
    use ActingJwt;
    use RefreshDatabase;

    public function test_it_creates_a_new_doctor()
    {
        $this->actingJwt();

        $city = City::factory()->create();

        $doctor = Doctor::factory()->make(['city_id' => $city->id]);

        $response = $this->postJson(route('doctors.store'), $doctor->toArray(), [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => $doctor->name]);
    }

    public function test_it_validates_required_fields()
    {
        $this->actingJwt();

        $doctorData = [];

        $response = $this->postJson(route('doctors.store'), $doctorData, [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(500);
        $response->assertJson(['message' => 'O campo nome é obrigatório. (and 2 more errors)']);
    }

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

    public function test_by_city_method_returns_doctors_from_given_city()
    {
        $city = City::factory()->create(['name' => 'São Paulo']);

        $doctor1 = Doctor::factory()->create(['city_id' => $city->id]);
        $doctor2 = Doctor::factory()->create();
        $doctor3 = Doctor::factory()->create(['city_id' => $city->id]);

        $response = $this->getJson(route('doctors.city', $city->id));

        $response->assertSuccessful();
        $response->assertJsonFragment(['id' => $doctor1->id]);
        $response->assertJsonFragment(['id' => $doctor3->id]);
        $response->assertJsonMissing(['id' => $doctor2->id]);
    }
}
