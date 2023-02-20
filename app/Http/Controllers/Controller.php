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
}
