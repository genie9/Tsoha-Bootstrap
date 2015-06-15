<?php

class Jasenmaksu extends BaseModel {

    public $maksu_id, $vuosi, $maara_lapsi, $maara_aikuinen, $maara_skil, $maara_liity;

    public function construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array("validoi_vuosi", "validoi_maara");
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Jasenmaksu');
        $query->execute();
        $rows = $query->fetchAll();

        foreach ($rows as $row) {
            $jasenmaksut[] = new Jasenmaksu(array(
                'vuosi' => $row['vuosi'],
                'maara_lapsi' => $row['maara_lapsi'],
                'maara_aikuinen' => $row['maara_aikuinen'],
                'maara_skil' => $row['maara_skil'],
                'maara_liity' => $row['maara_liity']
            ));
        }
        return $jasenmaksut;
    }

    public static function save() {
        $query = DB::connection()->prepare('INSERT INTO Jasenmaksu (vuosi, maara_lapsi, maara_aikuinen, maara_skil, maara_liity) 
            VALUES (:vuosi, :maara_lapsi, :maara_aikuinen, :maara_skil, :maara_liity) RETURNING maksu_id');
        $query->execute(array(
            'vuosi' => $this->vuosi,
            'maara_lapsi' => $this->maara_lapsi,
            'maara_aikuinen' => $this->maara_aikuinen,
            'maara_skil' => $this->maara_skil,
            'maara_liity' => $this->maara_liity
        ));

        $row = $query->fetch();
        $this->maksu_id = $row['maksu_id'];

        return $this->maksu_id;
    }

    public function find($year) {
        $query = DB::connection()->prepare('SELECT * FROM Jasenmaksu WHERE vuosi=:vuosi LIMIT 1');
        $query->execute(array('vuosi' => $year));
        $row = $query->fetch();
        if ($row) {
            $maksu = new Jasenmaksu(array(
                'maksu_id' => $row['maksu_id'],
                'vuosi' => $row['vuosi'],
                'maara_lapsi' => $row['maara_lapsi'],
                'maara_aikuinen' => $row['maara_aikuinen'],
                'maara_skil' => $row['maara_skil'],
                'maara_liity' => $row['maara_liity']));
            return $maksu;
        }
        return NULL;
    }

    public function paivita() {
        $year = date('Y');
        $jasenmaksu = $this->find($year);
        $query = DB::connection()->prepare('INSERT INTO Jasen_has_Jasenmaksu (jasen_id, maksu_id) '
                . 'VALUES (:jasen_id, :maksu_id');
        $query->execute(array(
            'jasen_id' => $jasenmaksu->jasen_id,
            'maksu_id' => $jasenmaksu->maksu_id));
    }

    public function tarkista_maksu($param) {
        
    }

    public function validoi_vuosi() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->vuosi, "'Vuosi'");
        $errors[] = $this->year_validator($this->vuosi);
        return $errors;
    }
    
    public function validoi_maara(){
        $errors = array();
        $maksut=array($this->maara_aikuinen, $this->maara_lapsi, $this->maara_liity, $this->maara_skil);
        foreach ($maksut as $maksu) {
            $errors[] = $this->string_notempty_validator($maksu, "'Määrä'");
            if(!preg_match("/^[0-9]{1,3}(,|.)[0-9]{0,2}$/", $maksu)){
                $errors[] = 'Tarkista määrät';
            }
        }
        return $errors;
    }
}
