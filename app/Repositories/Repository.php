<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;

class Repository {
    function createDatabase(): void {
        DB::unprepared(file_get_contents('database/build.sql'));
    }
    public function updateTeacher($username)
    {
        $user = DB::table('Enseignants')->where('IdProf', $username)->get();
        if (!$user) {
            $password = $this->createPassword(); 
            $hashedPassword = Hash::make($password);

            $user = new User;
            $user->username = $username;
            $user->password = $hashedPassword;

            $user->save();
            return $password;
        }
    
        return null;
    }
    
    private function createPassword($IdProf,$length)
    {
        $password = Str::random($length);

        $hashedPassword = Hash::make($password);

        DB::table('Enseignants')->where('IdProf', $IdProf)->update(['MdpProf' => $hashedPassword]);

        return $password;

    }
};