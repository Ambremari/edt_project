<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\Repository;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $repository){
        $this->repository = $repository;
    }

    public function addTeacherForm(){
        return view('teacher_add');
    }

    public function addTeacher(){
        return view('teacher_add');
    }
}
