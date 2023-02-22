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
        $this->assertEquals($this->repository->getTeacher($teacher['IdProf']), $teacher);
    }

    function testSubjectsAndInsertSubject(): void{
        $subjects = $this->data->subjects();
        $this->repository->insertSubject($subjects[1]);
        $this->assertEquals($this->repository->subjects(), [$subjects[1]]);
    }

    function testGetSubject(): void{
        $subjects = $this->data->subjects();
        $subject = $subjects[1];
        $this->repository->insertSubject($subject);
        $this->assertEquals($this->repository->getSubject($subject['IdEns']), $subject);
    }

    function testUpdateSubject(): void{
        $subjects = $this->data->subjects();
        $subject = $subjects[0];
        $this->repository->insertSubject($subject);
        $subject['VolHEns'] = 3;
        $this->repository->updateSubject($subject);
        $this->assertEquals($this->repository->getsubject($subject['IdEns']), $subject);
    }

    function testDivisionsAndInsertDivision(): void{
        $divisions = $this->data->divisions();
        $this->repository->insertDivision($divisions[0]);
        $divisions[0]['EffectifReelDiv'] = 0;
        $this->assertEquals($this->repository->divisions(), [$divisions[0]]);
    }

    function testGetDivision(): void{
        $divisions = $this->data->divisions();
        $division = $divisions[0];
        $this->repository->insertDivision($division);
        $this->assertEquals($this->repository->getDivision($division['IdDiv']), $division);
    }

    function testUpdateDivision(): void{
        $divisions = $this->data->divisions();
        $division = $divisions[0];
        $this->repository->insertdivision($division);
        $division['EffectifPrevDiv'] = 25;
        $this->repository->updateDivision($division);
        $this->assertEquals($this->repository->getDivision($division['IdDiv']), $division);
    }

    function testSubjectLinksAndLinkTeacherSubject(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[0];
        $subjects = $this->data->subjects();
        $subject = $subjects[0];
        $this->repository->insertTeacher($teacher);
        $this->repository->insertSubject($subject);
        $this->repository->linkTeacherSubject($teacher['IdProf'], $subject['IdEns']);
        $link = ['IdProf' => $teacher['IdProf'], 'IdEns' =>$subject['IdEns']];
        $this->assertEquals($this->repository->subjectlinks(), [$link]);
    }

    function testTeacherSubjects(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[0];
        $subjects = $this->data->subjects();
        $subject = $subjects[0];
        $this->repository->insertTeacher($teacher);
        $this->repository->insertSubject($subject);
        $this->repository->linkTeacherSubject($teacher['IdProf'], $subject['IdEns']);
        $this->assertEquals($this->repository->getTeacherSubjects($teacher['IdProf']), [$subject]);
    }

    function testLessonsAndLinkTeacherDivision(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[0];
        $subjects = $this->data->subjects();
        $subject = $subjects[0];
        $divisions = $this->data->divisions();
        $division = $divisions[0];
        $this->repository->insertTeacher($teacher);
        $this->repository->insertSubject($subject);
        $this->repository->insertDivision($division);
        $this->repository->linkTeacherSubject($teacher['IdProf'], $subject['IdEns']);
        $this->repository->linkTeacherDivision($teacher['IdProf'], $subject['IdEns'], [$division['IdDiv']]);
        $link = ['IdProf' => $teacher['IdProf'], 'IdEns' =>$subject['IdEns'], 'IdDiv' =>$division['IdDiv']];
        $this->assertEquals($this->repository->lessons(), [$link]);
    }
}