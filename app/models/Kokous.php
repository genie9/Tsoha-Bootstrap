<?php

class Kokous extends BaseModel {

    public $kokous_id, $pvm, $aika, $paikka, $tyyppi, $muuta, $hal_id, $jasenet_id;

    public function construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array("validoi_pvm", "validoi_aika", "validoi_tyyppi");
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kokous');
        $query->execute();
        $rows = $query->fetchAll();
        $kokoukset = array();

        foreach ($rows as $row) {
            $kokoukset[] = new Kokous(array(
                'kokous_id' => $row['kokous_id'],
                'pvm' => $row['pvm'],
                'aika' => $row['aika'],
                'paikka' => $row['paikka'],
                'tyyppi' => $row['tyyppi'],
                'muuta' => $row['muuta'],
                'hal_id' => $row['hal_id']));
        }
        return $kokoukset;
    }

    public static function find($kokous_id) {
        $querry = DB::connection()->prepare('SELECT * FROM Kokous WHERE kokous_id = :kokous_id LIMIT 1');
        $querry->execute(array('kokous_id' => $kokous_id));
        $row = $querry->fetch();

        if ($row) {
            $kokous = new Kokous(array(
                'kokous_id' => $row['kokous_id'],
                'pvm' => $row['pvm'],
                'aika' => $row['aika'],
                'paikka' => $row['paikka'],
                'tyyppi' => $row['tyyppi'],
                'muuta' => $row['muuta'],
                'hal_id' => $row['hal_id']));
            return $kokous;
        }
        return NULL;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kokous (pvm, aika, paikka, tyyppi) 
            VALUES (:pvm, :aika, :paikka, :tyyppi) RETURNING kokous_id');
        $query->execute(array(
            'pvm' => $this->pvm,
            'aika' => $this->aika,
            'paikka' => $this->paikka,
            'tyyppi' => $this->tyyppi));

        $row = $query->fetch();
        $this->kokous_id = $row['kokous_id'];

        foreach ($this->jasenet_id as $jasen_id) {
//            $attributes = array($this->kokous_id, $jasen_id);
            $osallistuja = new Osallistuja(array());
            $osallistuja->save($this->kokous_id, $jasen_id);
        }
    }

    public function poista($kokous_id) {
        $kokous = $this->find($kokous_id);
        if ($kokous && count($kokous->jasenet_id) === 0) {
            $query = DB::connection()->prepare('DELETE FROM Kokous WHERE kokous_id = :kokous_id');
            $query->execute(array('kokous_id' => $kokous_id));
        }
        if ($this->find($kokous_id) != NULL) {
            return FALSE;
        }
        return TRUE;
    }

    public function validoi_pvm() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->pvm, "'Päivä'");
        $errors[] = $this->date_validator($this->pvm);
        return $errors;
    }

    public function validoi_aika() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->aika, "'Aika'");
        $errors[] = $this->time_validator($this->aika);
        return $errors;
    }

    public function validoi_tyyppi() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->tyyppi, "'Kokoustyyppi'");
        return $errors;
    }

}
