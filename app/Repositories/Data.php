<?php

namespace App\Repositories;


class Data
{
    function directors(){
        return [
            ['IdDir' => 'DIR001',
            'NomDir' => 'Principal',
            'PrenomDir' => 'Adjoint',
            'MailDir' => 'admin@college-vh.com',
            'MdpDir' => 'mdpadmin001'],
        ];
    }

    function students()
    {
        return [
            [ "IdEleve" => "ELV1002",
                "PrenomEleve" => "Lani",
                "NomEleve" => "Kim",
                "AnneeNaisEleve" => "2009",
                "NiveauEleve" => "4EME"],
            ["IdEleve" => "ELV1006",
                "PrenomEleve" => "Jeanette",
                "NomEleve" => "Miles",
                "AnneeNaisEleve" => "2011",
                "NiveauEleve" => "5EME"],
            ["IdEleve" => "ELV1010",
                "PrenomEleve" => "Alea",
                "NomEleve" => "Reynolds",
                "AnneeNaisEleve" => "2008",
                "NiveauEleve" => "3EME"],
            ["IdEleve" => "ELV1014",
                "PrenomEleve" => "Dane",
                "NomEleve" => "Howe",
                "AnneeNaisEleve" => "2013",
                "NiveauEleve" => "6EME"],
            ["IdEleve" => "ELV1018",
                "PrenomEleve" => "Macey",
                "NomEleve" => "Holden",
                "AnneeNaisEleve" => "2010",
                "NiveauEleve" => "6EME"],
            ["IdEleve" => "ELV1022",
                "PrenomEleve" => "Nora",
                "NomEleve" => "Bean",
                "AnneeNaisEleve" => "2008",
                "NiveauEleve" => "4EME"],
            ["IdEleve" => "ELV1026",
                "PrenomEleve" => "Daniel",
                "NomEleve" => "Bond",
                "AnneeNaisEleve" => "2012",
                "NiveauEleve" => "5EME"],
            ["IdEleve" => "ELV1030",
                "PrenomEleve" => "Michelle",
                "NomEleve" => "Holmes",
                "AnneeNaisEleve" => "2011",
                "NiveauEleve" => "4EME"],
            ["IdEleve" => "ELV1034",
                "PrenomEleve" => "Nevada",
                "NomEleve" => "Harvey",
                "AnneeNaisEleve" => "2010",
                "NiveauEleve" => "4EME"],
            [ "IdEleve" => "ELV1038",
                "PrenomEleve" => "Norman",
                "NomEleve" => "Dyer",
                "AnneeNaisEleve" => "2013",
                "NiveauEleve" => "5EME"]
        ];
    }

    function parents()
    {
        return [
        ];
    }

    function teachers()
    {
        return [
            ['IdProf' => 'PRF001',
            'NomProf' => 'Dupont',
            'PrenomProf' => 'Jean',
            'MailProf' => 'jean.dupont@college-vh.com',
            'VolHProf' => 35.0,
            'MdpProf' => 'mdpjean001'],
            ['IdProf' => 'PRF002',
            'NomProf' => 'Dubois',
            'PrenomProf' => 'Jean-Luc',
            'MailProf' => 'jean-luc.dubois@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF003',
            'NomProf' => 'Mari',
            'PrenomProf' => 'Jean-Louis',
            'MailProf' => 'jean-louis.mari@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF004',
            'NomProf' => 'Nouioua',
            'PrenomProf' => 'Karim',
            'MailProf' => 'karim.nouioua@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF005',
            'NomProf' => 'Novelli',
            'PrenomProf' => 'Noel',
            'MailProf' => 'noel.novelli@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF006',
            'NomProf' => 'Estellon',
            'PrenomProf' => 'Bertrand',
            'MailProf' => 'bertrand.estellon@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF007',
            'NomProf' => 'Lamarche',
            'PrenomProf' => 'Juliette',
            'MailProf' => 'juliette.lamarche@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF008',
            'NomProf' => 'Courtin',
            'PrenomProf' => 'Sophie',
            'MailProf' => 'sophie.courtin@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF009',
            'NomProf' => 'Fournier',
            'PrenomProf' => 'François',
            'MailProf' => 'françois.fournier@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF010',
            'NomProf' => 'Henry',
            'PrenomProf' => 'Pierre',
            'MailProf' => 'pierre.henry@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF011',
            'NomProf' => 'Devoird',
            'PrenomProf' => 'Bertrand',
            'MailProf' => 'bertrand.devoird@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF012',
            'NomProf' => 'Henry',
            'PrenomProf' => 'Paul',
            'MailProf' => 'paul.henry@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF013',
            'NomProf' => 'Saez',
            'PrenomProf' => 'Damien',
            'MailProf' => 'damien.saez@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF014',
            'NomProf' => 'Bachelete',
            'PrenomProf' => 'Manon',
            'MailProf' => 'manon.bachelet@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF015',
            'NomProf' => 'Casting',
            'PrenomProf' => 'Magali',
            'MailProf' => 'magali.casting@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF016',
            'NomProf' => 'Rizza',
            'PrenomProf' => 'Mariz',
            'MailProf' => 'maria.rizza@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF017',
            'NomProf' => 'Manzoni',
            'PrenomProf' => 'Coline',
            'MailProf' => 'coline.manzoni@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF018',
            'NomProf' => 'Vaz',
            'PrenomProf' => 'Alexie',
            'MailProf' => 'alexie.vaz@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF019',
            'NomProf' => 'Diallo',
            'PrenomProf' => 'Moussa',
            'MailProf' => 'moussa.diallo@college-vh.com',
            'VolHProf' => 35.0],
            ['IdProf' => 'PRF020',
            'NomProf' => 'Martin',
            'PrenomProf' => 'Françoise',
            'MailProf' => 'françoise.martin@college-vh.com',
            'VolHProf' => 35.0],
        ];
    }

    function types()
    {
        return [
            ['TypeSalle' => 'Cours'],
            ['TypeSalle' => 'TP'],
            ['TypeSalle' => 'Informatique'],
            ['TypeSalle' => 'Sport']
        ];
    }

    function classrooms()
    {
        return [
            ['IdSalle' => 'SAL001',
            'LibelleSalle' => 'Salle Gaston Vaseur',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL002',
            'LibelleSalle' => 'Salle Marie Curie',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL813',
            'LibelleSalle' => 'Salle Jules Hoffman',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL003',
            'LibelleSalle' => 'Salle Louis Pasteur',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL004',
            'LibelleSalle' => 'Salle Xavier Lepichon',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL005',
            'LibelleSalle' => 'Salle Katia Kraft',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL006',
            'LibelleSalle' => 'Salle Amedeo Avogadro',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL007',
            'LibelleSalle' => 'Salle Charles Coulomb',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL008',
            'LibelleSalle' => 'Salle Léon Foucault',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL009',
            'LibelleSalle' => 'Salle Pierre Fermat',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL010',
            'LibelleSalle' => 'Salle Werner Heisenberg',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL011',
            'LibelleSalle' => 'Salle Alfred Kastler',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL012',
            'LibelleSalle' => 'Salle Frantz Fanon',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL013',
            'LibelleSalle' => 'Salle Archimède',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL014',
            'LibelleSalle' => 'Salle Henry Becquerel',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL015',
            'LibelleSalle' => 'Salle Anders Celsius',
            'CapSalle' => 30,
            'TypeSalle' => 'Cours'],
            ['IdSalle' => 'SAL016',
            'LibelleSalle' => 'Salle Delaire',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL017',
            'LibelleSalle' => 'Salle Jean Fabre',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL018',
            'LibelleSalle' => 'Salle Charles Frankel',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL019',
            'LibelleSalle' => 'Salle Beaumont',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL020',
            'LibelleSalle' => 'Salle Darwin',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL021',
            'LibelleSalle' => 'Salle Menez',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL022',
            'LibelleSalle' => 'Salle Gargani',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL023',
            'LibelleSalle' => 'Salle Beaudoin',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL024',
            'LibelleSalle' => 'Salle Motenat',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL025',
            'LibelleSalle' => 'Salle Gargani',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL026',
            'LibelleSalle' => 'Salle Lagny',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL027',
            'LibelleSalle' => 'Salle Chauvel',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL028',
            'LibelleSalle' => 'Salle Larouzière',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL029',
            'LibelleSalle' => 'Salle Gaudant',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL030',
            'LibelleSalle' => 'Salle Mahrez',
            'CapSalle' => 15,
            'TypeSalle' => 'TP'],
            ['IdSalle' => 'SAL031',
            'LibelleSalle' => 'Salle de Foot',
            'CapSalle' => 40,
            'TypeSalle' => 'Sport'],
            ['IdSalle' => 'SAL032',
            'LibelleSalle' => 'Salle de Volley',
            'CapSalle' => 40,
            'TypeSalle' => 'Sport'],
            ['IdSalle' => 'SAL033',
            'LibelleSalle' => 'Salle de Basket-ball',
            'CapSalle' => 40,
            'TypeSalle' => 'Sport'],
            ['IdSalle' => 'SAL034',
            'LibelleSalle' => 'Salle de Hand-ball',
            'CapSalle' => 40,
            'TypeSalle' => 'Sport'],
            ['IdSalle' => 'SAL035',
            'LibelleSalle' => 'Salle de Tennis',
            'CapSalle' => 40,
            'TypeSalle' => 'Sport'],
            ['IdSalle' => 'SAL036',
            'LibelleSalle' => 'Salle de Musculation',
            'CapSalle' => 40,
            'TypeSalle' => 'Sport'],
            ['IdSalle' => 'SAL037',
            'LibelleSalle' => 'Salle de Fitness',
            'CapSalle' => 40,
            'TypeSalle' => 'Sport'],
        ];
    }
    function subjects()
    {
        return [
            [
            'IdEns' => 'ENS001',
            'LibelleEns' => 'Français',
            'NiveauEns' => '6EME',
            'VolHEns' => 4.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS002',
            'LibelleEns' => 'Français',
            'NiveauEns' => '5EME',
            'VolHEns' => 4.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS003',
            'LibelleEns' => 'Français',
            'NiveauEns' => '4EME',
            'VolHEns' => 4.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS004',
            'LibelleEns' => 'Français',
            'NiveauEns' => '3EME',
            'VolHEns' => 4.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS005',
            'LibelleEns' => 'Mathématiques',
            'NiveauEns' => '6EME',
            'VolHEns' => 4.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS006',
            'LibelleEns' => 'Mathématiques',
            'NiveauEns' => '5EME',
            'VolHEns' => 3.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS007',
            'LibelleEns' => 'Mathématiques',
            'NiveauEns' => '4EME',
            'VolHEns' => 3.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS008',
            'LibelleEns' => 'Mathématiques',
            'NiveauEns' => '3EME',
            'VolHEns' => 3.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS009',
            'LibelleEns' => 'Histoire-géographie',
            'NiveauEns' => '6EME',
            'VolHEns' => 3,
            'OptionEns' => false],
            ['IdEns' => 'ENS010',
            'LibelleEns' => 'Histoire-géographie',
            'NiveauEns' => '5EME',
            'VolHEns' => 3,
            'OptionEns' => false],
            ['IdEns' => 'ENS011',
            'LibelleEns' => 'Histoire-géographie',
            'NiveauEns' => '4EME',
            'VolHEns' => 3,
            'OptionEns' => false],
            ['IdEns' => 'ENS012',
            'LibelleEns' => 'Histoire-géographie',
            'NiveauEns' => '3EME',
            'VolHEns' => 3.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS013',
            'LibelleEns' => 'Anglais LV1',
            'NiveauEns' => '6EME',
            'VolHEns' => 4,
            'OptionEns' => true],
            ['IdEns' => 'ENS014',
            'LibelleEns' => 'Anglais LV1',
            'NiveauEns' => '5EME',
            'VolHEns' => 3,
            'OptionEns' => true],
            ['IdEns' => 'ENS015',
            'LibelleEns' => 'Anglais LV1',
            'NiveauEns' => '4EME',
            'VolHEns' => 3,
            'OptionEns' => true],
            ['IdEns' => 'ENS016',
            'LibelleEns' => 'Anglais LV1',
            'NiveauEns' => '3EME',
            'VolHEns' => 3,
            'OptionEns' => true],
            ['IdEns' => 'ENS017',
            'LibelleEns' => 'Espagnol LV2',
            'NiveauEns' => '6EME',
            'VolHEns' => 2.5,
            'OptionEns' => true],
            ['IdEns' => 'ENS018',
            'LibelleEns' => 'Espagnol LV2',
            'NiveauEns' => '5EME',
            'VolHEns' => 2.5,
            'OptionEns' => true],
            ['IdEns' => 'ENS019',
            'LibelleEns' => 'Espagnol LV2',
            'NiveauEns' => '4EME',
            'VolHEns' => 2.5,
            'OptionEns' => true],
            ['IdEns' => 'ENS020',
            'LibelleEns' => 'Espagnol LV2',
            'NiveauEns' => '3EME',
            'VolHEns' => 2.5,
            'OptionEns' => true],
            ['IdEns' => 'ENS021',
            'LibelleEns' => 'SVT-physique-chimie',
            'NiveauEns' => '6EME',
            'VolHEns' => 4,
            'OptionEns' => false],
            ['IdEns' => 'ENS022',
            'LibelleEns' => 'SVT',
            'NiveauEns' => '5EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS023',
            'LibelleEns' => 'SVT',
            'NiveauEns' => '4EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS024',
            'LibelleEns' => 'SVT',
            'NiveauEns' => '3EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS025',
            'LibelleEns' => 'Physique-chimie',
            'NiveauEns' => '5EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS026',
            'LibelleEns' => 'Physique-chimie',
            'NiveauEns' => '4EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS027',
            'LibelleEns' => 'Physique-chimie',
            'NiveauEns' => '3EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS028',
            'LibelleEns' => 'Technologie',
            'NiveauEns' => '5EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS029',
            'LibelleEns' => 'Technologie',
            'NiveauEns' => '4EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS030',
            'LibelleEns' => 'Technologie',
            'NiveauEns' => '3EME',
            'VolHEns' => 1.5,
            'OptionEns' => false],
            ['IdEns' => 'ENS031',
            'LibelleEns' => 'Éducation physique et sportive',
            'NiveauEns' => '6EME',
            'VolHEns' => 4,
            'OptionEns' => false],
            ['IdEns' => 'ENS032',
            'LibelleEns' => 'Éducation physique et sportive',
            'NiveauEns' => '5EME',
            'VolHEns' => 3,
            'OptionEns' => false],
            ['IdEns' => 'ENS033',
            'LibelleEns' => 'Éducation physique et sportive',
            'NiveauEns' => '4EME',
            'VolHEns' => 3,
            'OptionEns' => false],
            ['IdEns' => 'ENS034',
            'LibelleEns' => 'Éducation physique et sportive',
            'NiveauEns' => '3EME',
            'VolHEns' => 3,
            'OptionEns' => false],
            ['IdEns' => 'ENS035',
            'LibelleEns' => 'Arts plastiques',
            'NiveauEns' => '6EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS036',
            'LibelleEns' => 'Arts plastiques',
            'NiveauEns' => '5EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS037',
            'LibelleEns' => 'Arts plastiques',
            'NiveauEns' => '4EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS038',
            'LibelleEns' => 'Arts plastiques',
            'NiveauEns' => '3EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS039',
            'LibelleEns' => 'Éducation musicale',
            'NiveauEns' => '6EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS040',
            'LibelleEns' => 'Éducation musicale',
            'NiveauEns' => '5EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS041',
            'LibelleEns' => 'Éducation musicale',
            'NiveauEns' => '4EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS042',
            'LibelleEns' => 'Éducation musicale',
            'NiveauEns' => '3EME',
            'VolHEns' => 1,
            'OptionEns' => false],
            ['IdEns' => 'ENS043',
            'LibelleEns' => 'Langues et cultures européennes',
            'NiveauEns' => '5EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS044',
            'LibelleEns' => 'Langues et cultures européennes',
            'NiveauEns' => '4EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS045',
            'LibelleEns' => 'Langues et cultures européennes',
            'NiveauEns' => '3EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS046',
            'LibelleEns' => 'Langues et cultures régionales',
            'NiveauEns' => '6EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS047',
            'LibelleEns' => 'Langues et cultures régionales',
            'NiveauEns' => '5EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS048',
            'LibelleEns' => 'Langues et cultures régionales',
            'NiveauEns' => '4EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS049',
            'LibelleEns' => 'Langues et cultures régionales',
            'NiveauEns' => '3EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS050',
            'LibelleEns' => 'Langues et cultures de l\'antiquité',
            'NiveauEns' => '6EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS051',
            'LibelleEns' => 'Langues et cultures de l\'antiquité',
            'NiveauEns' => '5EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS052',
            'LibelleEns' => 'Langues et cultures de l\'antiquité',
            'NiveauEns' => '4EME',
            'VolHEns' => 1,
            'OptionEns' => true],
            ['IdEns' => 'ENS053',
            'LibelleEns' => 'Langues et cultures de l\'antiquité',
            'NiveauEns' => '3EME',
            'VolHEns' => 1,
            'OptionEns' => true],
        ];
    }
    function divisions()
    {
        return [
            ['IdDiv' => 'DIV001',
            'LibelleDiv' => '6èmeA',
            'NiveauDiv' => '6EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV002',
            'LibelleDiv' => '5èmeA',
            'NiveauDiv' => '5EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV003',
            'LibelleDiv' => '4èmeA',
            'NiveauDiv' => '4EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV004',
            'LibelleDiv' => '3èmeA',
            'NiveauDiv' => '3EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV021',
            'LibelleDiv' => '6èmeB',
            'NiveauDiv' => '6EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV022',
            'LibelleDiv' => '5èmeB',
            'NiveauDiv' => '5EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV023',
            'LibelleDiv' => '4èmeB',
            'NiveauDiv' => '4EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV024',
            'LibelleDiv' => '3èmeB',
            'NiveauDiv' => '3EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV011',
            'LibelleDiv' => '6èmeC',
            'NiveauDiv' => '6EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV012',
            'LibelleDiv' => '5èmeC',
            'NiveauDiv' => '5EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV013',
            'LibelleDiv' => '4èmeC',
            'NiveauDiv' => '4EME',
            'EffectifPrevDiv' => 35],
            ['IdDiv' => 'DIV014',
            'LibelleDiv' => '3èmeC',
            'NiveauDiv' => '3EME',
            'EffectifPrevDiv' => 35],
        ];
    }

    function groups()
    {
        return [
            ['IdGrp' => 'GRP001',
            'LibelleGrp' => 'Grp Latin 6ème',
            'NiveauGrp' => '6EME',
            'EffectifPrevGrp' => 35],
            ['IdGrp' => 'GRP002',
            'LibelleGrp' => 'Grp Latin 5ème',
            'NiveauGrp' => '5EME',
            'EffectifPrevGrp' => 35],
            ['IdGrp' => 'GRP003',
            'LibelleGrp' => 'Grp Latin 4ème',
            'NiveauGrp' => '4EME',
            'EffectifPrevGrp' => 35],
            ['IdGrp' => 'GRP004',
            'LibelleGrp' => 'Grp Latin 3ème',
            'NiveauGrp' => '3EME',
            'EffectifPrevGrp' => 35],
            ['IdGrp' => 'GRP101',
            'LibelleGrp' => 'Grp A Anglais LV1 6ème',
            'NiveauGrp' => '6EME',
            'EffectifPrevGrp' => 35],
            ['IdGrp' => 'GRP102',
            'LibelleGrp' => 'Grp A Anglais LV1 5ème',
            'NiveauGrp' => '5EME',
            'EffectifPrevGrp' => 35],
            ['IdGrp' => 'GRP103',
            'LibelleGrp' => 'Grp A Anglais LV1 4ème',
            'NiveauGrp' => '4EME',
            'EffectifPrevGrp' => 35],
            ['IdGrp' => 'GRP104',
            'LibelleGrp' => 'Grp A Anglais LV1 3ème',
            'NiveauGrp' => '3EME',
            'EffectifPrevGrp' => 35],

        ];
    }
    function scheduels(){
        return [
            ['LUM1','Lundi','08:00:00','08:55:00'],
            ['LUM2','Lundi','08:55:00','09:55:00'],
            ['LUM3','Lundi','09:50:00','10:45:00'],
            ['LUM4','Lundi','09:50:00','10:45:00'],
            ['LUM5','Lundi','10:45:00','10:45:00'],
            ['LUM6','Lundi','11:00:00','12:00:00'],
            ['LUS1','Lundi','13:00:00','14:30:00'],
            ['LUS2','Lundi','14:45:00','16:00:00'],
            ['MAM1','Mardi','08:00:00','08:55:00'],
            ['MAM2','Mardi','08:55:00','09:55:00'],
            ['MAM3','Mardi','09:50:00','10:45:00'],
            ['MAM4','Mardi','09:50:00','10:45:00'],
            ['MAM5','Mardi','10:45:00','10:45:00'],
            ['MAM6','Mardi','11:00:00','12:00:00'],
            ['MAS1','Mardi','13:00:00','14:30:00'],
            ['MAS2','Mardi','14:45:00','16:00:00'],
            ['MEM1','Mercredi','08:00:00','08:55:00'],
            ['MEM2','Mercredi','08:55:00','09:55:00'],
            ['MEM3','Mercredi','09:50:00','10:45:00'],
            ['MEM4','Mercredi','09:50:00','10:45:00'],
            ['MEM5','Mercredi','10:45:00','10:45:00'],
            ['MEM6','Mercredi','11:00:00','12:00:00'],
            ['MES1','Mercredi','13:00:00','14:30:00'],
            ['MES2','Mercredi','14:45:00','16:00:00'],
            ['JEM1','Jeudi','08:00:00','08:55:00'],
            ['JEM2','Jeudi','08:55:00','09:55:00'],
            ['JEM3','Jeudi','09:50:00','10:45:00'],
            ['JEM4','Jeudi','09:50:00','10:45:00'],
            ['JEM5','Jeudi','10:45:00','10:45:00'],
            ['JEM6','Jeudi','11:00:00','12:00:00'],
            ['JES1','Jeudi','13:00:00','14:30:00'],
            ['JES2','Jeudi','14:45:00','16:00:00'],
            ['VEM1','Vendredi','08:00:00','08:55:00'],
            ['VEM2','Vendredi','08:55:00','09:55:00'],
            ['VEM3','Vendredi','09:50:00','10:45:00'],
            ['VEM4','Vendredi','09:50:00','10:45:00'],
            ['VEM5','Vendredi','10:45:00','10:45:00'],
            ['VEM6','Vendredi','11:00:00','12:00:00'],
            ['VES1','Vendredi','13:00:00','14:30:00'],
            ['VES2','Vendredi','14:45:00','16:00:00'],
        ];
    }
}
