<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\Repository;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        $repository = new Repository();
        $repository->createDatabase();
        $repository->insertDirector([
                                'IdDir' => 'DIR001', 
                                'NomDir' => 'Principal', 
                                'PrenomDir' => 'Adjoint', 
                                'MailDir' => 'admin@college-vh.com',
                                'MdpDir' => 'mdpadmin001']);

    }
}
