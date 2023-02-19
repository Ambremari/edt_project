<?php

namespace Tests\Unit;

use PDO;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Repositories\Data;
use App\Repositories\Repository;

class RepositoryTest extends TestCase{
    public function setUp(): void{
        parent::setUp();
        $this->data = new Data();
        $this->repository = new Repository();
        $this->repository->createDatabase();
    }

    function testTeachersAndInsertTeacher(): void{
        $teachers = $this->data->teachers();
        $this->repository->insertTeacher($teachers[1]);
        $this->assertEquals($this->repository->teachers(), [$teachers[1]]);
    }

    function testGetTeacher(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[1];
        $this->repository->insertTeacher($teacher);
        $this->assertEquals($this->repository->getTeacher($teacher['IdProf']), $teacher);
    }

    function testGetUserTeacher(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[0];
        $this->repository->insertTeacher($teacher);
        $this->assertEquals($this->repository->getUserTeacher($teacher['IdProf'], $teacher['MdpProf']), [
                                                            'id' => $teacher['IdProf'], 
                                                            'name'=> $teacher['NomProf'], 
                                                            'firstname'=> $teacher['PrenomProf'],
                                                            'role' => 'prof']);
    }

    function testCreatePasswordTeacher(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[1];
        $this->repository->insertTeacher($teacher);
        $this->repository->createPasswordTeacher($teacher['IdProf'], $teacher['MailProf'], 'mdptest001');
        $this->assertEquals($this->repository->getUserTeacher($teacher['IdProf'], 'mdptest001'), [
                                                            'id' => $teacher['IdProf'], 
                                                            'name'=> $teacher['NomProf'], 
                                                            'firstname'=> $teacher['PrenomProf'],
                                                            'role' => 'prof']);
    }

    function testDirectorsAndInsertDirector(): void{
        $directors = $this->data->directors();
        $director = $directors[0];
        $this->repository->insertDirector($director);
        $this->assertEquals($this->repository->directors(), [['IdDir' => $director['IdDir']]]);
    }

    function testGetUserDirector(): void{
        $directors = $this->data->directors();
        $director = $directors[0];
        $this->repository->insertDirector($director);
        $this->assertEquals($this->repository->getUserDirector($director['IdDir'], $director['MdpDir']), [
                                                            'id' => $director['IdDir'], 
                                                            'name'=> $director['NomDir'], 
                                                            'firstname'=> $director['PrenomDir'],
                                                            'role' => 'dir']);
    }

    function testUpdateTeacher(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[1];
        $this->repository->insertTeacher($teacher);
        $teacher['VolHProf'] = 15;
        $this->repository->updateTeacher($teacher);
        $this->assertEquals($this->repository->getTeacher($teacher['NomProf'], $teacher['PrenomProf']), [$teacher]);
    }
}