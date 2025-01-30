<?php

namespace Tests\Feature\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
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

    public function test_it_list_patients_from_given_doctor()
    {
        $doctor = Doctor::factory()->create();
        $patients = Patient::factory()
            ->has(Appointment::factory()->state(['doctor_id' => $doctor->id]))
            ->count(2)
            ->create();

        $patientAnotherDoctor = Patient::factory()
            ->has(Appointment::factory())
            ->create();

        $this->assertDatabaseCount('patients', 3);

        $response = $this->getJson(route('patients.doctor', $doctor->id), [
            'Authorization' => "Bearer {$this->token}",
        ]);

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
    }

    public function test_it_list_patients_from_given_doctor_with_search()
    {
        $nameToFind = 'Patient test';

        $doctor = Doctor::factory()->create();
        $patients = Patient::factory()
            ->has(Appointment::factory()->state(['doctor_id' => $doctor->id]))
            ->count(5)
            ->create();

        $patientToFind = Patient::factory()
            ->has(Appointment::factory()->state(['doctor_id' => $doctor->id]))
            ->create(['name' => $nameToFind]);

        $response = $this->getJson(
            route('patients.doctor', ['doctorId' => $doctor->id, 'nome' => $nameToFind]),
            ['Authorization' => "Bearer {$this->token}"]
        );

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
    }

    public function test_it_list_patients_from_given_doctor_with_pending_appointments()
    {
        $nameToFind = 'Patient test';

        $doctor = Doctor::factory()->create();
        $patientsWithEndedAppointments = Patient::factory()
            ->has(Appointment::factory()->state(['doctor_id' => $doctor->id, 'date' => now()->subWeeks(2)]))
            ->count(4)
            ->create();

        $patientsWithPenddingAppointments = Patient::factory()
            ->has(Appointment::factory()->state(['doctor_id' => $doctor->id, 'date' => now()->addWeeks(2)]))
            ->count(3)
            ->create();

        $this->assertDatabaseCount('patients', 7);

        $response = $this->getJson(
            route('patients.doctor', ['doctorId' => $doctor->id, 'apenas-agendadas' => true]),
            ['Authorization' => "Bearer {$this->token}"]
        );

        $response->assertSuccessful();
        $response->assertJsonCount(3, 'data');
    }
}
