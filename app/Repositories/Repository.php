<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;

class Repository {
    function createDatabase(): void {
        DB::unprepared(file_get_contents('database/build.sql'));
    }
    public function insertTeacher($username)
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
    
    private function createPassword($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charsLength = strlen($chars);
        $password = '';
    
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, $charsLength - 1)];
        }
    
        return $password;
    }
};