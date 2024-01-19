<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Intern;

class InternTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;



    public function test_intern_insert()
    {
        // preparation
        $intern = [
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'school' => 'Example University',
            'age' => 22,
            'year_level' => '4th Year',
            'gender' => 'Male',
        ];


        // action
        $response = $this->post('/api/register-intern', $intern);

        // assertion
        $response->assertStatus(201);
        $this->assertDatabaseHas('interns', $intern);
    }

    public function test_intern_read()
    {
        // preparation
        $intern = Intern::create([
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'school' => 'Example University',
            'age' => 22,
            'year_level' => '4th Year',
            'gender' => 'Male',
        ]);

        // action
        $response = $this->get('/api/get-intern');

        // assertion

        // $response->assertJsonStructure([
        //     'status',
        //     'data' => [
        //         '*' => [
        //             'id',
        //             'first_name',
        //             'middle_name',
        //             'last_name',
        //             'school',
        //             'age',
        //             'year_level',
        //             'gender',
        //         ],
        //     ],
        // ]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('data'));
    }

    public function test_intern_delete()
    {
        // prepare
        $intern = Intern::create([
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'school' => 'Example University',
            'age' => 22,
            'year_level' => '4th Year',
            'gender' => 'Male',
        ]);

        $id = $intern->id;

        // action
        $response = $this->delete('/api/delete-intern/' . $id);

        // assertion
        $response->assertNoContent();
        $this->assertDatabaseMissing('interns', ['id' => $id]);
    }

    public function test_intern_update()
    {
        // prepare
        $intern = Intern::create([
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'school' => 'Example University',
            'age' => 22,
            'year_level' => '4th Year',
            'gender' => 'Male',
        ]);

        $id = $intern->id;

        $updateData = [
            'school' => 'FEU Institute of Technology',
            'year_level' => '5th Year'
        ];

        // action
        $response = $this->patch('/api/update-intern/' . $id, $updateData);

        // assertion
        $response->assertStatus(200);
        $this->assertDatabaseHas('interns', [
            'id' => $id,
            'school' => 'FEU Institute of Technology',
            'year_level' => '5th Year',
        ]);
    }
}
