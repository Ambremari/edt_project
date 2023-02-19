<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Repositories\Repository;
use App\Repositories\Data;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FormTest extends TestCase{

    public function setUp(): void{
        parent::setUp();
        $this->repository = new Repository();
        $this->repository->createDatabase();
    }

    public function testAddTeacherRedirectsIfUserIsNotAuthenticated(){
        $response = $this->get('/bee/saisie/enseignant');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testAddTeacher(){
        $this->withoutMiddleware();
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('insertTeacher')->with(['NomProf' => 'Doe',
                                                    'PrenomProf' => 'Jane',
                                                    'MailProf' => 'jane.doe@college-vh.com',
                                                    'VolHProf' => 15.0
                                                    ])
                                                ->once();
        });
        $response = $this->post('/bee/saisie/enseignant', ['name' => 'Doe',
                                                        'firstname' => 'Jane',
                                                        'email' => 'jane.doe@college-vh.com',
                                                        'timeamount' => 15.0]);
        $response->assertStatus(302);
        $response->assertRedirect('/bee/saisie/enseignant');
    }
}