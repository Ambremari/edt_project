<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Controller::class, 'welcomePage'])
    ->name('welcome.page');

Route::get('/login', [Controller::class, 'loginChoice'])
    ->name('login');

Route::post('/login/dir', [Controller::class, 'loginDir'])
    ->name('login.dir');

Route::get('/firstlogin', [Controller::class, 'createPasswordForm'])
    ->name('first.login');

Route::post('/firstlogin/teacher', [Controller::class, 'createPasswordTeacher'])
    ->name('first.teacher');

Route::post('/login/teacher', [Controller::class, 'loginTeacher'])
    ->name('login.teacher');

Route::post('/logout', [Controller::class, 'logout'])
    ->name('logout.post');

Route::get('/bee/saisie/enseignant', [Controller::class, 'addTeacherForm'])
    ->name('teacher.form');

Route::post('/bee/saisie/enseignant', [Controller::class, 'addTeacher'])
    ->name('teacher.add');

Route::get('/bee/modif/enseignant', [Controller::class, 'updateTeacherList'])
    ->name('teacher.update.list');

Route::post('/bee/modif/enseignant', [Controller::class, 'updateTeacher'])
    ->name('teacher.update');

Route::get('/bee/modif/enseignant/{idProf}', [Controller::class, 'updateTeacherForm'])
    ->where('idProf', '[PRF].*')
    ->name('teacher.update.form');

Route::get('/bee/info/enseignant', [Controller::class, 'showTeachers'])
    ->name('teachers.show');

Route::get('/bee/info/enseignant/{idProf}', [Controller::class, 'showTeacher'])
    ->where('idProf', '[PRF].*')
    ->name('teacher.show');

Route::get('/bee/info/eleve', [Controller::class, 'showStudents'])
    ->name('students.show');

Route::get('/bee/info/eleve/{idEleve}', [Controller::class, 'showStudent'])
    ->where('idEleve', '[ELV].*')
    ->name('student.show');

Route::get('/bee/scol/eleve', [Controller::class, 'studentOption'])
    ->name('student.option');

Route::get('/bee/scol/eleve/{idEleve}', [Controller::class, 'studentOptionForm'])
    ->where('idEleve', '[ELV].*')
    ->name('student.option.form');

Route::post('/bee/scol/eleve/{idEleve}', [Controller::class, 'addStudentOption'])
    ->where('idEleve', '[ELV].*')
    ->name('student.option.add');

Route::get('/ens/creation', [Controller::class, 'addSubjectForm'])
    ->name('subjects.form');

Route::post('/ens/creation', [Controller::class, 'addSubject'])
    ->name('subject.add');

Route::post('/ens', [Controller::class, 'updateSubject'])
    ->name('subject.update');

Route::get('/ens', [Controller::class, 'showSubjects'])
    ->name('subjects.show');

Route::get('/ens/modif/{idEns}', [Controller::class, 'updateSubjectForm'])
    ->where('idEns', '[ENS].*')
    ->name('subject.update.form');

Route::get('/div', [Controller::class, 'addDivisionForm'])
    ->name('division.form');

Route::post('/div', [Controller::class, 'addDivision'])
    ->name('division.add');

Route::get('/div/info/{idDiv}', [Controller::class, 'showDivision'])
    ->where('idDiv', '[DIV].*')
    ->name('division.show');

Route::get('/div/modif/{idDiv}', [Controller::class, 'updateDivisionForm'])
    ->where('idDiv', '[DIV].*')
    ->name('division.update.form');

Route::post('/div/modif', [Controller::class, 'updateDivision'])
    ->name('division.update');

Route::post('/grp/remove', [Controller::class, 'removeStudentGroup'])
    ->name('remove.student.grp');

Route::get('/div/fill', [Controller::class, 'fillDivisionForm'])
    ->name('division.fill.form');

Route::post('/div/fill', [Controller::class, 'fillDivision'])
    ->name('division.fill');

Route::get('/ens/link', [Controller::class, 'showLinkSubject'])
    ->name('link.subject');

Route::get('/ens/link/{idProf}', [Controller::class, 'linkTeacherSubjectForm'])
    ->where('idProf', '[PRF].*')
    ->name('link.subject.form');

Route::post('/ens/link', [Controller::class, 'linkTeacherSubject'])
    ->name('link.subject');

Route::post('/ens/link/{idProf}', [Controller::class, 'linkTeacherDivision'])
    ->where('idProf', '[PRF].*')
    ->name('link.division');

Route::post('/ens/link/remove', [Controller::class, 'removeTeacherSubject'])
    ->name('link.subject.remove');

Route::get('/college/salle', [Controller::class, 'addClassroomForm'])
    ->name('classroom.form');

Route::post('/college/salles', [Controller::class, 'addClassroom'])
    ->name('classroom.add');

Route::get('/college/salles/{idSalle}', [Controller::class, 'updateClassroomForm'])
    ->where('idSalle', '[SAL].*')
    ->name('classroom.update.form');

Route::post('/college/salles/modif', [Controller::class, 'updateClassroom'])
    ->name('classroom.update');

Route::get('/grp', [Controller::class, 'addGroupForm'])
    ->name('group.form');

Route::post('/grp', [Controller::class, 'addGroup'])
    ->name('group.add');

Route::get('/grp/info/{idGrp}', [Controller::class, 'showGroup'])
    ->where('idGrp', '[GRP].*')
    ->name('group.show');

Route::get('/grp/modif/{idGrp}', [Controller::class, 'updateGroupForm'])
    ->where('idGrp', '[GRP].*')
    ->name('group.update.form');

Route::post('/grp/modif', [Controller::class, 'updateGroup'])
    ->name('group.update');

Route::get('/grp/fill', [Controller::class, 'fillGroupForm'])
    ->name('group.fill.form');

Route::post('/grp/fill', [Controller::class, 'fillGroup'])
    ->name('group.fill');


Route::get('/schedule/add', [Controller::class, 'addScheduleForm'])
    ->name('schedule.form');

Route::post('/schedule/add', [Controller::class, 'addSchedule'])
    ->name('schedule.add');

Route::get('/schedule/update/{horaire}', [Controller::class, 'updateScheduleForm'])
    ->name('schedule.update.form');

Route::post('/schedule/update', [Controller::class, 'updateSchedule'])
    ->name('schedule.update');

Route::get('/prof/constraints', [Controller::class, 'profConstraints'])
    ->name('prof.constraints');

Route::post('/prof/constraints', [Controller::class, 'updateProfConstraints'])
    ->name('update.prof.constraints');

Route::get('/classrooms', [App\Http\Controllers\ConstraintsController::class, 'classroomConstraints'])
    ->name('constraints.classrooms');

Route::post('/constraints/classrooms/add', [ConstraintsController::class, 'addConstraintsClassrooms'])
    ->name('constraints.classrooms.add');

Route::post('/classrooms/update', [App\Http\Controllers\ConstraintsController::class, 'updateConstraintsClassrooms'])
    ->name('constraints.classrooms.update');




