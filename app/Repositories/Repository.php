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
        foreach($teachers as $row)
            $this->insertTeacher($row);
        foreach($directors as $row)
            $this->insertDirector($row);
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

    
}
