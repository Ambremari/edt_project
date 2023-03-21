<?php

namespace App\Repositories;

use DateInterval;
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
        $studentData = new StudentData();
        $directors = $data->directors();
        $teachers = $data->teachers();
        $subjects = $data->subjects();
        $divisions = $data->divisions();
        $types = $data->types();
        $classrooms = $data->classrooms();
        $students = $studentData->students();
        $schedule = $data->schedule();
        $this->generateSchedule($schedule[0], $schedule[1], $schedule[2], $schedule[3], $schedule[4]);
        foreach($teachers as $row)
            $this->insertTeacher($row);
        foreach($directors as $row)
            $this->insertDirector($row);
        foreach($subjects as $row)
            $this->insertSubject($row);
        foreach($divisions as $row)
            $this->insertDivision($row);
        foreach($types as $row)
            $this->insertType($row);
        foreach($classrooms as $row)
            $this->insertClassroom($row);
        foreach($students as $row)
            $this->insertStudent($row);
        $this->addRandomDivision();
        $this->setOptionIncompatibility();
        $this->generateScheduleIncompatibility();
        $this->generateSubjectConstraints();
        $this->addRandomLV1();
        $this->addRandomLV2();
        $this->addRandomOption();
        $this->generateGroups();
        $this->assignAllSubjectTeacher();
        $this->generateAllTPGroups();
        $this->generateClassroomsConstraints();
        $this->setTeachersHVolume();
        $this->generateUnit();
    }

    ##########TEACHERS#############

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
        $teacher = DB::table('Enseignants as E')
                    ->join('VolumeHProf as V', 'E.IdProf', '=', 'V.IdProf')
                    ->where('E.IdProf', $id)
                    ->get(['E.IdProf', 'NomProf', 'PrenomProf', 'MailProf', 'VolHProf', 'VolHReelProf'])
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

    function removeTeacherConstraints(string $idProf): void {
        DB::table("ContraintesProf")
            ->where('IdProf', $idProf)
            ->delete();
    }

    function addTeacherConstraints(string $idProf, array $first, array $second): void{
        $this->removeTeacherConstraints($idProf);
        foreach($first as $time){
            DB::table("ContraintesProf")
                ->insert([
                    'IdProf' => $idProf,
                    'Horaire' => $time,
                    'Prio' => 1
                ]);
        }
        foreach($second as $time){
            DB::table("ContraintesProf")
                ->insert([
                    'IdProf' => $idProf,
                    'Horaire' => $time,
                    'Prio' => 2
                ]);
        }
    }

    function getTeacherConstraints(string $idProf, int $prio) : array{
        return DB::table("ContraintesProf")
                    ->where('IdProf', $idProf)
                    ->where('Prio', $prio)
                    ->get()
                    ->toArray();
    }

    function teachersLackVolume() : array{
        return DB::table('Enseignants as E')
                    ->join('VolumeHProf as V', 'E.IdProf', '=', 'V.IdProf')
                    ->whereColumn('VolHProf', '>', 'VolHReelProf')
                    ->get(['E.IdProf', 'NomProf', 'PrenomProf'])
                    ->toArray();
    }

    function teachersNoSubject() : array{
        $teachers = DB::table("Enseigne")
                    ->get('IdProf')
                    ->toArray();
        return DB::table("Enseignants")
                    ->whereNotIn('IdProf', $teachers)
                    ->get('IdProf')
                    ->toArray();
    }

    function setTeachersHVolume() : void{
        $teachers = DB::table("VolumeHProf")
                    ->get()
                    ->toArray();
        foreach($teachers as $teacher){
            DB::table("Enseignants")
                ->where('IdProf', $teacher['IdProf'])
                ->update(['VolHProf' => $teacher['VolHReelProf']]);
        }
    }

    function assignAllSubjectTeacher(): void{
        $this->assignSubjectTeacher("Arts Plastiques", 1);
        $this->assignSubjectTeacher("Éducation musicale", 1);
        $this->assignSubjectTeacher("Physique-chimie", 1);
        $this->assignSubjectTeacher("SVT", 1);
        $this->assignSubjectTeacher("Technologie", 1);
        $this->assignSubjectTeacher("SVT-physique-chimie", 1);
        $this->assignSubjectTeacher("Éducation physique et sportive", 2);
        $this->assignSubjectTeacher("Histoire-géographie", 2);
        $this->assignSubjectTeacher("Français", 3);
        $this->assignSubjectTeacher("Mathématiques", 3);
        $this->assignOptionTeacher('%Anglais LV1', 1);
        $this->assignOptionTeacher('%Anglais LV2', 1);
        $this->assignOptionTeacher('%Allemand LV1', 1);
        $this->assignOptionTeacher('%Allemand LV2', 1);
        $this->assignOptionTeacher('%Espagnol LV1', 1);
        $this->assignOptionTeacher('%Espagnol LV2', 1);
        $this->assignOptionTeacherFromSubject('%Latin', 'Français');
        $this->assignOptionTeacherFromSubject('%européennes', 'Anglais%');
        $this->assignOptionTeacherFromSubject('%régionales', 'Espagnol%');
    }

    function assignSubjectTeacher(string $lib, int $nbTeachers): void{
        $subjects = $this->getSubjectsByLib($lib);
        for($i = 1 ; $i <= $nbTeachers ; $i++){
            $teachers = $this->teachersNoSubject();
            $level = 0;
            $teacher = $teachers[rand(0, count($teachers) - 1)];
            foreach($subjects as $subject){
                DB::table("Enseigne")
                    ->insert(['IdEns' => $subject['IdEns'],
                            'IdProf' => $teacher['IdProf']]);
                $divisions = DB::table("Divisions")
                                ->where('NiveauDiv', $subject['NiveauEns'])
                                ->get()
                                ->toArray();
                $level++;
                for($j = 0 ; $j < count($divisions) ; $j++){
                    if($nbTeachers == 1 || ($j % $nbTeachers == $nbTeachers - $i && $level <= 2) || 
                    ($j % $nbTeachers != $nbTeachers - $i && ($nbTeachers <= 2 || $j % $nbTeachers != ($nbTeachers - $i + 1) % $nbTeachers) && $level > 2)){
                        $id = "CR".substr($subject['IdEns'], 4, 2).substr($teacher['IdProf'], 4, 2).substr($divisions[$j]['IdDiv'], 3, 3);
                        DB::table("Cours")
                            ->insert(['IdCours' => $id,
                                    'IdEns' => $subject['IdEns'],
                                    'IdProf' => $teacher['IdProf'],
                                    'IdDiv' => $divisions[$j]['IdDiv']]);
                    }
                }
            }
            
        }
    }

    function assignOptionTeacher(string $option, int $nbTeachers): void{
        $subjects = $this->getSubjectsByLib($option);
        for($i = 1 ; $i <= $nbTeachers ; $i++){
            $teachers = $this->teachersNoSubject();
            $teacher = $teachers[rand(0, count($teachers) - 1)];
            foreach($subjects as $subject){
                DB::table("Enseigne")
                    ->insert(['IdEns' => $subject['IdEns'],
                            'IdProf' => $teacher['IdProf']]);
                $groups = DB::table("Groupes")
                                ->where('NiveauGrp', $subject['NiveauEns'])
                                ->where('LibelleGrp', 'like', $option)
                                ->get()
                                ->toArray();
                for($j = 0 ; $j < count($groups) ; $j++){
                    if($j % $nbTeachers == $nbTeachers - $i){
                        $id = "CR".substr($subject['IdEns'], 4, 2).substr($teacher['IdProf'], 4, 2).substr($groups[$j]['IdGrp'], 3, 4);
                        DB::table("Cours")
                            ->insert(['IdCours' => $id,
                                    'IdEns' => $subject['IdEns'],
                                    'IdProf' => $teacher['IdProf'],
                                    'IdGrp' => $groups[$j]['IdGrp']]);
                    }
                }
            }
        }
    }

    function assignOptionTeacherFromSubject(string $optionLib, string $subjectLib): void{
        $options = $this->getSubjectsByLib($optionLib);
        $subjects = $this->getSubjectsIdByLib($subjectLib);
        $teachers = DB::table('Enseigne')
                        ->whereIn('IdEns', $subjects)
                        ->get('IdProf')
                        ->toArray();
        $minVol = DB::table("VolumeHIntermedProf")
                        ->whereIn('IdProf', $teachers)
                        ->min('VolHCalcProf');
        $teacher = DB::table("VolumeHIntermedProf")
                        ->whereIn('IdProf', $teachers)
                        ->where('VolHCalcProf', $minVol)
                        ->get()
                        ->toArray();
        $teacher = $teacher[0];
        foreach($options as $option){
            DB::table("Enseigne")
                ->insert(['IdEns' => $option['IdEns'],
                        'IdProf' => $teacher['IdProf']]);
            $groups = DB::table("Groupes")
                            ->where('NiveauGrp', $option['NiveauEns'])
                            ->where('LibelleGrp', 'like', $optionLib)
                            ->get()
                            ->toArray();
            for($j = 0 ; $j < count($groups) ; $j++){
                $id = "CR".substr($option['IdEns'], 4, 2).substr($teacher['IdProf'], 4, 2).substr($groups[$j]['IdGrp'], 4, 3);
                DB::table("Cours")
                    ->insert(['IdCours' => $id,
                            'IdEns' => $option['IdEns'],
                            'IdProf' => $teacher['IdProf'],
                            'IdGrp' => $groups[$j]['IdGrp']]);
            }
        }
    }



    ###############STUDENTS################

    function insertStudent(array $student): void {
        if(!array_key_exists('IdEleve', $student)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $student['IdEleve'] = "ELV".$id;
        }
        if(array_key_exists('MdpEleve', $student)){
            $passwordHash = Hash::make($student['MdpEleve']);
            $student['MdpEleve'] = $passwordHash;
        }
        DB::table('Eleves')
            ->insert($student);
    }

    function students() : array{
        return DB::table('Eleves')
                    ->orderBy('NomEleve')
                    ->orderBy('PrenomEleve')
                    ->get()
                    ->toArray();
    }

    function studentsNoDivision() : array{
        return DB::table('Eleves')
                    ->where('IdDiv', null)
                    ->orderBy('NomEleve')
                    ->orderBy('PrenomEleve')
                    ->get()
                    ->toArray();
    }

    function addRandomDivision(): void{
        $students = $this->studentsNoDivision();
        foreach($students as $student){
            $divisions = DB::table("Divisions")
                            ->where('NiveauDiv', $student['NiveauEleve'])
                            ->get()
                            ->toArray();
            do{
                $random = rand(0, count($divisions) - 1);
                $count = DB::table("DivisionCount")
                        ->where('IdDiv', $divisions[$random]['IdDiv'])
                        ->get()
                        ->toArray();
            } while($count[0]['EffectifReelDiv'] >= 35);
            DB::table("Eleves")
                ->where('IdEleve', $student['IdEleve'])
                ->update(['IdDiv' => $divisions[$random]['IdDiv']]);
        }
    }

    function studentsNoLV1() : array{
        $students = DB::table("Options as O")
                        ->join("Enseignements as E", "O.IdEns", "=", "E.IdEns")
                        ->where('LibelleEns', 'like', '%LV1%')
                        ->get('IdEleve')
                        ->toArray();
        return DB::table('Eleves')
                    ->whereNotIn('IdEleve', $students)
                    ->orderBy('NomEleve')
                    ->orderBy('PrenomEleve')
                    ->get()
                    ->toArray();
    }

    function studentsNoLV1Group() : array{
        $students = DB::table("GroupeLV1")
                        ->get("IdEleve")
                        ->toArray();
        return DB::table('Eleves')
                    ->whereNotIn('IdEleve', $students)
                    ->orderBy('NomEleve')
                    ->orderBy('PrenomEleve')
                    ->get()
                    ->toArray();
    }

    function addRandomLV1(): void{
        $students = $this->studentsNoLV1();
        foreach($students as $student){
            $options = DB::table("EnsOption")
                            ->where('NiveauEns', $student['NiveauEleve'])
                            ->where('LibelleEns', 'like', '%LV1%')
                            ->get()
                            ->toArray();
            $random = rand(0, count($options) - 1);
            DB::table("Options")
                ->insert(['IdEleve' => $student['IdEleve'],
                        'IdEns' => $options[$random]['IdEns']]);
        }
    }

    function studentsNoLV2() : array{
        $students = DB::table("Options as O")
                        ->join("Enseignements as E", "O.IdEns", "=", "E.IdEns")
                        ->where('LibelleEns', 'like', '%LV2%')
                        ->get('IdEleve')
                        ->toArray();
        return DB::table('Eleves')
                    ->where("NiveauEleve", "!=", "6EME")
                    ->whereNotIn('IdEleve', $students)
                    ->orderBy('NomEleve')
                    ->orderBy('PrenomEleve')
                    ->get()
                    ->toArray();
    }

    function studentsNoLV2Group() : array{
        $students = DB::table("GroupeLV2")
                        ->get("IdEleve")
                        ->toArray();
        return DB::table('Eleves')
                    ->where("NiveauEleve", "!=", "6EME")
                    ->whereNotIn('IdEleve', $students)
                    ->orderBy('NomEleve')
                    ->orderBy('PrenomEleve')
                    ->get()
                    ->toArray();
    }

    function addRandomLV2(): void{
        $incomp = $this->incompatibilities();
        $students = $this->studentsNoLV2();
        foreach($students as $student){
            $options = DB::table("EnsOption")
                            ->where('NiveauEns', $student['NiveauEleve'])
                            ->where('LibelleEns', 'like', '%LV2%')
                            ->get()
                            ->toArray();
            $lv1 = $this->getStudentLV1($student['IdEleve']);            
            do{
                $random = rand(0, count($options) - 1);
            } while(in_array(["IdEns1" => $lv1['IdEns'], "IdEns2" => $options[$random]['IdEns']], $incomp));
            DB::table("Options")
                ->insert(['IdEleve' => $student['IdEleve'],
                        'IdEns' => $options[$random]['IdEns']]);
        }
    }

    function getStudentLV1(string $id): array{
        $lv1 = DB::table("Options as O")
                        ->join("Enseignements as E", "O.IdEns", "=", "E.IdEns")
                        ->where("IdEleve", $id)
                        ->where("LibelleEns", "like", "%LV1%")
                        ->get("O.IdEns")
                        ->toArray();  
        return $lv1[0];
    }

    function addRandomOption(): void{
        $options = DB::table("EnsOption")
                    ->where('LibelleEns', 'not like', '%LV2%')
                    ->where('LibelleEns', 'not like', '%LV1%')
                    ->get()
                    ->toArray();
        foreach($options as $option){
            $students = DB::table("Eleves")
                            ->where("NiveauEleve", $option["NiveauEns"])
                            ->get()
                            ->toArray();
            $randomStudents = [];
            for($i = 0 ; $i < 29 ; $i++){
                do{
                    $random = rand(0, count($students) - 1);
                } while(in_array($students[$random], $randomStudents));
                $randomStudents[$i] = $students[$random];
            }
            foreach($randomStudents as $student){       
                DB::table("Options")
                    ->insert(['IdEleve' => $student['IdEleve'],
                            'IdEns' => $option['IdEns']]);                           
            }
        }
    }

    function getStudent(string $id) : array{
        $student = DB::table('Eleves as E')
                    ->leftJoin('Divisions as D', 'E.IdDiv', '=', 'D.IdDiv')
                    ->where('E.IdEleve', $id)
                    ->get(['E.*', 'LibelleDiv'])
                    ->toArray();
        if(empty($student))
            throw new Exception('Elève inconnu');
        return $student[0];
    }

    function createPasswordStudent(string $id, string $password): void{
        $users = DB::table('Eleves')
                ->where('IdEleve', $id)
                ->where('MdpEleve', null)
                ->get()
                ->toArray();
        if(empty($users))
            throw new Exception('Utilisateur inconnu');
        $user = $users[0];
        $hashedPassword = Hash::make($password);
        DB::table('Eleves')
            ->where('IdEleve', $id)
            ->update(['MdpEleve' => $hashedPassword]);
    }

    function getUserStudent(string $id, string $password): array{
        $users = DB::table('Eleves')
                ->where('IdEleve', $id)
                ->get()
                ->toArray();
        if(empty($users))
            throw new Exception('Utilisateur inconnu');
        $user = $users[0];
        if(!Hash::check($password, $user['MdpEleve']))
            throw new Exception('Utilisateur inconnu');
        return [
            'id' => $user['IdEleve'],
            'name'=> $user['NomEleve'],
            'firstname'=> $user['PrenomEleve'],
            'role'=> 'eleve'];
    }

    function updateStudent(array $student): void{
        $users = DB::table('Eleves')
                ->where('IdEleve', $student['IdEleve'])
                ->get()
                ->toArray();
        if(empty($users))
            throw new Exception('Utilisateur inconnu');
        DB::table('Eleves')
            ->where('IdEleve', $student['IdEleve'])
            ->update($student);
    }

    ##################DIRECTORS#################

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

    #########SUBJECTS#############

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
                    ->orderBy('LibelleEns')
                    ->orderBy('NiveauEns')
                    ->get()
                    ->toArray();
    }

    function subjectsLib() : array{
        return DB::table('Enseignements')
                    ->select(DB::raw('UNIQUE LibelleEns'))
                    ->orderBy('LibelleEns')
                    ->get()
                    ->toArray();
    }

    function optionalSubjects() : array{
        return DB::table('EnsOption')
                    ->orderBy('LibelleEns')
                    ->orderBy('NiveauEns')
                    ->get()
                    ->toArray();
    }

    function subjectsNoTeacher() : array{
        $subjects = DB::table("Enseigne")
                        ->get("IdEns")
                        ->toArray();
        return DB::table('Enseignements')
                    ->whereNotIn('IdEns', $subjects)
                    ->orderBy('LibelleEns')
                    ->orderBy('NiveauEns')
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

    function getSubjectTeachers(string $id) : array{
        $teachers = DB::table('Enseigne')
                    ->where('IdEns', $id)
                    ->get('IdProf')
                    ->toArray();
        return DB::table("Enseignants")
                    ->whereIn('IdProf', $teachers)
                    ->get()
                    ->toArray();
    }

    function getSubjectsByLib(string $lib) : array{
        return DB::table('Enseignements')
                    ->where('LibelleEns', "like", $lib)
                    ->get()
                    ->toArray();
    }

    function getSubjectsIdByLib(string $lib) : array{
        return DB::table('Enseignements')
                    ->where('LibelleEns', "like", $lib)
                    ->get('IdEns')
                    ->toArray();
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

    function options(): array{
        return DB::table('Options')
            ->get()
            ->toArray();
    }

    function getStudentOptions(string $id) : array{
        return DB::table('Options')
                    ->where('IdEleve', $id)
                    ->get()
                    ->toArray();
    }

    function incompatibilities(): array{
        return DB::table("IncompatibilitesChoix")
                    ->get()
                    ->toArray();
    }
    function insertIncompatibility(string $id1, string $id2) : void{
        $incomp = $this->incompatibilities();
        if(!in_array(["IdEns1" => $id1, "IdEns2" => $id2], $incomp))
            DB::table("IncompatibilitesChoix")
                ->insert(["IdEns1" => $id1,
                        "IdEns2" => $id2]);
    }

    function setOptionIncompatibility(): void{
        $options = $this->options();
        $couples = DB::table("EnsOption as E1")
                    ->join("EnsOption as E2", "E1.NiveauEns", "=", "E2.NiveauEns")
                    ->where("E1.LibelleEns", "like", "%LV1%")
                    ->where("E2.LibelleEns", "like", "%LV1%")
                    ->get(["E1.IdEns as IdEns1", "E2.IdEns as IdEns2"])
                    ->toArray();
        foreach($couples as $couple)
            $this->insertIncompatibility($couple['IdEns1'], $couple['IdEns2']);
        $couples = DB::table("EnsOption as E1")
                    ->join("EnsOption as E2", "E1.NiveauEns", "=", "E2.NiveauEns")
                    ->where("E1.LibelleEns", "like", "%LV2%")
                    ->where("E2.LibelleEns", "like", "%LV2%")
                    ->get(["E1.IdEns as IdEns1", "E2.IdEns as IdEns2"])
                    ->toArray();
        foreach($couples as $couple)
            $this->insertIncompatibility($couple['IdEns1'], $couple['IdEns2']);
        $couples = DB::table("EnsOption as E1")
                    ->join("EnsOption as E2", "E1.NiveauEns", "=", "E2.NiveauEns")
                    ->where("E1.LibelleEns", "like", "%Anglais%")
                    ->where("E2.LibelleEns", "like", "%Anglais%")
                    ->get(["E1.IdEns as IdEns1", "E2.IdEns as IdEns2"])
                    ->toArray();
        foreach($couples as $couple)
            $this->insertIncompatibility($couple['IdEns1'], $couple['IdEns2']);
        $couples = DB::table("EnsOption as E1")
                    ->join("EnsOption as E2", "E1.NiveauEns", "=", "E2.NiveauEns")
                    ->where("E1.LibelleEns", "like", "%Espagnol%")
                    ->where("E2.LibelleEns", "like", "%Espagnol%")
                    ->get(["E1.IdEns as IdEns1", "E2.IdEns as IdEns2"])
                    ->toArray();
        foreach($couples as $couple)
            $this->insertIncompatibility($couple['IdEns1'], $couple['IdEns2']);
            $couples = DB::table("EnsOption as E1")
                    ->join("EnsOption as E2", "E1.NiveauEns", "=", "E2.NiveauEns")
                    ->where("E1.LibelleEns", "like", "%Allemand%")
                    ->where("E2.LibelleEns", "like", "%Allemand%")
                    ->get(["E1.IdEns as IdEns1", "E2.IdEns as IdEns2"])
                    ->toArray();
        foreach($couples as $couple)
            $this->insertIncompatibility($couple['IdEns1'], $couple['IdEns2']);
    }

    

    function getOptionStudents(string $id) : array{
        return DB::table('Options')
                    ->where('IdEns', $id)
                    ->get()
                    ->toArray();
    }


    function getStudentOptionsLib(string $id) : array{
        return DB::table('Options as O')
                    ->join('Enseignements as E', 'O.IdEns', '=', 'E.IdEns')
                    ->where('IdEleve', $id)
                    ->get(['O.*', 'E.LibelleEns'])
                    ->toArray();
    }

    function removeStudentOption(string $idEleve) : void{
            DB::table('Options')
                ->where('IdEleve', $idEleve)
                ->delete();
    }

    function addStudentOption(string $idEleve, array $options) : void{
        $this->removeStudentOption($idEleve);
        foreach($options as $idEns){
            DB::table('Options')
                ->insert(['IdEleve' => $idEleve,
                         'IdEns' => $idEns]);
        }
    }

    function subjectConstraints(): array{
        return DB::table('ContraintesEns')
            ->get()
            ->toArray(); 
    }

    function removeSubjectConstraints(string $id): void{
        DB::table('ContraintesEns')
            ->where('IdEns', $id)
            ->delete(); 
    }

    function removeLevelConstraints(string $level): array {
        $subjects = DB::table("Enseignements")
                        ->where('NiveauEns', $level)
                        ->get('IdEns')
                        ->toArray();
        DB::table('ContraintesEns')
            ->whereIn('IdEns', $subjects)
            ->delete(); 
        return $subjects;
    }

    function addSubjectConstraints(string $id, array $first, array $second): void{
        $this->removeSubjectConstraints($id);
        foreach($first as $time){
            DB::table("ContraintesEns")
                ->insert([
                    'IdEns' => $id,
                    'Horaire' => $time,
                    'Prio' => 1
                ]);
        }
        foreach($second as $time){
            DB::table("ContraintesEns")
                ->insert([
                    'IdEns' => $id,
                    'Horaire' => $time,
                    'Prio' => 2
                ]);
        }
    }

    function addLevelConstraints(string $level, array $first, array $second): void{
        $subjects = $this->removeLevelConstraints($level);
        foreach($first as $time){
            foreach($subjects as $subject){
                DB::table("ContraintesEns")
                    ->insert([
                        'IdEns' => $subject['IdEns'],
                        'Horaire' => $time,
                        'Prio' => 1
                    ]);
            }
        }
        foreach($second as $time){
            foreach($subjects as $subject){
                DB::table("ContraintesEns")
                    ->insert([
                        'IdEns' => $subject['IdEns'],
                        'Horaire' => $time,
                        'Prio' => 2
                    ]);
            }
        }
    }

    function generateSubjectConstraints(): void{
        $saturday = DB::table("Horaires")
                        ->where("Jour", "Samedi")
                        ->get('Horaire')
                        ->toArray();
        $lastHour = DB::table("Horaires")
                        ->where("Horaire", "like", "%ES3")
                        ->get()
                        ->toArray();
        $firstGrade = DB::table("Enseignements")
                        ->where("NiveauEns", "6EME")
                        ->get()
                        ->toArray();
        $notOptions = DB::table("Enseignements")
                        ->where("OptionEns", false)
                        ->get()
                        ->toArray();
        foreach($saturday as $time){
            foreach($firstGrade as $subject){
                DB::table("ContraintesEns")
                    ->insert([
                        'IdEns' => $subject['IdEns'],
                        'Horaire' => $time['Horaire'],
                        'Prio' => 1
                    ]);
            }
        }
        foreach($lastHour as $time){
            foreach($notOptions as $subject){
                DB::table("ContraintesEns")
                    ->insert([
                        'IdEns' => $subject['IdEns'],
                        'Horaire' => $time['Horaire'],
                        'Prio' => 2
                    ]);
            }
        }

    }

    function getSubjectConstraints(string $idEns, int $prio) : array{
        return DB::table("ContraintesEns")
                    ->where('IdEns', $idEns)
                    ->where('Prio', $prio)
                    ->get()
                    ->toArray();
    }
    

    #############DIVISIONS##############

    function insertDivision(array $division): string {
        if(!array_key_exists('IdDiv', $division)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $division['IdDiv'] = "DIV".$id;
        }
        DB::table('Divisions')
            ->insert($division);
        return $division['IdDiv'];
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

    function getDivisionLessonsLib(string $id) : array{
        return DB::table('LibellesCours')
                    ->where('IdDiv', $id)
                    ->where('IdGrp', null)
                    ->get()
                    ->toArray();
    }

    function getDivisionStudents(string $id) : array{
        return DB::table('Eleves')
                    ->where('IdDiv', $id)
                    ->get()
                    ->toArray();
    }

    function addDivisionStudents(string $idDiv, array $students): void{
        foreach($students as $id){
            DB::table('Eleves')
                ->where('IdEleve', $id)
                ->update(['IdDiv' => $idDiv]);
        }
    }

    function addGroupStudents(string $idGrp, array $students): void{
        $divisions = DB::table('LiensGroupes')
                         ->where('IdGrp', $idGrp)
                         ->get(['IdDiv'])
                         ->toArray();
        foreach($students as $id){
            $student = $this->getStudent($id);
            if(!in_array(['IdDiv' => $student['IdDiv']], $divisions))
                throw new Exception('Division incompatible');
            DB::table('CompoGroupes')
                ->insert(['IdGrp' => $idGrp,
                          'IdEleve' => $id]);
        }
    }

    function create2Groups(string $idDiv): void {
        $divisions = DB::table("Divisions")
                        ->where('IdDiv', $idDiv)
                        ->get()
                        ->toArray();
        $division = $divisions[0];
        $id = dechex(time());
        $id = substr($id, 3, 10);
        $groupA = "GRP".$id."A";
        $groupB = "GRP".$id."B";
        DB::table('Groupes')
             ->insert(['IdGrp' => $groupA,
                       'LibelleGrp' => $division['LibelleDiv']." GP A",
                       'NiveauGrp' => $division['NiveauDiv'],
                       'EffectifPrevGrp' => $division['EffectifPrevDiv']/2]
            );
        DB::table('LiensGroupes')
            ->insert(['IdGrp' => $groupA,
                      'IdDiv' => $idDiv]
           );
        DB::table('Groupes')
             ->insert(['IdGrp' => $groupB,
                       'LibelleGrp' => $division['LibelleDiv']." GP B",
                       'NiveauGrp' => $division['NiveauDiv'],
                       'EffectifPrevGrp' => $division['EffectifPrevDiv']/2]
            );
        DB::table('LiensGroupes')
            ->insert(['IdGrp' => $groupB,
                      'IdDiv' => $idDiv]
           );
    }

    function divisionSubjectsCount(): array{
        return DB::table("Divisions as D")
                ->join("CoursDivisions as C", "D.IdDiv", "=", "C.IdDiv")
                ->join("CoursNiveau as N", "D.NiveauDiv", "=", "N.NiveauEns")
                ->whereColumn('NbReel', '<', 'NbCible')
                ->get(['D.*'])
                ->toArray();
    }

    function divisionLackingVolume(): array{
        return DB::table('VolumeDivTot as Vd')
                    ->join('Divisions as Div', 'Vd.IdDiv', '=', 'Div.IdDiv')
                    ->join('VolumeNiveauTot as Vn', 'Div.NiveauDiv', '=', 'Vn.NiveauEns')
                    ->whereColumn('Vd.VolTotSalle', '!=', 'Vn.VolTotEns')
                    ->get(['Div.*', 'VolTotSalle', 'VolTotEns'])
                    ->toArray();
    }

    #############GROUPS##############

    function insertGroup(array $group): string {
        if(!array_key_exists('IdGrp', $group)){
            $id = dechex(time());
            $id = substr($id, 3, 10);
            $group['IdGrp'] = "GRP".$id;
        }
        DB::table('Groupes')
                 ->insert($group);
        return $group['IdGrp'];
    }

    function groups() : array{
        return DB::table('Groupes as G')
                    ->join('GroupCount as C', 'G.IdGrp', '=', 'C.IdGrp')
                    ->join('GroupDivCount as D', 'G.IdGrp', '=', 'D.IdGrp')
                    ->orderBy('NiveauGrp')
                    ->orderBy('LibelleGrp')
                    ->get(['G.*', 'EffectifReelGrp', 'NbDivAssociees'])
                    ->toArray();
    }

    function generateGroups(): void{
        $options = DB::table("OptionCount")
                    ->get()
                    ->toArray();
        foreach($options as $option){
            $nGrp = (int) ($option['Inscrits'] / 30 + 1);
            $divisions = DB::table("Divisions")
                            ->where("NiveauDiv", $option["NiveauEns"])
                            ->orderBy("LibelleDiv")
                            ->get()
                            ->toArray();
            $nDiv = count($divisions)/$nGrp; 
            $firstDiv = 0;
            for($i = 1 ; $i <= $nGrp ; $i++){
                $group = ["IdGrp" =>  "GRP".substr($option["IdEns"], 3, 10).$i,
                        "LibelleGrp" => "Grp".$i." ".$option["LibelleEns"],
                        "NiveauGrp" => $option["NiveauEns"],
                        "EffectifPrevGrp" => 35];
                $this->insertGroup($group);
                for($j = 0 ; $j < $nDiv ; $j++){
                    DB::table("LiensGroupes")
                        ->insert(['IdDiv' => $divisions[$firstDiv + $j]['IdDiv'],
                                  'IdGrp' => $group['IdGrp']]);
                }
                $firstDiv = $nDiv * $i;
            }
            
        } 
    }

    function generateTPGroups(string $subject): void{
        $subjects = $this->getSubjectsIdByLib($subject);
        $classes = DB::table("Cours")
                        ->whereIn('IdEns', $subjects)
                        ->get()
                        ->toArray();
        foreach($classes as $class){
            $division = $this->getDivision($class['IdDiv']);
            $students = DB::table("Eleves")
                            ->where('IdDiv', $class['IdDiv'])
                            ->get('IdEleve')
                            ->toArray();
            $firstStudent = 0;
            for($i = 1 ; $i <= 2 ; $i++){
                $group = ["IdGrp" =>  "GRP".substr($division["IdDiv"], 3, 3)."P".substr($subject, 0, 2).$i,
                        "LibelleGrp" => "Grp TP".$i." ".$subject." ".$division["LibelleDiv"],
                        "NiveauGrp" => $division["NiveauDiv"],
                        "EffectifPrevGrp" => $division["EffectifPrevDiv"]/2];
                $this->insertGroup($group);
                DB::table("LiensGroupes")
                    ->insert(['IdDiv' => $class['IdDiv'],
                              'IdGrp' => $group['IdGrp']]);
                $id = "CR".substr($class['IdCours'], 3, 6)."G".$i;
                DB::table("Cours")
                    ->insert(['IdCours' => $id,
                            'IdEns' => $class['IdEns'],
                            'IdProf' => $class['IdProf'],
                            'IdDiv' => $class['IdDiv'],
                            'IdGrp' => $group['IdGrp']]);
                for($j = 0 ; $j < count($students)/2 ; $j++){
                    if(array_key_exists($firstStudent + $j, $students))
                        DB::table("CompoGroupes")
                            ->insert(['IdGrp' => $group['IdGrp'],
                                      'IdEleve' => $students[$firstStudent + $j]['IdEleve']]);
                }
                $firstStudent = ceil(count($students)/2);
            }  
        } 
    }

    function generateAllTPGroups(): void{
        $this->generateTPGroups("Physique-chimie");
        $this->generateTPGroups("SVT");
        $this->generateTPGroups("SVT-physique-chimie");
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

    function getGroupLessonsLib(string $id) : array{
        return DB::table('LibellesCours')
                    ->where('IdGrp', $id)
                    ->get()
                    ->toArray();
    }

    function getGroupStudents(string $id) : array{
        return DB::table('CompoGroupes as C')
                    ->join('Eleves as E', "C.IdEleve", "=", "E.IdEleve")
                    ->where('IdGrp', $id)
                    ->get(["C.*", "NomEleve", "PrenomEleve"])
                    ->toArray();
    }

    function groupLinks(): array{
        return DB::table('LiensGroupes')
            ->get()
            ->toArray();
    }

    function removeGroupDivision(string $idGrp): void{
        DB::table('LiensGroupes')
            ->where('IdGrp', $idGrp)
            ->delete();
    }

    function linkGroupDivision(string $idGrp, array $divisions): void{
        $this->removeGroupDivision($idGrp);
        foreach($divisions as $idDiv){
            DB::table('LiensGroupes')
                ->insert(['IdGrp' => $idGrp,
                        'IdDiv' => $idDiv]);
        }
    }

    function getGroupDivisions(string $id) : array{
        return DB::table('LibellesDiv')
                    ->where('IdGrp', $id)
                    ->get()
                    ->toArray();
    }

    function getStudentGroup(string $id) : array{
        return DB::table('CompoGroupes as C')
                    ->join('Groupes as G', 'C.IdGrp', '=', 'G.IdGrp')
                    ->where('C.IdEleve', $id)
                    ->get()
                    ->toArray();
    }

    function removeStudentGroup(string $idStud, string $idGrp) : void{
        DB::table('CompoGroupes')
                ->where('IdEleve', $idStud)
                ->where('IdGrp', $idGrp)
                ->delete();
    }

    ###########LINK-TEACHER-SUBJECT-CLASS################


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

    ##################LESSONS#####################


    function lessons() : array{
        return DB::table('Cours')
                    ->get(['IdProf', 'IdEns', 'IdDiv', 'IdGrp'])
                    ->toArray();
    }

    function getLessonsLib() : array{
        return DB::table('LibellesCours')
                    ->get()
                    ->toArray();
    }

    function getTeacherLessonsLib(string $id) : array{
        return DB::table('LibellesCours')
                    ->where('IdProf', $id)
                    ->get()
                    ->toArray();
    }

    function getTeacherLessons(string $id) : array{
        return DB::table('Cours')
                    ->where('IdProf', $id)
                    ->get(['IdEns', 'IdDiv', 'IdGrp'])
                    ->toArray();
    }

    function getTeacherLessonsGroup(string $id) : array{
        return DB::table('Cours')
                    ->where('IdProf', $id)
                    ->get(['IdEns', 'IdGrp'])
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

    #############CLASSROOMS###############

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

    function generateClassroomsConstraints(): void{
        $this->addClassroomsConstraintsForSubject("Arts Plastiques", 
                                                  ['6EME', '5EME', '4EME', '3EME'],
                                                  "Arts Plastiques", 1, 1);
        $this->addClassroomsConstraintsForSubject("Éducation musicale", 
                                                  ['6EME', '5EME', '4EME', '3EME'],
                                                  "Musique", 1, 1);
        $this->addClassroomsConstraintsForSubject("Technologie", 
                                                  ['6EME', '5EME', '4EME', '3EME'],
                                                  "Informatique", 1.5, 1);
        $this->addClassroomsConstraintsForSubject("Éducation physique et sportive", 
                                                  ['6EME', '5EME', '4EME', '3EME'],
                                                  "Sport", 2, 2);
        $this->addClassroomsConstraintsForSubject("Éducation physique et sportive", 
                                                  ['6EME'],
                                                  "Sport", 2, 2);
        $this->addClassroomsConstraintsForSubject("Éducation physique et sportive", 
                                                  ['5EME', '4EME', '3EME'],
                                                  "Sport", 1, 1);
        $this->addClassroomsConstraintsForSubject("Physique-chimie", 
                                                  ['5EME', '4EME', '3EME'],
                                                  "TP", 0.5, 1, 1);
        $this->addClassroomsConstraintsForSubject("SVT", 
                                                  ['5EME', '4EME', '3EME'],
                                                  "TP", 0.5, 1, 1);
        $this->addClassroomsConstraintsForSubject("SVT-physique-chimie", 
                                                  ['6EME'],
                                                  "TP", 2, 1, 1);
        $this->generateClassroomsConstraintsForMissingVolume();
    }

    function addClassroomsConstraintsForSubject(string $lib, array $level, string $classroom, float $time, float $volMin, int $group = 0){
        $subjects = DB::table("Enseignements")
                        ->where('LibelleEns', 'like', $lib)
                        ->whereIn('NiveauEns', $level)
                        ->get('IdEns')
                        ->toArray();
        if(!$group)
            $classes = DB::table("Cours")
                            ->whereIn('IdEns', $subjects)
                            ->get()
                            ->toArray();
        else
            $classes = DB::table("Cours")
                            ->whereNotNull('IdGrp')
                            ->whereIn('IdEns', $subjects)
                            ->get()
                            ->toArray();
        $index = DB::table("ContraintesSalles")
                    ->count();
        foreach($classes as $class){
            $index++;
            $id = "CS".substr($class['IdCours'], 2, 5).$index;
            DB::table("ContraintesSalles")
                ->insert(['IdContSalle' => $id,
                          'TypeSalle' => $classroom,
                          'IdCours' => $class['IdCours'],
                          'VolHSalle' => $time,
                          'DureeMinSalle' => $volMin]);
        }
        
    }

    function generateClassroomsConstraintsForMissingVolume(): void{
        $classes = $this->classes();
        $index = 0;
        foreach($classes as $class){
            if($class['IdDiv'] == null || $class['IdGrp'] == null){
                $subject = DB::table("Enseignements")
                            ->where('IdEns', $class['IdEns'])
                            ->get()
                            ->toArray();
                if($class['IdGrp'] == null){
                    $vol = DB::table("VolumeCoursDivSalle")
                                ->where('IdDiv', $class['IdDiv'])
                                ->where('IdEns', $class['IdEns'])
                                ->get()
                                ->toArray();
                } else {
                    $vol = DB::table("VolumeCoursGrpSalle")
                                ->where('IdGrp', $class['IdGrp'])
                                ->where('IdEns', $class['IdEns'])
                                ->get()
                                ->toArray(); 
                }
                if(empty($vol))
                    $vol = [['VolTotSalle' => 0]];
                $missingVol = $subject[0]['VolHEns'] - $vol[0]['VolTotSalle'];
                if($missingVol > 0){
                    $index++;
                    $id = "CS".substr($class['IdCours'], 2, 4)."c".$index;
                    DB::table("ContraintesSalles")
                        ->insert(['IdContSalle' => $id,
                                'TypeSalle' => 'Cours',
                                'IdCours' => $class['IdCours'],
                                'VolHSalle' => $missingVol,
                                'DureeMinSalle' => 1]);
                }
            }
        }
    }

    #######################CLASSES#################
    
    function classes() : array{
        return DB::table('Cours')
                    ->get()
                    ->toArray();
    }

    function classesWithoutConstraints() : array{
        $constraints =  DB::table('ContraintesSalles')
                            ->get('IdCours')
                            ->toArray();
        return DB::table("Cours")
                    ->whereNotIn('IdCours', $constraints)
                    ->get()
                    ->toArray();
    }


    ######################## SCHEDULES ###################


    function insertSchedule(array $schedule): void{
        DB::table('Horaires')
            ->insert($schedule);
    }
     public function schedules() : array{
        return DB::table('Horaires')
                    ->orderBy('Jour')
                    ->orderBy('HeureDebut')
                    ->get()
                    ->toArray();
    }

     public function getSchedules(string $horaire) : array{
        $horaire = DB::table('Horaires')
                    ->where('Horaire', $horaire)
                    ->get()
                    ->toArray();
        if(empty($horaire))
            throw new Exception('Horaire inconnu');
        return $horaire[0];
    }

     public function updateSchedules(array $schedule) : void {
        $schedules = DB::table('horaires')
                        ->where('Horaire', $schedule['Horaire'])
                        ->get()
                        ->toArray();
        if(empty($schedules))
            throw new Exception('Horaire inconnu');
        DB::table('horaires')
            ->where('Horaire', $schedule['Horaire'])
            ->update($schedule);
    }

    public function deleteSchedules(string $horaire): void{
        DB::table('Horaires')
            ->where('Horaire', $horaire)
            ->delete();
    }


##### Constraints classrooms #####
    function constraintsClassrooms() : array{
        return DB::table('ContraintesSalles')
                    ->orderBy('TypeSalle')
                    ->orderBy('IdCours')
                    ->get()
                    ->toArray();
    }
    function getConstraintsClassrooms(array $typeSalle, array $idCours) : array{
        $constraints = DB::table('ContraintesSalles')
                    ->where('TypeSalle', $typeSalle)
                    ->where('IdCours', $idCours)
                    ->get()
                    ->toArray();
        if(empty($constraints))
            throw new Exception('Contraintes inconnues');
        return $constraints[0];
    }

    function addConstraintsClassrooms(array $constraintsClassroom): void{
        $existingConstraints = DB::table('ContraintesSalles')
                                ->where('TypeSalle', $constraintsClassroom['TypeSalle'])
                                ->where('IdCours', $constraintsClassroom['IdCours'])
                                ->get()
                                ->toArray();
        if(!empty($existingConstraints))
            throw new Exception('Les contraintes pour cette salle et cet enseignement existent déjà');
        DB::table('ContraintesSalles')
        ->insert($constraintsClassroom);
    }

    function updateConstraintsClassrooms(array $constraintsClassroom): void{
        $existingConstraints = DB::table('ContraintesSalles')
                                ->where('TypeSalle', $constraintsClassroom['TypeSalle'])
                                ->where('IdCours', $constraintsClassroom['IdCours'])
                                ->get()
                                ->toArray();
        if(empty($existingConstraints))
            throw new Exception('Les contraintes pour cette salle et cet enseignement n\'existent pas');
        DB::table('ContraintesSalles')
            ->where('TypeSalle', $constraintsClassroom['TypeSalle'])
            ->where('IdCours', $constraintsClassroom['IdCours'])
            ->update($constraintsClassroom);
    }


    function getStartTimesMorning(): array{
        return DB::table("HoraireDebutMatin")
                    ->get()
                    ->toArray();
    }

    function getStartTimesAfternoon(): array{
        return DB::table("HoraireDebutAprem")
                    ->get()
                    ->toArray();
    }

    function generateSchedule(array $day, array $break, array $mornings, array $afternoons, int $interval): void{
        DB::table('ContraintesEns')
            ->delete();
        DB::table('ContraintesProf')
            ->delete();
        DB::table('Horaires')
            ->delete();
        $hour = DateInterval::createFromDateString('1 hour');
        $recess = DateInterval::createFromDateString('10 minutes');
        $interval = $interval." minutes";
        $interval = DateInterval::createFromDateString($interval);
        foreach($mornings as $morning){
            $start = date_create_immutable_from_format('H:i:s', $day['start']);
            $startBreak = date_create_immutable_from_format('H:i:s', $break['start']);
            $i = 1;
            do{
                if($i % 3 == 0)
                    $start = $start->add($recess);
                $end = $start->add($hour);
                $newSchedule = [
                    'Horaire' => substr($morning, 0, 2).'M'.$i,
                    'Jour' => $morning,
                    'HeureDebut' => $start,
                    'HeureFin' => $end, 
                ];
                $this->insertSchedule($newSchedule);
                $start = $end->add($interval);
                $i++;
            } while($start->add($hour) <= $startBreak);
        }
        foreach($afternoons as $afternoon){
            $start = date_create_immutable_from_format('H:i:s', $break['end']);
            $endDay = date_create_immutable_from_format('H:i:s', $day['end']);
            $i = 1;
            do{
                if($i % 3 == 0)
                    $start = $start->add($recess);
                $end = $start->add($hour);
                $newSchedule = [
                    'Horaire' => substr($afternoon, 0, 2).'S'.$i,
                    'Jour' => $afternoon,
                    'HeureDebut' => $start,
                    'HeureFin' => $end, 
                ];
                $this->insertSchedule($newSchedule);
                $start = $end->add($interval);
                $i++;
            } while($start->add($hour) <= $endDay);
        }
    }

    function collegeSchedule(): array{
        $startDay = DB::table("Horaires")
                        ->min("HeureDebut");
        $endDay = DB::table("Horaires")
                        ->max("HeureFin");
        $startBreak = DB::table("Horaires")
                        ->where("Horaire", "like", "__M%")
                        ->max("HeureFin");
        $endBreak = DB::table("Horaires")
                        ->where("Horaire", "like", "__S%")
                        ->min("HeureDebut");
        $mornings = DB::table("Horaires")
                        ->select(DB::raw('UNIQUE Jour'))
                        ->where("Horaire", "like", "__M%")
                        ->get()
                        ->toArray();
        $afternoons = DB::table("Horaires")
                        ->select(DB::raw('UNIQUE Jour'))
                        ->where("Horaire", "like", "__S%")
                        ->get()
                        ->toArray();
        $intervalLow = DB::table("Horaires")
                        ->where("Horaire", "like", "__M1")
                        ->min("HeureFin");
        $intervalUp = DB::table("Horaires")
                        ->where("Horaire", "like", "__M2")
                        ->min("HeureDebut");
        $intervalLow = date_create_from_format('H:i:s', $intervalLow);
        $intervalUp = date_create_from_format('H:i:s', $intervalUp);
        $interval = $intervalUp->diff($intervalLow);
        return ['StartDay' => $startDay,
                'EndDay' => $endDay,
                'StartBreak' => $startBreak,
                'EndBreak' => $endBreak,
                'Mornings' => $mornings,
                'Afternoons' => $afternoons,
                'Interval' =>$interval->i];
    }

    function addScheduleIncompatibility(string $subject1, string $subject2): void{
        $exist = DB::table("IncompatibilitesHoraires")
                    ->where("IdEns1", $subject1)
                    ->where("IdEns2", $subject2)
                    ->get()
                    ->toArray();
        if(empty($exist)){
            DB::table("IncompatibilitesHoraires")
                ->insert([
                    'IdEns1' => $subject1,
                    'IdEns2' => $subject2
                ]);
            DB::table("IncompatibilitesHoraires")
                ->insert([
                    'IdEns1' => $subject2,
                    'IdEns2' => $subject1
                ]);
        }
    }

    function deleteScheduleIncompatibility(string $subject1, string $subject2): void{
        DB::table("IncompatibilitesHoraires")
            ->where('IdEns1', $subject1)
            ->where('IdEns2', $subject2)
            ->delete();
        DB::table("IncompatibilitesHoraires")
            ->where('IdEns1', $subject2)
            ->where('IdEns2', $subject1)
            ->delete();
    }

    function scheduleIncompatibilities(): array{
        return DB::table("IncompatibilitesHoraires as I")
                    ->join("Enseignements as E", "I.IdEns1", "=", "E.IdEns")
                    ->join("Enseignements as E2", "I.IdEns2", "=", "E2.IdEns")
                    ->get(['I.*', 
                        'E.LibelleEns as LibelleEns1', 
                        'E.NiveauEns as NiveauEns1', 
                        'E2.LibelleEns as LibelleEns2', 
                        'E2.NiveauEns as NiveauEns2'])
                    ->toArray();
    }

    function generateScheduleIncompatibility(): void {
        $options = $this->optionalSubjects();
        foreach($options as $option){
            $options2 = DB::table("EnsOption")
                          ->where("NiveauEns", $option["NiveauEns"])
                          ->where("IdEns", "!=", $option["IdEns"])
                          ->get()
                          ->toArray();
            foreach($options2 as $option2)
                if(!$this->compatible($option, $option2)){
                    $this->addScheduleIncompatibility($option['IdEns'], $option2['IdEns']);
                }
        }
    }

    function compatible(array $option1, array $option2): bool{
        if(preg_match("/LV1/", $option1['LibelleEns']) && preg_match("/LV1/", $option2['LibelleEns']))
            return true;
        if(preg_match("/LV2/", $option1['LibelleEns']) && preg_match("/LV2/", $option2['LibelleEns']))
            return true;
        if(preg_match("/Anglais/", $option1['LibelleEns']) && preg_match("/Anglais/", $option2['LibelleEns']))
            return true;
        if(preg_match("/Espagnol/", $option1['LibelleEns']) && preg_match("/Espagnol/", $option2['LibelleEns']))
            return true;
        if(preg_match("/Allemand/", $option1['LibelleEns']) && preg_match("/Allemand/", $option2['LibelleEns']))
            return true;
        return false;
    }

    #######PRE-PROCESSING DATA################

    function lastPreprocess(): array {
        $time = DB::table('UpdateTimes')
                    ->where('TABLE_NAME', 'unites')
                    ->get('UPDATE_TIME')
                    ->toArray();
        return $time[0];
    }

    function lastDBUpdate(): string {
        $time = DB::table('UpdateTimes')
                    ->where('TABLE_NAME', 'cours')
                    ->orWhere('TABLE_NAME', 'contraintessalles')
                    ->min('UPDATE_TIME');
        return $time;
    }

    function generateUnit(): void{
        $constraints = $this->constraintsClassrooms();
        $index = 0;
        foreach($constraints as $constraint){
            for($i = 1 ; $i <= $constraint['VolHSalle'] ; $i++){
                DB::table('Unites')
                    ->insert([
                        'Unite' => 'U'.$index,
                        'IdContSalle' => $constraint['IdContSalle']
                    ]);
                $index++;
            }
            if($constraint['VolHSalle'] * 10 % 10 == 5){
                DB::table('Unites')
                    ->insert([
                        'Unite' => 'U'.$index,
                        'IdContSalle' => $constraint['IdContSalle'],
                        'Semaine' => 'A',
                    ]);
                $index++;
            }
        }
    }

    function deleteUnits(): void{
        DB::table('Unites')
            ->delete();
    }

    function getUnitCount(): int{
        return DB::table("Unites")
                    ->count();
    }

    function evaluateAvailability() : int{
        $classrooms = count($this->classrooms());
        $schedules = count($this->schedules());
        return $classrooms*$schedules;
    }
    function preprocess(): void {
        if(!empty($this->subjectsNoTeacher()))
            throw new Exception('Tous les enseignements ne sont pas affectés');
        if(!empty($this->divisionSubjectsCount()))
            throw new Exception('Manque des enseignements pour certaines divisions');
        $this->generateClassroomsConstraintsForMissingVolume();
        if(!empty($this->divisionLackingVolume()))
            throw new Exception('Manque des heures d\'enseignements pour certaines divisions');
        $this->deleteUnits();
        $this->generateUnit();
    }


##### TRIGGER CHECK DIV AND GRP #####
   /* function checkGrpAndDivLevel(string $idGrp): void {
        $group = DB::table('Groupes')
                    ->where('IdGrp', $idGrp)
                    ->first();
        $division = DB::table('Divisions')
                    ->join('LiensGroupes', 'Divisions.IdDiv', '=', 'LiensGroupes.IdDiv')
                    ->where('LiensGroupes.IdGrp', $idGrp)
                    ->first();
    if ($group['NiveauGrp'] !== $division['NiveauDiv']) {
        throw new Exception('Niveau de groupe incompatible avec la division correspondante');
    }
  }

    function checkStudentLevel(string $idEleve): void {
        $eleve = $this->getStudent($idEleve);
        $division = $this->getDivision($eleve['IdDiv']);
        $groupes = DB::table('LiensGroupes')
                    ->where('IdDiv', $eleve['IdDiv'])
                    ->get(['IdGrp'])
                    ->toArray();
        foreach ($groupes as $groupe) {
            $grp = $this->getGroup($groupe->IdGrp);
            if ($eleve['NiveauEleve'] !== $grp['NiveauGrp'] || $eleve['NiveauEleve'] !== $division['NiveauDiv']) {
                throw new Exception('Niveau de l\'élève incompatible avec la division ou le groupe correspondant');
            }
        }
    }
    function checkStudentEligibility(string $idEleve, string $idEns): void {
        $enseignement = DB::table('Enseignements')
                        ->where('IdEns', $idEns)
                        ->first();
        if (empty($enseignement)) {
            throw new Exception('Enseignement inconnu');
        }

        $eleve = DB::table('Eleves')
                ->where('IdEleve', $idEleve)
                ->get();
        if (empty($eleve)) {
            throw new Exception('Elève inconnu');
        }

        if ($eleve->NiveauEleve !== $enseignement->NiveauEns) {
            throw new Exception('Niveau de l\'élève incompatible avec l\'enseignement');
        }

        $optionEns = $enseignement->OptionEns;
        if (!$optionEns) {
            $options = DB::table('Options')
                        ->where('IdEleve', $idEleve)
                        ->where('IdEns', $idEns)
                        ->first();
        if (empty($options)) {
                throw new Exception('Enseignement optionnel non choisi');
            }
        }
    } */

}
