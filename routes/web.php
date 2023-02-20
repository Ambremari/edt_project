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