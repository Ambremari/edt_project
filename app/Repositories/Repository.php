<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Repository {
    function createDatabase(): void {
        DB::unprepared(file_get_contents('database/build.sql'));
    }

    function insertTeacher(array $teacher): void {
        if(!array_key_exists('IdProf', $teacher)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $teacher['IdProf'] = "PRF".$id;
        }
        DB::table('Enseignants')
            ->insert($teacher);
    }

    function teachers() : array{
        return DB::table('Enseignants')
                    ->get()
                    ->toArray();
    }

    function getTeacher(string $name, string $firstname) : array{
        $teacher = DB::table('Enseignants')
                    ->where('nomProf', $name)
                    ->where('firstname', $firstname)
                    ->get()
                    ->toArray();
        if(empty($teacher))
            throw new Exception('Enseignant inconnu'); 
        return $teacher[0];
    }
}