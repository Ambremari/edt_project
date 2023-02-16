<?php

namespace App\Repositories;


class Data
{
    function teachers()
    {
        return [
            ['IdProf' => 'PRF001', 
            'NomProf' => 'Paris', 
            'PrenomProf' => 'Jean', 
            'MailProf' => 'jean.dupont@college-vh.com',
            'MdpProf' => null,
            'VolHProf' => 35.0],
        ];
    }
}