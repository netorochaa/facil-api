<?php

namespace Tests\Feature\Controllers;

use App\Models\Patient;
use App\Traits\Tests\ActingJwt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    use ActingJwt;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingJwt();
    }

    public function test_it_creates_a_new_patient()
    {
        $patient = Patient::factory()->make();

        $response = $this->postJson(route('patients.store'), $patient->toArray(), [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['name' => $patient->name]);
    }

    public function test_it_updates_a_new_patient()
    {
        $patient = Patient::factory()->create();
        $newPatient = Patient::factory()->make();

        $response = $this->putJson(
            route('patients.update', $patient->id),
            $newPatient->toArray(),
            ['Authorization' => "Bearer {$this->token}"]
        );

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $newPatient->name]);
    }

    public function test_it_validates_required_fields()
    {
        $patientData = [];

        $response = $this->postJson(route('patients.store'), $patientData, [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertStatus(500);
        $response->assertJson(['message' => 'O campo nome é obrigatório. (and 2 more errors)']);
    }

    public function test_it_returns_a_list_of_patients()
    {
        Patient::factory()->count(5)->create();

        $response = $this->getJson(route('patients.index'), [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertSuccessful();
        $response->assertJsonCount(5, 'data');
    }

    public function test_it_returns_a_list_of_patients_with_search()
    {
        Patient::factory()->count(5)->create();

        $patient = Patient::factory()->create(['name' => 'Test patient']);

        $response = $this->getJson(route('patients.index', ['nome' => 'Test patient']), [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $patient->id, 'name' => $patient->name]);
    }
}
