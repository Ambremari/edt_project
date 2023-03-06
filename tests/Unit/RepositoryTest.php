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

    function testStudentsAndInsertStudents(): void{
        $students = $this->data->students();
        $this->repository->insertStudent($students[0]);
        $this->assertEquals($this->repository->students()[0]['IdEleve'], $students[0]['IdEleve']);
    }

    function testGetStudents(): void{
        $students = $this->data->students();
        $student = $students[0];
        $this->repository->insertStudent($student);
        $this->assertEquals($this->repository->getStudent($student['IdEleve'])['NomEleve'], $student['NomEleve']);
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
        $this->assertEquals($this->repository->insertDivision($divisions[0]), $divisions[0]['IdDiv']);
        $divisions[0]['EffectifReelDiv'] = 0;
        $this->assertEquals($this->repository->divisions(), [$divisions[0]]);
    }

    function testGetDivision(): void{
        $divisions = $this->data->divisions();
        $division = $divisions[0];
        $this->repository->insertDivision($division);
        $division['EffectifReelDiv'] = 0;
        $this->assertEquals($this->repository->getDivision($division['IdDiv']), $division);
    }

    function testUpdateDivision(): void{
        $divisions = $this->data->divisions();
        $division = $divisions[0];
        $this->repository->insertdivision($division);
        $division['EffectifPrevDiv'] = 25;
        $this->repository->updateDivision($division);
        $division['EffectifReelDiv'] = 0;
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

    function testLessonsAndLinkTeacherClass(): void{
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
        $this->repository->linkTeacherClass($teacher['IdProf'], $subject['IdEns'], [$division['IdDiv']], []);
        $link = ['IdProf' => $teacher['IdProf'], 'IdEns' =>$subject['IdEns'], 'IdDiv' =>$division['IdDiv'], 'IdGrp' => null];
        $this->assertEquals($this->repository->lessons(), [$link]);
    }

    function testGetTeacherLessonsLib(): void{
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
        $this->repository->linkTeacherClass($teacher['IdProf'], $subject['IdEns'], [$division['IdDiv']], []);
        $link = ['IdProf' => $teacher['IdProf'], 
                 'IdEns' =>$subject['IdEns'], 
                 'IdDiv' =>$division['IdDiv'], 
                 'IdGrp' => null, 
                 'LibelleEns' => $subject['LibelleEns'],
                 'NomProf' => $teacher['NomProf'],
                 'PrenomProf' => $teacher['PrenomProf'],
                 'LibelleDiv' => $division['LibelleDiv'],
                 'LibelleGrp' => null];
        $this->assertEquals($this->repository->getTeacherLessonsLib($teacher['IdProf']), [$link]);
    }

    function testRemoveTeacherSubject(): void{
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
        $this->repository->linkTeacherClass($teacher['IdProf'], $subject['IdEns'], [$division['IdDiv']], []);
        $this->repository->removeTeacherSubject($teacher['IdProf'], $subject['IdEns']);
        $this->assertEquals($this->repository->getTeacherSubjects($teacher['IdProf']), []);
        $this->assertEquals($this->repository->getTeacherLessons($teacher['IdProf']), []);
    }

    function testTypesAndInsertType(): void{
        $types = $this->data->types();
        $this->repository->insertType($types[0]);
        $this->assertEquals($this->repository->types(), [$types[0]]);
    }

    function testClassroomsAndInsertClassroom(): void{
        $types = $this->data->types();
        $this->repository->insertType($types[0]);
        $classrooms = $this->data->classrooms();
        $this->repository->insertClassroom($classrooms[0]);
        $this->assertEquals($this->repository->classrooms(), [$classrooms[0]]);
    }

    function testGetClassroom(): void{
        $types = $this->data->types();
        $this->repository->insertType($types[0]);
        $classrooms = $this->data->classrooms();
        $classroom = $classrooms[0];
        $this->repository->insertClassroom($classroom);
        $this->assertEquals($this->repository->getClassroom($classroom['IdSalle']), $classroom);
    }

    function testUpdateClassroom(): void{
        $types = $this->data->types();
        $this->repository->insertType($types[0]);
        $classrooms = $this->data->classrooms();
        $classroom = $classrooms[0];
        $this->repository->insertClassroom($classroom);
        $classroom['CapSalle'] = 25;
        $this->repository->updateClassroom($classroom);
        $this->assertEquals($this->repository->getClassroom($classroom['IdSalle']), $classroom);
    }

    function testGetDivisionLessonLib(): void{
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
        $this->repository->linkTeacherClass($teacher['IdProf'], $subject['IdEns'], [$division['IdDiv']], []);
        $link = ['IdProf' => $teacher['IdProf'], 
                 'IdEns' =>$subject['IdEns'], 
                 'IdDiv' =>$division['IdDiv'], 
                 'IdGrp' => null, 
                 'LibelleEns' => $subject['LibelleEns'],
                 'NomProf' => $teacher['NomProf'],
                 'PrenomProf' => $teacher['PrenomProf'],
                 'LibelleDiv' => $division['LibelleDiv'],
                 'LibelleGrp' => null];
        $this->assertEquals($this->repository->getDivisionLessonsLib($division['IdDiv']), [$link]);
    }

    function testGetDivisionStudent(): void{
        
    }

    function testGroupsAndInsertGroup(): void{
        $groups = $this->data->groups();
        $this->assertEquals($this->repository->insertGroup($groups[0]), $groups[0]['IdGrp']);
        $groups[0]['EffectifReelGrp'] = 0;
        $groups[0]['NbDivAssociees'] = 0;
        $this->assertEquals($this->repository->groups(), [$groups[0]]);
    }

    function testGetGroup(): void{
        $groups = $this->data->groups();
        $group = $groups[0];
        $this->repository->insertGroup($group);
        $group['EffectifReelGrp'] = 0;
        $this->assertEquals($this->repository->getGroup($group['IdGrp']), $group);
    }

    function testUpdateGroup(): void{
        $groups = $this->data->groups();
        $group = $groups[0];
        $this->repository->insertGroup($group);
        $group['EffectifPrevGrp'] = 25;
        $this->repository->updateGroup($group);
        $group['EffectifReelGrp'] = 0;
        $this->assertEquals($this->repository->getGroup($group['IdGrp']), $group);
    }

    function testGetGroupLesson(): void{
        $teachers = $this->data->teachers();
        $teacher = $teachers[0];
        $subjects = $this->data->subjects();
        $subject = $subjects[0];
        $groups = $this->data->groups();
        $group = $groups[0];
        $this->repository->insertTeacher($teacher);
        $this->repository->insertSubject($subject);
        $this->repository->insertGroup($group);
        $this->repository->linkTeacherSubject($teacher['IdProf'], $subject['IdEns']);
        $this->repository->linkTeacherClass($teacher['IdProf'], $subject['IdEns'], [], [$group['IdGrp']]);
        $link = ['IdProf' => $teacher['IdProf'], 
                 'IdEns' =>$subject['IdEns'], 
                 'IdDiv' => null, 
                 'IdGrp' => $group['IdGrp'], 
                 'LibelleEns' => $subject['LibelleEns'],
                 'NomProf' => $teacher['NomProf'],
                 'PrenomProf' => $teacher['PrenomProf'],
                 'LibelleDiv' => null,
                 'LibelleGrp' => $group['LibelleGrp']];
        $this->assertEquals($this->repository->getGroupLessonsLib($group['IdGrp']), [$link]);
    }

    function testStudentsAndInsertStudent(): void{
        $students = $this->data->students();
        $this->repository->insertStudent($students[0]);
        $student = [ "IdEleve" => "ELV1002",
        "PrenomEleve" => "Lani",
        "NomEleve" => "Kim",
        "MdpEleve" => null,
        "AnneeNaisEleve" => "2009",
        "NiveauEleve" => "4EME",
        "IdDiv" => null];
        $this->assertEquals($this->repository->students(), [$student]);
    }

    function testGetStudent(): void{
        $students = $this->data->students();
        $this->repository->insertStudent($students[0]);
        $student = [ "IdEleve" => "ELV1002",
        "PrenomEleve" => "Lani",
        "NomEleve" => "Kim",
        "MdpEleve" => null,
        "AnneeNaisEleve" => "2009",
        "NiveauEleve" => "4EME",
        "IdDiv" => null,
        "LibelleDiv" => null];
        $this->assertEquals($this->repository->getStudent($student['IdEleve']), $student);
    }

    function testAddGroupStudentsAndGetGroupStudent(): void{
        
    }

    function testOptionsAndAddStudentOption(): void{
        $students = $this->data->students();
        $student = $students[0];
        $this->repository->insertStudent($student);
        $subjects = $this->data->subjects();
        $subject = $subjects[13];
        $this->repository->insertSubject($subject);
        $this->repository->addStudentOption($student['IdEleve'], [$subject['IdEns']]);
        $this->assertEquals($this->repository->options(), [['IdEleve' => $student['IdEleve'], 'IdEns' => $subject['IdEns']]]);
    }

    function testGetStudentOptions(): void{
        $students = $this->data->students();
        $student = $students[0];
        $this->repository->insertStudent($student);
        $subjects = $this->data->subjects();
        $subject = $subjects[13];
        $this->repository->insertSubject($subject);
        $this->repository->addStudentOption($student['IdEleve'], [$subject['IdEns']]);
        $this->assertEquals($this->repository->getStudentOptions($student['IdEleve']), [['IdEleve' => $student['IdEleve'], 'IdEns' => $subject['IdEns']]]);
    }

    function testGetStudentOptionsLib(): void{
        $students = $this->data->students();
        $student = $students[0];
        $this->repository->insertStudent($student);
        $subjects = $this->data->subjects();
        $subject = $subjects[13];
        $this->repository->insertSubject($subject);
        $this->repository->addStudentOption($student['IdEleve'], [$subject['IdEns']]);
        $this->assertEquals($this->repository->getStudentOptionsLib($student['IdEleve']), [['IdEleve' => $student['IdEleve'], 
                                                                                        'IdEns' => $subject['IdEns'],
                                                                                        'LibelleEns' => $subject['LibelleEns']]]);    
    }

    function testCreate2Groups(): void{
        $divisions = $this->data->divisions();
        $division = $divisions[0];
        $idDiv = $this->repository->insertDivision($division);
        $this->repository->create2Groups($idDiv);
        $groups = $this->repository->groups();
        $this->assertEquals(count($groups), 2);
    }

    function testRemoveStudentGroup(): void{
        $groups = $this->data->groups();
        $group = $groups[0];
        $idGrp = $this->repository->insertGroup($group);
        $students = $this->data->students();
        $this->repository->insertStudent($students[0]);
        $this->repository->addGroupStudents($idGrp,[$students[0]['IdEleve']]);
        $this->repository->removeStudentGroup($students[0]['IdEleve'], $idGrp);
        $studList = $this->repository->getGroupStudents($idGrp);
        $this->assertEquals(count($studList), 0);
    }

    



}