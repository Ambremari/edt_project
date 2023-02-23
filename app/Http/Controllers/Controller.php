<?php

namespace App\Http\Controllers;

use Exception;
use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $repository){
        $this->repository = $repository;
    }

    public function welcomePage(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey)
            return redirect()->route('login');
        return view('base');
    }

    public function addTeacherForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        return view('teacher_add');
    }

    public function addTeacher(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'name' => ['required', 'min:2', 'max:15'],
            'firstname' => ['required', 'min:2', 'max:15'],
            'email' => ['required', 'unique:Enseignants,MailProf'],
            'timeamount' => ['required', 'between:1.0,50.0']
        ];
        $messages = [
            'name.required' => 'Vous devez saisir un nom.',
            'firstname.required' => 'Vous devez saisir un prénom.',
            'name.min' => "Le nom doit contenir au moins :min caractères.",
            'name.max' => "Le nom doit contenir au plus :max caractères.",
            'firstname.min' => "Le prénom doit contenir au moins :min caractères.",
            'firstname.max' => "Le prénom doit contenir au plus :max caractères.",
            'email.required' => 'Vous devez saisir une adresse mail.',
            'timeamount.required' => 'Vous devez saisir le volume horaire.',
            'timeamount.between' => 'Vous devez saisir un volume horarire  entre 1 et 50.',
            'email.unique' => 'Cette adresse mail est déjà utilisée.',
        ];
        $validatedData = $request->validate($rules, $messages);
        $teacher = [
                'NomProf' => $validatedData['name'], 
                'PrenomProf' => $validatedData['firstname'], 
                'MailProf' => $validatedData['email'],
                'VolHProf' => $validatedData['timeamount']];
        try{
            $this->repository->insertTeacher($teacher);
        } catch (Exception $exception) {
            return redirect()->route('teacher.form')->withInput()->withErrors("Impossible d'ajouter l'enseignant.");
        }
        return redirect()->route('teacher.form')->with('status', 'Enseignant ajouté avec succès !');
    }

    public function updateTeacherList(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $teachers = $this->repository->teachers();
        return view('teacher_update', ['teachers' => $teachers]);
    }

    public function updateTeacherForm(Request $request, string $idProf){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $teachers = $this->repository->teachers();
        $teacher = $this->repository->getTeacher($idProf);
        return view('teacher_update_form', ['teacher'=> $teacher, 'teachers' => $teachers]);
    }

    public function updateTeacher(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required'],
            'name' => ['required', 'min:2', 'max:15'],
            'firstname' => ['required', 'min:2', 'max:15'],
            'email' => ['required', 'email'],
            'timeamount' => ['required', 'between:1.0,50.0']
        ];
        $messages = [
            'name.required' => 'Vous devez saisir un nom.',
            'firstname.required' => 'Vous devez saisir un prénom.',
            'name.min' => "Le nom doit contenir au moins :min caractères.",
            'name.max' => "Le nom doit contenir au plus :max caractères.",
            'firstname.min' => "Le prénom doit contenir au moins :min caractères.",
            'firstname.max' => "Le prénom doit contenir au plus :max caractères.",
            'email.required' => 'Vous devez saisir une adresse mail.',
            'email.email' => 'Vous devez saisir une adresse mail valide.',
            'timeamount.required' => 'Vous devez saisir le volume horaire.',
            'timeamount.between' => 'Vous devez saisir un volume horarire  entre 1 et 50.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $teacher = [
                'IdProf' => $validatedData['id'],
                'NomProf' => $validatedData['name'], 
                'PrenomProf' => $validatedData['firstname'], 
                'MailProf' => $validatedData['email'],
                'VolHProf' => $validatedData['timeamount']];
        try{
            $this->repository->updateTeacher($teacher);
        } catch (Exception $exception) {
            return redirect()->route('teacher.update.form', ['idProf' => $teacher['IdProf']])->withInput()->withErrors("Impossible de modifier l'enseignant.");
        }
        return redirect()->route('teacher.update.form', ['idProf' => $teacher['IdProf']])->with('status', 'Enseignant modifié avec succès !');
    }

    public function showSubjects(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subjects = $this->repository->subjects();
        return view('subjects', ['subjects' => $subjects]);
    }

    public function addSubjectForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subjects = $this->repository->subjects();
        return view('subject_add', ['subjects' => $subjects]);
    }

    public function addSubject(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'timeamount' => ['required', 'between:1.0,10.0'],
            'mintime' => ['required', 'between:1, 4']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'timeamount.required' => 'Vous devez saisir le volume horaire.',
            'timeamount.between' => 'Vous devez saisir un volume horarire  entre 1 et 10.',
            'mintime.required' => 'Vous devez saisir la durée minimale.',
            'mintime.between' => 'Vous devez saisir une durée minimale entre 1 et 4.',
        ];
        $validatedData = $request->validate($rules, $messages);
        if($request->has('option'))
            $option = true;
        else
            $option = false;
        $subject = [
                'LibelleEns' => $validatedData['lib'], 
                'NiveauEns' => $validatedData['grade'], 
                'VolHEns' => $validatedData['timeamount'],
                'DureeMinEns' => $validatedData['mintime'],
                'OptionEns' => $option];
        try{
            $this->repository->insertSubject($subject);
        } catch (Exception $exception) {
            return redirect()->route('subject.add')->withInput()->withErrors("Impossible d'ajouter l'enseignement.");
        }
        return redirect()->route('subject.add')->with('status', 'Enseignement ajouté avec succès !');
    }

    public function updateSubjectForm(Request $request, string $idEns){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subjects = $this->repository->subjects();
        $subject = $this->repository->getSubject($idEns);
        return view('subject_update', ['subject'=> $subject, 'subjects' => $subjects]);
    }

    public function updateSubject(Request $request){
        $rules = [
            'id' => ['required'],
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'timeamount' => ['required', 'between:1.0,10.0'],
            'mintime' => ['required', 'between:1, 4']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'timeamount.required' => 'Vous devez saisir le volume horaire.',
            'timeamount.between' => 'Vous devez saisir un volume horarire  entre 1 et 10.',
            'mintime.required' => 'Vous devez saisir la durée minimale.',
            'mintime.between' => 'Vous devez saisir une durée minimale entre 1 et 4.',
        ];
        $validatedData = $request->validate($rules, $messages);
        if($request->has('option'))
            $option = true;
        else
            $option = false;
        $subject = [
                'IdEns' => $validatedData['id'],
                'LibelleEns' => $validatedData['lib'], 
                'NiveauEns' => $validatedData['grade'], 
                'VolHEns' => $validatedData['timeamount'],
                'DureeMinEns' => $validatedData['mintime'],
                'OptionEns' => $option];
        try{
            $this->repository->updateSubject($subject);
        } catch (Exception $exception) {
            return redirect()->route('subject.update.form', ['idEns' => $subject['IdEns']])->withInput()->withErrors("Impossible de modifier l'enseignement.");
        }
        return redirect()->route('subject.update.form', ['idEns' => $subject['IdEns']])->with('status', 'Enseignement modifié avec succès !');
    }

    public function addDivisionForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $divisions = $this->repository->divisions();
        return view('division_add', ['divisions' => $divisions]);
    }

    public function addDivision(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'headcount' => ['required', 'between:1.0,35.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'headcount.required' => 'Vous devez saisir l\'effectif prévu.',
            'headcount.between' => 'Vous devez saisir un effectif  entre 1 et 35.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $division = [
                'LibelleDiv' => $validatedData['lib'], 
                'NiveauDiv' => $validatedData['grade'], 
                'EffectifPrevDiv' => $validatedData['headcount']];
        try{
            $this->repository->insertDivision($division);
        } catch (Exception $exception) {
            return redirect()->route('division.form')->withInput()->withErrors("Impossible d'ajouter la division.");
        }
        return redirect()->route('division.form')->with('status', 'Division ajoutée avec succès !');
    }

    public function updateDivisionForm(Request $request, string $idDiv){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $divisions = $this->repository->divisions();
        $division = $this->repository->getDivision($idDiv);
        return view('division_update', ['division'=> $division, 'divisions' => $divisions]);
    }

    public function updateDivision(Request $request){
        $rules = [
            'id' => ['required'],
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'headcount' => ['required', 'between:1.0,35.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'headcount.required' => 'Vous devez saisir l\'effectif prévu.',
            'headcount.between' => 'Vous devez saisir un effectif  entre 1 et 35.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $division = [
                'IdDiv' => $validatedData['id'],
                'LibelleDiv' => $validatedData['lib'], 
                'NiveauDiv' => $validatedData['grade'], 
                'EffectifPrevDiv' => $validatedData['headcount']];
        try{
            $this->repository->updateDivision($division);
        } catch (Exception $exception) {
            return redirect()->route('division.update.form', ['idDiv' => $division['IdDiv']])->withInput()->withErrors("Impossible de modifier la division.");
        }
        return redirect()->route('division.update.form', ['idDiv' => $division['IdDiv']])->with('status', 'Division modifiée avec succès !');
    }

    public function showLinkSubject(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $teachers = $this->repository->teachers();
        return view('subject_link', ['teachers' => $teachers]);
    }

    public function linkTeacherSubjectForm(Request $request, string $idProf){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $teachers = $this->repository->teachers();
        $subjects = $this->repository->subjects();
        $divisions = $this->repository->divisions();
        $teacher = $this->repository->getTeacher($idProf);
        $teacherSubjects = $this->repository->getTeacherSubjects($idProf);
        $teacherLessons = $this->repository->getTeacherLessons($idProf);
        return view('subject_teacher_link', ['teacher'=> $teacher, 
                                             'teachers' => $teachers, 
                                             'subjects' => $subjects,
                                             'divisions' => $divisions,
                                             'teacher_subjects' => $teacherSubjects,
                                             'teacher_lessons' => $teacherLessons]);
    }

    public function linkTeacherSubject(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
            $rules = [
                'id' => ['required', 'exists:Enseignants,IdProf'],
                'subject' => ['required', 'exists:Enseignements,IdEns']
            ];
            $messages = [
                'id.required' => 'Vous devez choisir un enseignant.',
                'subject.required' => 'Vous devez choisir un enseignement.',
            ];
            $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->linkTeacherSubject($validatedData['id'], $validatedData['subject']);
        } catch (Exception $exception) {
            return redirect()->route('link.subject.form', ['idProf' => $validatedData['id']])->withInput()->withErrors("Impossible de réaliser l'affectation.");
        }
        return redirect()->route('link.subject.form', ['idProf' => $validatedData['id']])->with('status', 'Affectation réalisée avec succès !');
    }

    public function linkTeacherDivision(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required', 'exists:Enseignants,IdProf'],
            'subject' => ['required', 'exists:Enseignements,IdEns'],
            'divisions' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez choisir un enseignant.',
            'subject.required' => 'Vous devez choisir un enseignement.',
            'divisions.required' => 'Vous devez choisir au moins une division.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->linkTeacherDivision($validatedData['id'], $validatedData['subject'], $validatedData['divisions']);
        } catch (Exception $exception) {
            return redirect()->route('link.subject.form', ['idProf' => $validatedData['id']])->withInput()->withErrors("Impossible de réaliser l'affectation.");
        }
        return redirect()->route('link.subject.form', ['idProf' => $validatedData['id']])->with('status', 'Affectation réalisée avec succès !');
    }

    public function removeTeacherSubject(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
            $rules = [
                'id' => ['required', 'exists:Enseignants,IdProf'],
                'subject' => ['required', 'exists:Enseignements,IdEns']
            ];
            $messages = [
                'id.required' => 'Vous devez choisir un enseignant.',
                'subject.required' => 'Vous devez choisir un enseignement.',
            ];
            $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->removeTeacherSubject($validatedData['id'], $validatedData['subject']);
        } catch (Exception $exception) {
            return redirect()->route('link.subject.form', ['idProf' => $validatedData['id']])->withInput()->withErrors("Impossible de supprimer l'affectation.");
        }
        return redirect()->route('link.subject.form', ['idProf' => $validatedData['id']])->with('status', 'Affectation annulée avec succès !');
    }

    public function addClassroomForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $types = $this->repository->types();
        $classrooms = $this->repository->classrooms();
        return view('classroom_add', ['types' => $types,'classrooms' => $classrooms]);
    }

    public function addClassroom(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'lib' => ['required', 'min:2', 'max:40'],
            'type' => ['required'],
            'capacity' => ['required', 'between:1.0,100.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'type.required' => 'Vous devez sélectionner un type de salle.',
            'capacity.required' => 'Vous devez saisir la capacité.',
            'capacity.between' => 'Vous devez saisir une capacité  entre 1 et 100.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $classroom = [
                'LibelleSalle' => $validatedData['lib'], 
                'TypeSalle' => $validatedData['type'], 
                'CapSalle' => $validatedData['capacity']];
        try{
            $this->repository->insertClassroom($classroom);
        } catch (Exception $exception) {
            return redirect()->route('classroom.form')->withInput()->withErrors("Impossible d'ajouter la salle.");
        }
        return redirect()->route('classroom.form')->with('status', 'Salle ajoutée avec succès !');
    }

    public function updateClassroomForm(Request $request, string $idSalle){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $types = $this->repository->types();
        $classrooms = $this->repository->classrooms();
        $classroom = $this->repository->getClassroom($idSalle);
        return view('classroom_update', ['classroom'=> $classroom, 'types' => $types, 'classrooms' => $classrooms]);
    }

    public function updateClassroom(Request $request){
        $rules = [
            'id' => ['required'],
            'lib' => ['required', 'min:2', 'max:40'],
            'type' => ['required'],
            'capacity' => ['required', 'between:1.0,100.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'type.required' => 'Vous devez sélectionner un type de salle.',
            'capacity.required' => 'Vous devez saisir la capacité.',
            'capacity.between' => 'Vous devez saisir une capacité  entre 1 et 100.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $classroom = [
                'IdSalle' => $validatedData['id'],
                'LibelleSalle' => $validatedData['lib'], 
                'TypeSalle' => $validatedData['type'], 
                'CapSalle' => $validatedData['capacity']];
        try{
            $this->repository->updateClassroom($classroom);
        } catch (Exception $exception) {
            return redirect()->route('classroom.update.form', ['idSalle' => $classroom['IdSalle']])->withInput()->withErrors("Impossible de modifier la salle.");
        }
        return redirect()->route('classroom.update.form', ['idSalle' => $classroom['IdSalle']])->with('status', 'Salle modifiée avec succès !');
    }

    public function loginChoice(){
        return view('login');
    }

    public function loginDir(Request $request, Repository $repository){
        $rules = [
            'id' => ['required', 'exists:Directeurs,IdDir'],
            'password' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez saisir un identifiant.',
            'id.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            $user = $this->repository->getUserDirector($validatedData['id'], $validatedData['password']);
            $request->session()->put('user', $user);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.");
        }
        return redirect()->route('welcome.page');
    }

    public function createPasswordForm(){
        return view('first_login');
    }

    public function createPasswordTeacher(Request $request, Repository $repository){
        $rules = [
            'id' => ['required', 'exists:Enseignants,IdProf'],
            'email' => ['required', 'email', 'exists:Enseignants,MailProf'],
            'password' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez saisir un identifiant.',
            'id.exists' => "Cet utilisateur n'existe pas.",
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            $this->repository->createPasswordTeacher($validatedData['id'], $validatedData['email'], $validatedData['password']);
            $user = $this->repository->getUserTeacher($validatedData['id'], $validatedData['password']);
            $request->session()->put('user', $user);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.");
        }
        return redirect()->route('welcome.page');
    }

    public function loginTeacher(Request $request, Repository $repository){
        $rules = [
            'id' => ['required', 'exists:Enseignants,IdProf'],
            'password' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez saisir un identifiant.',
            'id.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            $user = $this->repository->getUserTeacher($validatedData['id'], $validatedData['password']);
            $request->session()->put('user', $user);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.");
        }
        return redirect()->route('welcome.page');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->route('login');
    }

    public function showDivision(Request $request, string $idDiv){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $division = $this->repository->getDivision($idDiv);
        $lessons = $this->repository->getDivisionLessons($idDiv);
        $students = $this->repository->getDivisionStudents($idDiv);
        return view('division_show', ['division'=> $division, 
                                    'students' => $students,
                                    'lessons' => $lessons]);
    }

    public function addGroupForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $groups = $this->repository->groups();
        return view('group_add', ['groups' => $groups]);
    }

    public function addGroup(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'headcount' => ['required', 'between:1.0,35.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'headcount.required' => 'Vous devez saisir l\'effectif prévu.',
            'headcount.between' => 'Vous devez saisir un effectif  entre 1 et 35.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $group = [
                'LibelleGrp' => $validatedData['lib'], 
                'NiveauGrp' => $validatedData['grade'], 
                'EffectifPrevGrp' => $validatedData['headcount']];
        try{
            $this->repository->insertGroup($group);
        } catch (Exception $exception) {
            return redirect()->route('group.form')->withInput()->withErrors("Impossible d'ajouter le groupe.");
        }
        return redirect()->route('group.form')->with('status', 'Groupe ajouté avec succès !');
    }

    public function updateGroupForm(Request $request, string $idGrp){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $groups = $this->repository->groups();
        $group = $this->repository->getGroup($idGrp);
        return view('group_update', ['group'=> $group, 'groups' => $groups]);
    }

    public function updateGroup(Request $request){
        $rules = [
            'id' => ['required'],
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'headcount' => ['required', 'between:1.0,35.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'headcount.required' => 'Vous devez saisir l\'effectif prévu.',
            'headcount.between' => 'Vous devez saisir un effectif  entre 1 et 35.'
        ];
        $validatedData = $request->validate($rules, $messages);
        $group = [
                'IdGrp' => $validatedData['id'],
                'LibelleGrp' => $validatedData['lib'], 
                'NiveauGrp' => $validatedData['grade'], 
                'EffectifPrevGrp' => $validatedData['headcount']];
        try{
            $this->repository->updateGroup($group);
        } catch (Exception $exception) {
            return redirect()->route('group.update.form', ['idGrp' => $group['IdGrp']])->withInput()->withErrors("Impossible de modifier le groupe.");
        }
        return redirect()->route('group.update.form', ['idGrp' => $group['IdGrp']])->with('status', 'Groupe modifié avec succès !');
    }

    public function showGroup(Request $request, string $idGrp){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $group = $this->repository->getGroup($idGrp);
        $lessons = $this->repository->getGroupLessons($idGrp);
        $students = $this->repository->getGroupStudents($idGrp);
        return view('group_show', ['group'=> $group, 
                                    'students' => $students,
                                    'lessons' => $lessons]);
    }
}
