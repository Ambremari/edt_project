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

    public function addTeacherForm(){
        return view('teacher_add');
    }

    public function addTeacher(Request $request){
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
}
