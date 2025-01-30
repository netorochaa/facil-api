<?php

namespace Tests\Feature\Repositories;

use App\Models\Patient;
use App\Repositories\Eloquent\PatientRepositoryEloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientRepositoryEloquentTest extends TestCase
{
    use RefreshDatabase;

    private PatientRepositoryEloquent $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new PatientRepositoryEloquent;
    }

    public function test_it_stores_a_new_patient()
    {
        $patientData = Patient::factory()->make();

        $patient = $this->repository->store($patientData->toArray());

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertEquals($patientData['name'], $patient->name);
        $this->assertEquals($patientData['spacialty'], $patient->spacialty);
        $this->assertEquals($patientData['city_id'], $patient->city_id);
    }

    public function test_it_updates_a_patient()
    {
        $patient = Patient::factory()->create();
        $newPatient = Patient::factory()->make();

        $this->repository->update($newPatient->toArray(), $patient->id);

        $patient->refresh();

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertEquals($newPatient['name'], $patient->name);
        $this->assertEquals($newPatient['spacialty'], $patient->spacialty);
        $this->assertEquals($newPatient['city_id'], $patient->city_id);
    }

    public function test_it_find_a_patient()
    {
        $patients = Patient::factory()->count(5)->create();

        $randomPatient = $patients->random();

        $searchedPatient = $this->repository->find($randomPatient->id);

        $this->assertInstanceOf(Patient::class, $searchedPatient);
        $this->assertEquals($randomPatient->id, $searchedPatient->id);
    }

    public function test_it_lists_patients()
    {
        Patient::factory()->count(5)->create();

        $patients = $this->repository->list(null);

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);

        $this->assertCount(5, $patients->items());
    }

    public function test_it_lists_patients_with_search()
    {
        Patient::factory()->count(5)->create();

        $patient = Patient::factory()->create(['name' => 'Test patient']);

        $patients = $this->repository->list('Test patient');

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);

        $this->assertCount(1, $patients->items());
        $this->assertEquals($patient->id, $patients->items()[0]->id);
    }

    public function test_it_should_not_list_with_search_that_does_not_exist()
    {
        Patient::factory()->count(5)->create();

        $patients = $this->repository->list('AAaaaaaaAAAaaaaaaAAAaaaaaAAA');

        $this->assertInstanceOf(LengthAwarePaginator::class, $patients);

        $this->assertCount(0, $patients->items());
    }
}
