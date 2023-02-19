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
        $this->repository->insertTeacher($teachers[0]);
        $this->assertEquals($this->repository->teachers(), [$teachers[0]]);
    }

    function testGetTeacher(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[0];
        $this->repository->insertTeacher($teacher);
        $this->assertEquals($this->repository->getTeacher($teacher['NomProf'], $teacher['PrenomProf']), [$teacher]);
    }

    function testDirectorsAndInsertDirector(): void{
        $director = [
            'IdDir' => 'DIRtest', 
            'NomDir' => 'Test', 
            'PrenomDir' => 'test', 
            'MailDir' => 'test@college-vh.com',
            'MdpDir' => 'mdptest001'];
        $this->repository->insertDirector($director);
        $this->assertEquals($this->repository->directors(), [['IdDir' => $director['IdDir']]]);
    }

    function testGetUserDirector(): void{
        $director = [
            'IdDir' => 'DIRtest', 
            'NomDir' => 'Test', 
            'PrenomDir' => 'test', 
            'MailDir' => 'test@college-vh.com',
            'MdpDir' => 'mdptest001'];
        $this->repository->insertDirector($director);
        $this->assertEquals($this->repository->getUserDirector($director['IdDir'], $director['MdpDir']), [
                                                            'id' => $director['IdDir'], 
                                                            'name'=> $director['NomDir'], 
                                                            'firstname'=> $director['PrenomDir'],
                                                            'role' => 'dir']);
    }
}