<?php

namespace App\Domain\Disease\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DiseaseTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    /**
     * Tests creating and retrieving of new diseases.
     *
     * @test
     * @return void
     */
    public function createAndRetrieveNewDiseaseTest()
    {
        $createDiseaseResponse = $this->post('/api/disease');

        $createDiseaseResponse->assertStatus(201)->assertJsonStructure([
            'disease_id',
            'name',
            'rna',
            'difficulty',
            'solved',
            'has_vaccine'
        ]);

        $getDiseaseResponse = $this->get('/api/disease');

        $getDiseaseResponse->assertStatus(200)->assertJsonStructure([
            '*' => [
                'disease_id',
                'name',
                'rna',
                'difficulty',
                'solved',
                'has_vaccine'
            ]
        ]);

    }

    /**
     * Tests if disease can be cured.
     *
     * @test
     * @return void
     */
    public function cureDiseaseTest()
    {
        $diseaseResponse = $this->post('/api/disease');
        $disease = json_decode($diseaseResponse->content(), true);
        $cureDiseaseResponse = $this->put('/api/disease/' . $disease['disease_id'], $disease);

        $cureDiseaseResponse->assertStatus(200)->assertJson([
            'disease_id'    =>      (int)$disease['disease_id'],
            'name'          =>      (string)$disease['name'],
            'rna'           =>      (string)$disease['rna'],
            'difficulty'    =>      (int)$disease['difficulty'],
            'solved'        =>      false,
            'has_vaccine'   =>      false
        ]);
    }
}
