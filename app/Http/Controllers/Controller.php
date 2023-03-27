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
    protected Repository $repository;
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

    public function showSubject(Request $request, string $idEns){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subject = $this->repository->getSubject($idEns);
        $teachers = $this->repository->getSubjectTeachers($idEns);
        return view('subject_show', ['subject' => $subject, 'teachers' => $teachers]);
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
            'timeamount' => ['required', 'between:1.0,10.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'timeamount.required' => 'Vous devez saisir le volume horaire.',
            'timeamount.between' => 'Vous devez saisir un volume horarire  entre 1 et 10.'
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
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required'],
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'timeamount' => ['required', 'between:1.0,10.0']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'timeamount.required' => 'Vous devez saisir le volume horaire.',
            'timeamount.between' => 'Vous devez saisir un volume horarire  entre 1 et 10.'
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
        if($request->has('group'))
            $group = true;
        else
            $group = false;
        $division = [
                'LibelleDiv' => $validatedData['lib'],
                'NiveauDiv' => $validatedData['grade'],
                'EffectifPrevDiv' => $validatedData['headcount']];
        try{
            $idDiv = $this->repository->insertDivision($division);
        } catch (Exception $exception) {
            return redirect()->route('division.form')->withInput()->withErrors("Impossible d'ajouter la division.");
        }
        if($group){
            try{
                $this->repository->create2Groups($idDiv);
            } catch (Exception $exception) {
                return redirect()->route('division.form')->withInput()->withErrors("Impossible de créer les groupes.");
            }
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
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
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

    public function removeStudentGroup(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'idStud' => ['required'],
            'idGrp' => ['required']
        ];
        $messages = [
            'idStud.required' => 'Aucun étudiant n\'est sélectionné.',
            'idGrp.required' => 'Aucun groupe n\'est sélectionné.'
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->removeStudentGroup($validatedData['idStud'], $validatedData['idGrp']);
        } catch (Exception $exception) {
            return redirect()->route('group.show', ['idGrp' => $validatedData['idGrp']])->withInput()->withErrors("Impossible de modifier le groupe.");
        }
        return redirect()->route('group.show', ['idGrp' => $validatedData['idGrp']])->with('status', 'Groupe modifié avec succès !');
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
        $groups = $this->repository->groups();
        $teacher = $this->repository->getTeacher($idProf);
        $teacherSubjects = $this->repository->getTeacherSubjects($idProf);
        $teacherLessons = $this->repository->getTeacherLessons($idProf);
        $teacherLessonsGrp = $this->repository->getTeacherLessonsGroup($idProf);
        return view('subject_teacher_link', ['teacher'=> $teacher,
                                             'teachers' => $teachers,
                                             'subjects' => $subjects,
                                             'divisions' => $divisions,
                                             'groups' => $groups,
                                             'teacher_subjects' => $teacherSubjects,
                                             'teacher_lessons' => $teacherLessons,
                                             'teacher_lessons_gp' => $teacherLessonsGrp]);
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
            'divisions' => ['required_without:groups'],
            'groups' => ['required_without:divisions']
        ];
        $messages = [
            'id.required' => 'Vous devez choisir un enseignant.',
            'subject.required' => 'Vous devez choisir un enseignement.',
            'divisions.required_without' => 'Vous devez choisir au moins une division ou un groupe.',
            'groups.required_without' => 'Vous devez choisir au moins une division ou un groupe.',
        ];
        $validatedData = $request->validate($rules, $messages);
        if(!$request->has('divisions'))
            $validatedData['divisions'] = [];
        if(!$request->has('groups'))
            $validatedData['groups'] = [];
        try{
            $this->repository->linkTeacherClass($validatedData['id'], $validatedData['subject'], $validatedData['divisions'], $validatedData['groups']);
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

    public function createPasswordStudent(Request $request){
        $rules = [
            'id' => ['required', 'exists:Eleves,IdEleve'],
            'password' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez saisir un identifiant.',
            'id.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            $this->repository->createPasswordStudent($validatedData['id'], $validatedData['password']);
            $user = $this->repository->getUserStudent($validatedData['id'], $validatedData['password']);
            $request->session()->put('user', $user);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.");
        }
        return redirect()->route('welcome.page');
    }

    public function loginStudent(Request $request){
        $rules = [
            'id' => ['required', 'exists:Eleves,IdEleve'],
            'password' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez saisir un identifiant.',
            'id.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            $user = $this->repository->getUserStudent($validatedData['id'], $validatedData['password']);
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
        $lessons = $this->repository->getDivisionLessonsLib($idDiv);
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
        $divisions = $this->repository->divisions();
        return view('group_add', ['groups' => $groups, 'divisions' => $divisions]);
    }

    public function addGroup(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'headcount' => ['required', 'between:1.0,35.0'],
            'divisions' => ['required']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'headcount.required' => 'Vous devez saisir l\'effectif prévu.',
            'headcount.between' => 'Vous devez saisir un effectif  entre 1 et 35.',
            'divisions.required' => 'Vous devez choisir au moins une division.',
        ];
        $validatedData = $request->validate($rules, $messages);
        $group = [
                'LibelleGrp' => $validatedData['lib'],
                'NiveauGrp' => $validatedData['grade'],
                'EffectifPrevGrp' => $validatedData['headcount']];
        try{
            $idGrp = $this->repository->insertGroup($group);
        } catch (Exception $exception) {
            return redirect()->route('group.form')->withInput()->withErrors("Impossible d'ajouter le groupe.");
        }
        try{
            $this->repository->linkGroupDivision($idGrp, $validatedData['divisions']);
        } catch (Exception $exception) {
            return redirect()->route('group.form')->withErrors("Le groupe n'a pas été associé aux divisions");
        }
        return redirect()->route('group.form')->with('status', 'Groupe ajouté avec succès !');
    }

    public function updateGroupForm(Request $request, string $idGrp){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $groups = $this->repository->groups();
        $group = $this->repository->getGroup($idGrp);
        $divisions = $this->repository->divisions();
        $groupDiv = $this->repository->getGroupDivisions($idGrp);
        return view('group_update', ['group'=> $group,
                                     'groups' => $groups,
                                     'divisions' => $divisions,
                                     'group_div' => $groupDiv]);
    }

    public function updateGroup(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required'],
            'lib' => ['required', 'min:2', 'max:40'],
            'grade' => ['required'],
            'headcount' => ['required', 'between:1.0,35.0'],
            'divisions' => ['required']
        ];
        $messages = [
            'lib.required' => 'Vous devez saisir un libellé.',
            'lib.min' => "Le libellé doit contenir au moins :min caractères.",
            'lib.max' => "Le libellé doit contenir au plus :max caractères.",
            'grade.required' => 'Vous devez sélectionner un niveau.',
            'headcount.required' => 'Vous devez saisir l\'effectif prévu.',
            'headcount.between' => 'Vous devez saisir un effectif  entre 1 et 35.',
            'divisions.required' => 'Vous devez choisir au moins une division.',
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
        try{
            $this->repository->linkGroupDivision($validatedData['id'], $validatedData['divisions']);
        } catch (Exception $exception) {
            return redirect()->route('group.update.form', ['idGrp' => $group['IdGrp']])->withErrors("Le groupe n'a pas été associé aux divisions");
        }
        return redirect()->route('group.update.form', ['idGrp' => $group['IdGrp']])->with('status', 'Groupe modifié avec succès !');
    }

    public function showGroup(Request $request, string $idGrp){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $group = $this->repository->getGroup($idGrp);
        $lessons = $this->repository->getGroupLessonsLib($idGrp);
        $students = $this->repository->getGroupStudents($idGrp);
        $groupDiv = $this->repository->getGroupDivisions($idGrp);
        return view('group_show', ['group'=> $group,
                                    'students' => $students,
                                    'lessons' => $lessons,
                                    'group_div' => $groupDiv]);
    }

    public function showTeachers(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $teachers = $this->repository->teachers();
        return view('teachers_show', ['teachers'=> $teachers]);
    }

    public function showTeacher(Request $request, string $idProf){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $teachers = $this->repository->teachers();
        $teacher = $this->repository->getTeacher($idProf);
        $lessons = $this->repository->getTeacherLessonsLib($idProf);
        $subjects = $this->repository->getTeacherSubjects($idProf);
        return view('teacher_show', ['teachers'=> $teachers,
                                    'teacher' => $teacher,
                                    'lessons' => $lessons,
                                    'subjects' => $subjects]);
    }

    public function showStudents(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $students = $this->repository->students();
        return view('students_show', ['students'=> $students]);
    }

    public function showStudent(Request $request, string $idEleve){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $students = $this->repository->students();
        $student = $this->repository->getStudent($idEleve);
        $lessons = $this->repository->getLessonsLib();
        $groups = $this->repository->getStudentGroup($idEleve);
        $options = $this->repository->getStudentOptionsLib($idEleve);
        return view('student_show', ['students'=> $students,
                                    'student' => $student,
                                    'lessons' => $lessons,
                                    'groups' => $groups,
                                    'options' => $options]);
    }

    public function fillDivisionForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $students = $this->repository->studentsNoDivision();
        $divisions = $this->repository->divisions();
        return view('division_fill', ['students'=> $students,
                                      'divisions' => $divisions]);
    }

    public function fillDivision(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required', 'exists:Divisions,IdDiv'],
            'students' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez sélectionner une division.',
            'id.exists' => 'Cette division n\'existe pas',
            'students.required' => 'Vous devez choisir au moins un étudiant.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->addDivisionStudents($validatedData['id'], $validatedData['students']);
        } catch (Exception $exception) {
            return redirect()->route('division.fill.form')->withInput()->withErrors("L'affectation n'a pas été prise en compte");
        }
        return redirect()->route('division.fill.form')->with('status', 'Affectation réalisée avec succès');
    }

    public function studentOption(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $students = $this->repository->students();
        return view('student_option', ['students'=> $students]);
    }

    public function studentOptionForm(Request $request, string $idEleve){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $students = $this->repository->students();
        $student = $this->repository->getStudent($idEleve);
        $subjects = $this->repository->optionalSubjects();
        $studentOptions = $this->repository->getStudentOptions($idEleve);
        return view('student_option_form', ['students'=> $students,
                                    'student' => $student,
                                    'subjects' => $subjects,
                                    'student_options' => $studentOptions]);
    }

    public function addStudentOption(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required', 'exists:Eleves,IdEleve'],
            'options' => []
        ];
        $messages = [
            'id.required' => 'Vous devez sélectionner un élève.',
            'id.exists' => 'Cet élève n\'existe pas',
        ];
        $validatedData = $request->validate($rules, $messages);
        if(!$request->has('options'))
            $validatedData['options'] = [];
        try{
            $this->repository->addStudentOption($validatedData['id'], $validatedData['options']);
        } catch (Exception $exception) {
            return redirect()->route('student.option.form', ['idEleve' => $validatedData['id']])->withInput()->withErrors("L'affectation n'a pas été prise en compte");
        }
        return redirect()->route('student.option.form', ['idEleve' => $validatedData['id']])->with('status', 'Affectation réalisée avec succès');
    }

    public function fillGroupForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $students = $this->repository->students();
        $groups = $this->repository->groups();
        $divisions = $this->repository->divisions();
        $groupLinks = $this->repository->groupLinks();
        $options = $this->repository->optionalSubjects();
        $optionChoices = $this->repository->options();
        return view('group_fill', ['students'=> $students,
                                      'groups' => $groups,
                                      'divisions' => $divisions,
                                      'group_links' => $groupLinks,
                                      'options' => $options,
                                      'option_choices' => $optionChoices]);
    }

         function fillGroup(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required', 'exists:Groupes,IdGrp'],
            'students' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez sélectionner un groupe.',
            'id.exists' => 'Ce groupe n\'existe pas',
            'students.required' => 'Vous devez choisir au moins un étudiant.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->addGroupStudents($validatedData['id'], $validatedData['students']);
        } catch (Exception $exception) {
            return redirect()->route('group.fill.form')->withInput()->withErrors("L'affectation n'a pas été prise en compte");
        }
        return redirect()->route('group.fill.form')->with('status', 'Affectation réalisée avec succès');
    }

    public function addScheduleForm(Request $request)
{
    $hasKey = $request->session()->has('user');
    if (!$hasKey || $request->session()->get('user')['role'] != 'dir') {
        return redirect()->route('login');
    }
    $schedules = $this->repository->schedules();
    return view('schedule_add',['schedules'=>$schedules]);
}

    public function profConstraints(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'prof')
            return redirect()->route('login');
        $times = $this->repository->schedules();
        $id = $request->session()->get('user')['id'];
        $constraints1 = $this->repository->getTeacherConstraints($id, 1);
        $constraints2 = $this->repository->getTeacherConstraints($id, 2);
        $startMorning = $this->repository->getStartTimesMorning();
        $startAfternoon = $this->repository->getStartTimesAfternoon();
        return view('teacher_constraints', ['times' => $times,
                                            'first_constraints' => $constraints1,
                                            'sec_constraints' => $constraints2,
                                            'id_prof' => $id,
                                            'start_morning' => $startMorning,
                                            'start_afternoon' => $startAfternoon]);
    }

    public function updateProfConstraints(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'prof')
            return redirect()->route('login');
        $rules = ['first' => ['required', 'array', 'max:5'],
                  'second' => ['required', 'array', 'max:5']
        ];
        $messages = [
            'first.required' => 'Vous devez sélectionner au moins un créneau horaire.',
            'second.required' => 'Vous devez sélectionner au moins un créneau horaire.',
            'first.max' => 'Vous devez sélectionner au plus 5 créneaux horaires.',
            'second.max' => 'Vous devez sélectionner au plus 5 créneaux horaires.',
        ];
        $validatedData = $request->validate($rules, $messages);
        $id = $request->session()->get('user')['id'];
        try{
            $this->repository->addTeacherConstraints($id, $validatedData['first'], $validatedData['second']);
        } catch (Exception $exception) {
            return redirect()->route('update.prof.constraints')->withInput()->withErrors("Impossible d'actualiser les contraintes.");
        }
        return redirect()->route('update.prof.constraints')->with('status', 'Contraintes actualisées avec succès !');
    }

    public function addSchedule(Request $request){
        $hasKey = $request->session()->has('user');
        if (!$hasKey || $request->session()->get('user')['role'] !== 'dir')
            return redirect()->route('login');

        $validatedData = $request->validate([
            'horaire' => ['required', 'unique:horaires,Horaire'],
            'jour' => ['required'],
            'heure_debut' => ['required'],
            'heure_fin' => ['required'],
        ], [
            'horaire.required' => 'Vous devez saisir un horaire.',
            'horaire.unique' => 'Cet horaire existe déjà.',
            'jour.required' => 'Vous devez sélectionner un jour.',
            'heure_debut.required' => 'Vous devez sélectionner une heure de début.',
            'heure_fin.required' => 'Vous devez sélectionner une heure de fin.',
        ]);

        $schedule = [
            'Horaire' => $validatedData['horaire'],
            'Jour' => $validatedData['jour'],
            'HeureDebut' => $validatedData['heure_debut'],
            'HeureFin' => $validatedData['heure_fin'],
        ];

        try {
            $this->repository->insertSchedule($schedule);
        } catch (Exception $exception) {
            return redirect()->route('schedule.form')->withInput()->withErrors("Impossible d'ajouter l'horaire.");
        }
        return redirect()->route('schedule.form')->with('status','Horaire ajouté avec succès');
    }

    public function updateScheduleForm(Request $request, string $horaire){
        $hasKey = $request->session()->has('user');
        if (!$hasKey || $request->session()->get('user')['role'] !== 'dir') {
            return redirect()->route('login');
        }
        $schedules =$this->repository->schedules();
        $schedule =$this->repository->getSchedules($horaire);
        return view('schedule_update', ['schedule' => $schedule, 'schedules' => $schedules]);
    }

    public function showSchedules(Request $request){
        $hasKey = $request->session()->has('user');
        if (!$hasKey || $request->session()->get('user')['role'] !== 'dir') {
            return redirect()->route('login');
        }
        $schedules =$this->repository->schedules();
        $collegeSchedule = $this->repository->collegeSchedule();
        return view('schedule_show', ['schedules' => $schedules,
                                      'college_schedule' => $collegeSchedule]);
    }

    public function generateSchedules(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'start_day' => ['required'],
            'end_day' => ['required'],
            'start_break' => ['required'],
            'end_break' => ['required'],
            'mornings' => ['required'],
            'afternoons' => ['required'],
            'interval' => ['required']
        ];
        $messages = [
            'start_day.required' => 'Vous devez sélectionner l\'horaire de début.',
            'end_day.required' => 'Vous devez sélectionner l\'horaire de fin.',
            'start_break.required' => 'Vous devez sélectionner l\'horaire de début de la pause.',
            'end_break.required' => 'Vous devez sélectionner l\'horaire de fin de la pause.',
            'mornings.required' => 'Vous devez sélectionner les matinées d\'ouverture.',
            'afternoons.required' => 'Vous devez sélectionner les après-midi d\ouverture.',
            'interval.required' => 'Vous devez sélectionner la durée de l\'interclasse.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->generateSchedule(['start' => $validatedData['start_day'],
                                                 'end' => $validatedData['end_day']],
                                                 ['start' => $validatedData['start_break'],
                                                 'end' => $validatedData['end_break']],
                                                $validatedData['mornings'],
                                                $validatedData['afternoons'],
                                                $validatedData['interval']);
        } catch (Exception $exception) {
            return redirect()->route('schedule.show')->withInput()->withErrors("Impossible de générer les horaires.");
        }
        return redirect()->route('schedule.show')->with('status', 'Horaires générés avec succès');
    }

    public function updateSchedules(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $validatedData = $request->validate([
            'horaire' => ['required'],
            'heure_debut' => ['required'],
            'heure_fin' => ['required'],
        ], [
            'horaire.required' => 'Vous devez saisir un horaire.',
            'heure_debut.required' => 'Vous devez sélectionner une heure de début.',
            'heure_fin.required' => 'Vous devez sélectionner une heure de fin.',
        ]);

        $schedule = [
            'Horaire' => $validatedData['horaire'],
            'HeureDebut' => $validatedData['heure_debut'],
            'HeureFin' => $validatedData['heure_fin'],
        ];

        try {
            $this->repository->updateSchedules($schedule);
        } catch (Exception $exception) {
            return redirect()->route('schedule.update.form', ['horaire' => $schedule['Horaire']])->withInput()->withErrors("Impossible de modifier l'horaire.");
        }
        return redirect()->route('schedule.form')->with('status', "Horaire {$validatedData['horaire']} modifié avec succès !");
    }
    ### classrooms constraints ####
    public function classroomConstraints(Request $request)
    {
        $hasKey = $request->session()->has('user');
        if (!$hasKey || $request->session()->get('user')['role'] != 'dir') {
            return redirect()->route('login');
        }

        $constraints = $this->repository->getClassroomConstraints();
        $lessons = $this->repository->lessons();
        $classrooms = $this->repository->types();
        $subjects = $this->repository->subjects();

        return view('classrooms_constraints_add', [
            'constraints' => $constraints,
            'lessons' => $lessons,
            'classrooms' => $classrooms,
            'subjects' => $subjects,
        ]);
    }
    public function addConstraintsClassrooms(Request $request)
    {
        $hasKey = $request->session()->has('user');
        if (!$hasKey || $request->session()->get('user')['role'] != 'dir') {
            return redirect()->route('login');
        }

        $validatedData = $request->validate([
            'type' => 'required|exists:TypesSalles,TypeSalle',
            'subject' => 'required|exists:Enseignements, IdEns',
            'timeamount' => 'required|numeric',
            'mintime' => 'required|integer|min:1',
        ], [
            'type.required' => 'Le type de salle est obligatoire.',
            'type.exists' => 'Le type de salle sélectionné est invalide.',
            'subject.required' => 'L\'identifiant du cours est obligatoire.',
            'subject.exists' => 'L\'identifiant du cours sélectionné est invalide.',
            'timeamount.required' => 'Le volume horaire de la salle est obligatoire.',
            'timeamount.numeric' => 'Le volume horaire de la salle doit être numérique.',
            'mintime.required' => 'La durée minimale de la salle est obligatoire.',
            'mintime.integer' => 'La durée minimale de la salle doit être un nombre entier.',
            'mintime.min' => 'La durée minimale de la salle doit être supérieure ou égale à 1.',
        ]);

        try {
            $this->repository->addConstraintsClassrooms($validatedData);
            return redirect()->route('constraints.classrooms.add.form')->with('status', 'Contrainte ajoutée avec succès !');
        } catch (Exception $exception) {
            return redirect()->route('constraints.classrooms.add.form')->withInput()->withErrors("Impossible d'ajouter la contrainte.");
        }
    }
    public function addConstraintsClassroomsForm(Request $request)
    {
        $hasKey = $request->session()->has('user');
        if (!$hasKey || $request->session()->get('user')['role'] != 'dir') {
            return redirect()->route('login');
        }

        $lessons = $this->repository->lessons();
        $classrooms = $this->repository->classrooms();
        $subjects = $this->repository->subjects();

        return view('classrooms_constraints', [
            'lessons' => $lessons,
            'classrooms' => $classrooms,
            'subjects' => $subjects,
        ]);
    }
     function updateConstraintsClassrooms(Request $request){
    $hasKey = $request->session()->has('user');
    if (!$hasKey || $request->session()->get('user')['role'] != 'dir') {
        return redirect()->route('login');
    }

    $validatedData = $request->validate([
        'TypeSalle' => 'required|exists:TypesSalles,TypeSalle',
        'IdCours' => 'required|exists:Cours,IdCours|regex:/^CR.+$/',
        'VolHSalle' => 'required|numeric',
        'DureeMinSalle' => 'required|integer|min:1',
    ], [
        'TypeSalle.required' => 'Le type de salle est obligatoire.',
        'TypeSalle.exists' => 'Le type de salle sélectionné est invalide.',
        'IdCours.required' => 'L\'identifiant du cours est obligatoire.',
        'IdCours.exists' => 'L\'identifiant du cours sélectionné est invalide.',
        'IdCours.regex' => 'L\'identifiant du cours doit commencer par les caractères "CR".',
        'VolHSalle.required' => 'Le volume horaire de la salle est obligatoire.',
        'VolHSalle.numeric' => 'Le volume horaire de la salle doit être numérique.',
        'DureeMinSalle.required' => 'La durée minimale de la salle est obligatoire.',
        'DureeMinSalle.integer' => 'La durée minimale de la salle doit être un nombre entier.',
        'DureeMinSalle.min' => 'La durée minimale de la salle doit être supérieure ou égale à 1.',
    ]);

    try{
        $this->repository->addConstraintsClassrooms($validatedData);
    } catch (Exception $exception) {
        return redirect()->route('constraints.classrooms.update.form')->withInput()->withErrors("Impossible d'ajouter la contrainte.");
    }
    return redirect()->route('constraints.classrooms.update.form')->with('status', 'Contrainte ajoutée avec succès !');
    }
    public function updateConstraintsClassroomsForm(Request $request, $id) {
        $hasKey = $request->session()->has('user');
        if (!$hasKey || $request->session()->get('user')['role'] != 'dir') {
            return redirect()->route('login');
        }

        $constraint = $this->repository->constraintsClassrooms();
        $lessons = $this->repository->lessons();
        $classrooms = $this->repository->classrooms();
        $subjects = $this->repository->subjects();

        return view('classrooms_constraints_update', [
            'constraint' => $constraint,
            'lessons' => $lessons,
            'classrooms' => $classrooms,
            'subjects' => $subjects,
        ]);
    }
     ###### STUDENTS ##########
     public function addStudentForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
                return view('student_add');
        }
    public function addStudent(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
            $rules = [
                'name' => ['required', 'min:2', 'max:15'],
                'firstname' => ['required', 'min:2', 'max:15'],
                'birthdate' => ['required'],
                'level' => ['required', 'regex:/^[0-9]{1,2}(EME)$/']
            ];

            $messages = [
                'name.required' => 'Vous devez saisir un nom.',
                'firstname.required' => 'Vous devez saisir un prénom.',
                'name.min' => "Le nom doit contenir au moins :min caractères.",
                'name.max' => "Le nom doit contenir au plus :max caractères.",
                'firstname.min' => "Le prénom doit contenir au moins :min caractères.",
                'firstname.max' => "Le prénom doit contenir au plus :max caractères.",
                'birthdate.required' => 'Vous devez saisir une année de naissance.',
                'level.required' => 'Vous devez saisir un niveau.',
                'level.regex' => 'Le niveau doit être au format XXEME (exemple : 6EME).'
            ];
                $validatedData = $request->validate($rules, $messages);
                $student = [
                    'NomEleve' => $validatedData['name'],
                    'PrenomEleve' => $validatedData['firstname'],
                    'AnneeNaisEleve' => $validatedData['birthdate'],
                    'NiveauEleve' => $validatedData['level']
                ];

                try {
                    $this->repository->insertStudent($student);
                } catch (Exception $exception) {
                    return redirect()->route('student.form')->withInput()->withErrors("Impossible d'ajouter l'élève.");
                }

                return redirect()->route('student.form')->with('status', 'Elève ajouté avec succès !');
            }
    public function updateStudentList(Request $request){
        $hasKey = $request->session()->has('user');
            if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
                return redirect()->route('login');
            $students = $this->repository->students();
        return view('student_update', ['students' => $students]);
        }
        public function updateStudentForm(Request $request, String $idEleve) {
            $hasKey = $request->session()->has('user');
            if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
                return redirect()->route('login');
            $students = $this->repository->students();
            $student = $this->repository->getStudentId($idEleve);
            $divisions = $this->repository->divisions();
            return view('student_update_form', ['idEleve'=>$idEleve,
                                                'student'=> $student,
                                                'students' => $students,
                                                'divisions' => $divisions]);
        }
        public function updateStudent(Request $request, $id){
            $hasKey = $request->session()->has('user');
            if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
                return redirect()->route('login');
            $rules = [
                'name' => ['required', 'min:2', 'max:15'],
                'firstname' => ['required', 'min:2', 'max:15'],
                'birthdate' => ['required', 'integer'],
                'level' => ['required'],
                'division' =>['required']
            ];
            $messages = [
                'name.required' => 'Vous devez saisir un nom.',
                'firstname.required' => 'Vous devez saisir un prénom.',
                'name.min' => "Le nom doit contenir au moins :min caractères.",
                'name.max' => "Le nom doit contenir au plus :max caractères.",
                'firstname.min' => "Le prénom doit contenir au moins :min caractères.",
                'firstname.max' => "Le prénom doit contenir au plus :max caractères.",
                'birthdate.required' => 'Vous devez saisir une date de naissance.',
                'birthdate.integer' => 'Vous devez saisir une date valide.',
                'level.required' => 'Vous devez saisir un niveau.',
                'division.required' => 'Vous devez sélectionner une division.'
            ];
            $validatedData = $request->validate($rules, $messages);
            $student = [
                'IdEleve' => $id,
                'NomEleve' => $validatedData['name'],
                'PrenomEleve' => $validatedData['firstname'],
                'AnneeNaisEleve' => $validatedData['birthdate'],
                'NiveauEleve' => $validatedData['level'],
                'IdDiv' => $validatedData['division']
            ];
            try {
                $this->repository->updateStudent($student);
            } catch (Exception $exception) {
                return redirect()->route('student.update.form', ['IdEleve' => $id])->withInput()->withErrors("Impossible de modifier l'elève.");
            }
            return redirect()->route('student.update.form', ['IdEleve' => $id])->with('status', 'Elève modifié avec succès !');
        }

    public function subjectsConstraintsForm(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subjects = $this->repository->subjects();
        $times = $this->repository->schedules();
        $startMorning = $this->repository->getStartTimesMorning();
        $startAfternoon = $this->repository->getStartTimesAfternoon();
        return view('subjects_constraints', ['subjects'=> $subjects,
                                    'times' => $times,
                                    'start_morning' => $startMorning,
                                    'start_afternoon' => $startAfternoon]);
    }

    public function subjectConstraintsForm(Request $request, string $idEns){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subject = $this->repository->getSubject($idEns);
        $subjects = $this->repository->subjects();
        $times = $this->repository->schedules();
        $constraints1 = $this->repository->getSubjectConstraints($idEns, 1);
        $constraints2 = $this->repository->getSubjectConstraints($idEns, 2);
        $startMorning = $this->repository->getStartTimesMorning();
        $startAfternoon = $this->repository->getStartTimesAfternoon();
        return view('subject_constraints', ['subject' => $subject,
                                    'subjects'=> $subjects,
                                    'times' => $times,
                                    'first_cons' => $constraints1,
                                    'sec_cons' => $constraints2,
                                    'start_morning' => $startMorning,
                                    'start_afternoon' => $startAfternoon]);
    }

    public function updateSubjectConstraints(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required_without:level'],
            'level' => ['required_without:id'],
            'first' => ['array'],
            'second' => ['array']
        ];
        $messages = [
            'id.required_withount' => 'Vous devez sélectionner un enseignement ou un niveau.',
            'level.required_without' => 'Vous devez sélectionner un enseignement ou un niveau.',
        ];
        $validatedData = $request->validate($rules, $messages);
        if(!$request->has('first'))
            $validatedData['first'] = [];
        if(!$request->has('second'))
            $validatedData['second'] = [];
        if($request->has('id') && $validatedData['id'] != "all"){
            try{
                $this->repository->addSubjectConstraints($validatedData['id'], $validatedData['first'], $validatedData['second']);
            } catch (Exception $exception) {
                return redirect()->route('subjects.constraints')->withInput()->withErrors("Impossible d'actualiser les contraintes.");
            }
        }
        else {
            try{
                $this->repository->addLevelConstraints($validatedData['level'], $validatedData['first'], $validatedData['second']);
            } catch (Exception $exception) {
                return redirect()->route('subjects.constraints')->withInput()->withErrors("Impossible d'actualiser les contraintes.");
            }
        }
        return redirect()->route('subjects.constraints')->with('status', 'Contraintes actualisées avec succès');
    }

    public function showDataPreprocess(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subjects = $this->repository->subjectsNoTeacher();
        $teachers = $this->repository->teachersLackVolume();
        $studentsNoDiv = $this->repository->studentsNoDivision();
        $studentsNoLV1 = $this->repository->studentsNoLV1();
        $studentsNoLV2 = $this->repository->studentsNoLV2();
        $studentsNoLV1Gp = $this->repository->studentsNoLV1Group();
        $studentsNoLV2Gp = $this->repository->studentsNoLV2Group();
        $divisions = $this->repository->divisionSubjectsCount();
        $divisionsVol = $this->repository->divisionLackingVolume();
        $unitCount = $this->repository->getUnitCount();
        $lastPreprocess = $this->repository->lastPreprocess();

        $lastBDUpdate = $this->repository->lastDBUpdate();
        $availability = $this->repository->evaluateAvailability();
        return view('data_preprocess', ['students_no_div' => $studentsNoDiv,
                                        'students_no_lv1' => $studentsNoLV1,
                                        'students_no_lv2' => $studentsNoLV2,
                                        'students_no_glv1' => $studentsNoLV1Gp,
                                        'students_no_glv2' => $studentsNoLV2Gp,
                                        'subjects' => $subjects,
                                        'teachers' => $teachers,
                                        'divisions' => $divisions,
                                        'divisions_vol' => $divisionsVol,
                                        'unit_count' => $unitCount,
                                        'last_preprocess' => $lastPreprocess,
                                        'last_update' => $lastBDUpdate,
                                        'availability' => $availability]);
    }

    public function preprocessData(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        try{
            $this->repository->preprocess();
        } catch (Exception $exception) {
            return redirect()->route('data.preprocess')->withInput()->withErrors("Impossible de réaliser le pré-traitement");
        }
        return redirect()->route('data.preprocess')->with('status', 'Pré-traitement des données réalisé avec succès');
    }

    public function showSubjectIncompatibility(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $subjects = $this->repository->subjects();
        $subjectsLib = $this->repository->subjectsLib();
        $incomp = $this->repository->scheduleIncompatibilities();
        return view('subject_incompatibility', ['subjects'=> $subjects,
                                                'incomp' => $incomp,
                                                'subjects_lib'=> $subjectsLib]);
    }

    public function addSubjectIncompatibility(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'subject1' => ['required'],
            'subject2' => ['required'],
        ];
        $messages = [
            'subject1.required' => 'Vous devez sélectionner un enseignement.',
            'subject2.required' => 'Vous devez sélectionner un deuxième enseignement.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->addScheduleIncompatibility($validatedData['subject1'], $validatedData['subject2']);
        } catch (Exception $exception) {
            return redirect()->route('subject.incompatibility')->withInput()->withErrors("Impossible d'ajouter les contraintes.");
        }
        return redirect()->route('subject.incompatibility')->with('status', 'Contrainte ajoutée avec succès');
    }

    public function deleteSubjectIncompatibility(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'subject1' => ['required'],
            'subject2' => ['required'],
        ];
        $messages = [
            'subject1.required' => 'Vous devez sélectionner un enseignement.',
            'subject2.required' => 'Vous devez sélectionner un deuxième enseignement.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->deleteScheduleIncompatibility($validatedData['subject1'], $validatedData['subject2']);
        } catch (Exception $exception) {
            return redirect()->route('subject.incompatibility')->withInput()->withErrors("Impossible de supprimer les contraintes.");
        }
        return redirect()->route('subject.incompatibility')->with('status', 'Contrainte suprimée avec succès');
        }

        ###### fiche établissement ########
    public function showInfo(){
        $nombreEleves = $this->repository->getNombreEleves();
        $nombreEnseignants = $this->repository->getNombreEnseignants();
        $nombreDivisionsParNiveau = $this->repository->getNombreDivisionsParNiveau();
        $nombreInfrastructuresParType = $this->repository->getNombreInfrastructuresParType();
        $horairesOuverture = $this->repository->getHorairesOuverture();
        $collegeSchedule = $this->repository->collegeSchedule();
        return view('school_show', [
            'nombreEleves' => $nombreEleves,
            'college_schedule' => $collegeSchedule,
            'nombreEnseignants' => $nombreEnseignants,
            'nombreDivisionsParNiveau' => $nombreDivisionsParNiveau,
            'nombreInfrastructuresParType' => $nombreInfrastructuresParType,
            'horairesOuverture' => $horairesOuverture
        ]);
    }

    public function showTeacherPlanning(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'prof')
            return redirect()->route('login');
        $times = $this->repository->schedules();
        $id = $request->session()->get('user')['id'];
        $teacher = $this->repository->getTeacher($id);
        $planning = $this->repository->getTeacherPlanning($id);
        $divisions = $this->repository->getTeacherDiv($id);
        $groups = $this->repository->getTeacherGrp($id);
        $startMorning = $this->repository->getStartTimesMorning();
        $startAfternoon = $this->repository->getStartTimesAfternoon();
        return view('teacher_planning', ['times' => $times,
                                            'teacher' => $teacher,
                                            'planning' => $planning,
                                            'divisions' => $divisions,
                                            'groups' => $groups,
                                            'start_morning' => $startMorning,
                                            'start_afternoon' => $startAfternoon]);
    }

    public function showStudentPlanning(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'student')
            return redirect()->route('login');
        $times = $this->repository->schedules();
        $id = $request->session()->get('user')['id'];
        $student = $this->repository->getStudent($id);
        $planning = $this->repository->getStudentPlanning($id);
        $startMorning = $this->repository->getStartTimesMorning();
        $startAfternoon = $this->repository->getStartTimesAfternoon();
        return view('student_planning', ['times' => $times,
                                            'planning' => $planning,
                                            'student' => $student,
                                            'start_morning' => $startMorning,
                                            'start_afternoon' => $startAfternoon]);
    }

    public function showPlanning(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $times = $this->repository->schedules();
        $planning = $this->repository->getAllPlanning();
        $teachers = $this->repository->teachers();
        $divisions = $this->repository->divisions();
        $groups = $this->repository->getGroups();
        $startMorning = $this->repository->getStartTimesMorning();
        $startAfternoon = $this->repository->getStartTimesAfternoon();
        return view('planning_show', ['times' => $times,
                                            'teachers' => $teachers,
                                            'planning' => $planning,
                                            'divisions' => $divisions,
                                            'groups' => $groups,
                                            'start_morning' => $startMorning,
                                            'start_afternoon' => $startAfternoon]);
    }

    public function moveClassPlanning(Request $request, string $unit){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $times = $this->repository->schedules();
        $planning = $this->repository->getUnitIncompatibility($unit);
        $unitInfo = $this->repository->getUnit($unit);
        $startMorning = $this->repository->getStartTimesMorning();
        $startAfternoon = $this->repository->getStartTimesAfternoon();
        $classrooms = $this->repository->getClassroomsOfSameType($unit);
        return view('planning_update', ['times' => $times,
                                            'planning' => $planning,
                                            'classrooms' => $classrooms,
                                            'unit' => $unitInfo,
                                            'start_morning' => $startMorning,
                                            'start_afternoon' => $startAfternoon]);
    }

    public function updatePlanning(Request $request){
        $hasKey = $request->session()->has('user');
        if(!$hasKey || $request->session()->get('user')['role'] != 'dir')
            return redirect()->route('login');
        $rules = [
            'id' => ['required'],
            'schedule' => ['required'],
            'week' => ['required'],
            'room' => ['required']
        ];
        $messages = [
            'id.required' => 'Vous devez sélectionner un cours.',
            'schedule.required' => 'Vous devez sélectionner un horaire.',
            'week.required' => 'Vous devez sélectionner une semaine.',
            'room.required' => 'Vous devez sélectionner une salle.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            $this->repository->updateUnit($validatedData);
        } catch (Exception $exception) {
            return redirect()->route('planning.move', ['unit' => $validatedData['id']])->withInput()->withErrors("Impossible de modifier le planning.");
        }
        return redirect()->route('planning.move', ['unit' => $validatedData['id']])->with('status', 'Planning modifié avec succès.');
    }
}


