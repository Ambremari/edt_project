<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Data;

class Repository {
    function createDatabase(): void {
        DB::unprepared(file_get_contents('database/build.sql'));
    }

    function fillDatabase(): void{
        $data = new Data();
        $directors = $data->directors();
        $teachers = $data->teachers();
        $subjects = $data->subjects();
        $divisions = $data->divisions();
        $groups = $data->groups();
        $types = $data->types();
        $classrooms = $data->classrooms();
        foreach($teachers as $row)
            $this->insertTeacher($row);
        foreach($directors as $row)
            $this->insertDirector($row);
        foreach($subjects as $row)
            $this->insertSubject($row);
        foreach($divisions as $row)
            $this->insertDivision($row);
        foreach($groups as $row)
            $this->insertGroup($row);
        foreach($types as $row)
            $this->insertType($row);
        foreach($classrooms as $row)
            $this->insertClassroom($row);
    }

    function insertTeacher(array $teacher): void {
        if(!array_key_exists('IdProf', $teacher)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $teacher['IdProf'] = "PRF".$id;
        }
        if(array_key_exists('MdpProf', $teacher)){
            $passwordHash = Hash::make($teacher['MdpProf']);
            $teacher['MdpProf'] = $passwordHash;
        }
        DB::table('Enseignants')
            ->insert($teacher);
    }

    function teachers() : array{
        return DB::table('Enseignants')
                    ->orderBy('NomProf')
                    ->orderBy('PrenomProf')
                    ->get(['IdProf', 'NomProf', 'PrenomProf', 'MailProf', 'VolHProf'])
                    ->toArray();
    }

    function getTeacher(string $id) : array{
        $teacher = DB::table('Enseignants')
                    ->where('IdProf', $id)
                    ->get(['IdProf', 'NomProf', 'PrenomProf', 'MailProf', 'VolHProf'])
                    ->toArray();
        if(empty($teacher))
            throw new Exception('Enseignant inconnu'); 
        return $teacher[0];
    }

    function createPasswordTeacher(string $id, string $email, string $password): void{
        $users = DB::table('Enseignants')
                ->where('MailProf', $email)
                ->where('IdProf', $id)
                ->where('MdpProf', null)
                ->get()
                ->toArray();
        if(empty($users))
            throw new Exception('Utilisateur inconnu');
        $user = $users[0];
        $hashedPassword = Hash::make($password);
        DB::table('Enseignants')
            ->where('IdProf', $id)
            ->update(['MdpProf' => $hashedPassword]);
    }

    function getUserTeacher(string $id, string $password): array{
        $users = DB::table('Enseignants')
                ->where('IdProf', $id)
                ->get()
                ->toArray();
        if(empty($users))
            throw new Exception('Utilisateur inconnu');
        $user = $users[0];
        if(!Hash::check($password, $user['MdpProf']))    
            throw new Exception('Utilisateur inconnu');
        return [
            'id' => $user['IdProf'], 
            'name'=> $user['NomProf'], 
            'firstname'=> $user['PrenomProf'],
            'role'=> 'prof'];  
    }

    function updateTeacher(array $teacher): void{
        $users = DB::table('Enseignants')
                ->where('IdProf', $teacher['IdProf'])
                ->get()
                ->toArray();
        if(empty($users))
            throw new Exception('Utilisateur inconnu');
        DB::table('Enseignants')
            ->where('IdProf', $teacher['IdProf'])
            ->update($teacher);
    }

    function directors() : array{
        return DB::table('Directeurs')
                    ->get('IdDir')
                    ->toArray();
    }

    function insertDirector(array $director): void {
        if(!array_key_exists('IdDir', $director)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $director['IdDir'] = "DIR".$id;
        }
        if(array_key_exists('MdpDir', $director)){
            $passwordHash = Hash::make($director['MdpDir']);
            $director['MdpDir'] = $passwordHash;
        }
        DB::table('Directeurs')
            ->insert($director);
    }

    function getUserDirector(string $id, string $password): array{
        $users = DB::table('Directeurs')
                ->where('IdDir', $id)
                ->get()
                ->toArray();
        if(empty($users))
            throw new Exception('Utilisateur inconnu');
        $user = $users[0];
        if(!Hash::check($password, $user['MdpDir']))    
            throw new Exception('Utilisateur inconnu');
        return [
            'id' => $user['IdDir'], 
            'name'=> $user['NomDir'], 
            'firstname'=> $user['PrenomDir'],
            'role'=> 'dir'];  
    }

    function insertSubject(array $subject): void {
        if(!array_key_exists('IdEns', $subject)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $subject['IdEns'] = "ENS".$id;
        }
        DB::table('Enseignements')
            ->insert($subject);
    }

    function subjects() : array{
        return DB::table('Enseignements')
                    ->orderBy('NiveauEns')
                    ->orderBy('LibelleEns')
                    ->get()
                    ->toArray();
    }

    function getSubject(string $id) : array{
        $subject = DB::table('Enseignements')
                    ->where('IdEns', $id)
                    ->get()
                    ->toArray();
        if(empty($subject))
            throw new Exception('Enseignement inconnu'); 
        return $subject[0];
    }

    function updateSubject(array $subject): void{
        $subjects = DB::table('Enseignements')
                ->where('IdEns', $subject['IdEns'])
                ->get()
                ->toArray();
        if(empty($subjects))
            throw new Exception('Enseignement inconnu');
        DB::table('Enseignements')
            ->where('IdEns', $subject['IdEns'])
            ->update($subject);
    }

    function insertDivision(array $division): void {
        if(!array_key_exists('IdDiv', $division)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $division['IdDiv'] = "DIV".$id;
        }
        DB::table('Divisions')
            ->insert($division);
    }

    function divisions() : array{
        return DB::table('Divisions as D')
                    ->join('DivisionCount as C', 'D.IdDiv', '=', 'C.IdDiv')
                    ->orderBy('NiveauDiv')
                    ->orderBy('LibelleDiv')
                    ->get(['D.*', 'EffectifReelDiv'])
                    ->toArray();
    }

    function getDivision(string $id) : array{
        $division = DB::table('Divisions as D')
                    ->join('DivisionCount as C', 'D.IdDiv', '=', 'C.IdDiv')
                    ->where('D.IdDiv', $id)
                    ->get(['D.*', 'EffectifReelDiv'])
                    ->toArray();
        if(empty($division))
            throw new Exception('Division inconnue'); 
        return $division[0];
    }

    function updateDivision(array $division): void{
        $divisions = DB::table('Divisions')
                        ->where('IdDiv', $division['IdDiv'])
                        ->get()
                        ->toArray();
        if(empty($divisions))
            throw new Exception('Division inconnue');
        DB::table('Divisions')
            ->where('IdDiv', $division['IdDiv'])
            ->update($division);
    }

    function insertGroup(array $group): void {
        if(!array_key_exists('IdGrp', $group)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $group['IdGrp'] = "GRP".$id;
        }
        DB::table('Groupes')
            ->insert($group);
    }

    function groups() : array{
        return DB::table('Groupes as G')
                    ->join('GroupCount as C', 'G.IdGrp', '=', 'C.IdGrp')
                    ->orderBy('NiveauGrp')
                    ->orderBy('LibelleGrp')
                    ->get(['G.*', 'EffectifReelGrp'])
                    ->toArray();
    }

    function getGroup(string $id) : array{
        $group = DB::table('Groupes as G')
                    ->join('GroupCount as C', 'G.IdGrp', '=', 'C.IdGrp')
                    ->where('G.IdGrp', $id)
                    ->get(['G.*', 'EffectifReelGrp'])
                    ->toArray();
        if(empty($group))
            throw new Exception('Group inconnu'); 
        return $group[0];
    }

    function updateGroup(array $group): void{
        $groups = DB::table('Groupes')
                        ->where('IdGrp', $group['IdGrp'])
                        ->get()
                        ->toArray();
        if(empty($groups))
            throw new Exception('Groupe inconnu');
        DB::table('Groupes')
            ->where('IdGrp', $group['IdGrp'])
            ->update($group);
    }

    function linkTeacherSubject(string $idProf, string $idEns): void{
        DB::table('Enseigne')
            ->insert(['IdProf' =>  $idProf,
                     'IdEns' => $idEns]);
    }

    function subjectlinks() : array{
        return DB::table('Enseigne')
                    ->get()
                    ->toArray();
    }

    function getTeacherSubjects(string $id) : array{
        $subjects = DB::table('Enseigne as T')
                    ->join('Enseignements as E', 'T.IdEns', '=', 'E.IdEns')
                    ->where('IdProf', $id)
                    ->get(['E.*'])
                    ->toArray();
        return $subjects;
    }

    function removeTeacherSubjectClass(string $idProf, string $idEns): void{
        DB::table('Cours')
            ->where('IdProf', $idProf)
            ->where('IdEns', $idEns)
            ->delete();
    }

    function linkTeacherClass(string $idProf, string $idEns, array $divisions, array $groups): void{
        $this->removeTeacherSubjectClass($idProf, $idEns);
        for($index = 0 ; $index < count($divisions) ; $index++){
            $id = dechex(time());
            $id = substr($id, 4, 10);
            $idCours = "CR".$id.$index;
            DB::table('Cours')
                ->insert(['IdCours' => $idCours,
                        'IdProf' =>  $idProf,
                        'IdEns' => $idEns,
                        'IdDiv' => $divisions[$index]]);
        }
        for($index = 0 ; $index < count($groups) ; $index++){
            $id = dechex(time());
            $id = substr($id, 5, 10);
            $idCours = "CR".$id."G".$index;
            DB::table('Cours')
                ->insert(['IdCours' => $idCours,
                        'IdProf' =>  $idProf,
                        'IdEns' => $idEns,
                        'IdGrp' => $groups[$index]]);
        }
    }


    function lessons() : array{
        return DB::table('Cours')
                    ->get(['IdProf', 'IdEns', 'IdDiv', 'IdGrp'])
                    ->toArray();
    }

    function getTeacherLessons(string $id) : array{
        return DB::table('Cours')
                    ->where('IdProf', $id)
                    ->get(['IdProf', 'IdEns', 'IdDiv', 'IdGrp'])
                    ->toArray();
    }

    function removeTeacherSubject(string $idProf, string $idEns): void{
        DB::table('Cours')
            ->where('IdProf', $idProf)
            ->where('IdEns', $idEns)
            ->delete();
        DB::table('Enseigne')
            ->where('IdProf', $idProf)
            ->where('IdEns', $idEns)
            ->delete();
    }

    function insertType(array $type): void {
        DB::table('TypesSalles')
            ->insert($type);
    }

    function types() : array{
        return DB::table('TypesSalles')
                    ->orderBy('TypeSalle')
                    ->get()
                    ->toArray();
    }

    function insertClassroom(array $classroom): void {
        if(!array_key_exists('IdSalle', $classroom)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $classroom['IdSalle'] = "SAL".$id;
        }
        DB::table('Salles')
            ->insert($classroom);
    }

    function classrooms() : array{
        return DB::table('Salles')
                    ->orderBy('TypeSalle')
                    ->orderBy('LibelleSalle')
                    ->get()
                    ->toArray();
    }

    function getClassroom(string $id) : array{
        $classroom = DB::table('Salles')
                    ->where('IdSalle', $id)
                    ->get()
                    ->toArray();
        if(empty($classroom))
            throw new Exception('Salle inconnue'); 
        return $classroom[0];
    }

    function updateClassroom(array $classroom): void{
        $classrooms = DB::table('Salles')
                        ->where('IdSalle', $classroom['IdSalle'])
                        ->get()
                        ->toArray();
        if(empty($classrooms))
            throw new Exception('Salle inconnue');
        DB::table('Salles')
            ->where('IdSalle', $classroom['IdSalle'])
            ->update($classroom);
    }

    function getDivisionLessons(string $id) : array{
        return DB::table('LibellesCours')
                    ->where('IdDiv', $id)
                    ->get()
                    ->toArray();
    }

    function getDivisionStudents(string $id) : array{
        return DB::table('Eleves')
                    ->where('IdDiv', $id)
                    ->get()
                    ->toArray();
    }

    function getGroupLessons(string $id) : array{
        return DB::table('LibellesCours')
                    ->where('IdGrp', $id)
                    ->get()
                    ->toArray();
    }

    function getGroupStudents(string $id) : array{
        return DB::table('CompoGroupes')
                    ->where('IdGrp', $id)
                    ->get()
                    ->toArray();
    }

    
}
