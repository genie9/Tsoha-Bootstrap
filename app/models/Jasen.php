<?php

class Jasen extends BaseModel {

    public $jasen_id, $sala, $nimi, $email, $katuosoite, $posti,
            $puhelin, $syntyma, $huoltaja, $laji, $rek_aika, $status, $skilstatus, $seura;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validoi_nimi', 'validoi_sala', 'validoi_email',
            'validoi_syntyma', 'validoi_ika_huoltaja', 'validoi_posti');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Jasen');
        $query->execute();
        $rows = $query->fetchAll();
        $jasenet = array();

        foreach ($rows as $row) {
            $jasenet[] = new Jasen(array(
                'jasen_id' => $row['jasen_id'],
                'nimi' => $row['nimi'],
                'email' => $row['email'],
                'katuosoite' => $row['katuosoite'],
                'posti' => $row['posti'],
                'puhellin' => $row['puhelin'],
                'syntyma' => $row['syntyma'],
                'huoltaja' => $row['huoltaja'],
                'laji' => $row['laji'],
                'rek_aika' => $row['rek_aika'],
                'status' => $row['status'],
                'skilstatus' => $row['skilstatus'],
                'seura' => $row['seura']));
        }
        return $jasenet;
    }

    public static function find($jasen_id) {
        $query = DB::connection()->prepare('SELECT * FROM Jasen WHERE jasen_id = :jasen_id LIMIT 1');
        $query->execute(array('jasen_id' => $jasen_id));
        $row = $query->fetch();

        if ($row) {
            $jasen = new Jasen(array(
                'jasen_id' => $row['jasen_id'],
                'nimi' => $row['nimi'],
                'email' => $row['email'],
                'katuosoite' => $row['katuosoite'],
                'posti' => $row['posti'],
                'puhellin' => $row['puhelin'],
                'syntyma' => $row['syntyma'],
                'huoltaja' => $row['huoltaja'],
                'laji' => $row['laji'],
                'status' => $row['status'],
                'skilstatus' => $row['skilstatus'],
                'seura' => $row['seura']));
            return $jasen;
        }
        return NULL;
    }

    public static function find_by_email($email) {
        $query = DB::connection()->prepare('SELECT * FROM Jasen WHERE email = :email LIMIT 1');
        $query->execute(array('email' => $email));
        $row = $query->fetch();

        if ($row) {
            $jasen = new Jasen(array(
                'jasen_id' => $row['jasen_id'],
                'email' => $row['email']));
            return $jasen;
        }
        return NULL;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Jasen (nimi, sala, email, katuosoite, posti,
            puhelin, syntyma, huoltaja, seura, laji) VALUES (:nimi, :sala, :email, :katuosoite, :posti,
            :puhelin, :syntyma, :huoltaja, :seura, :laji) RETURNING jasen_id');
        $laji = "{";
        foreach ($this->laji as $key => $value) {
            if ($value == '') {
                continue;
            }
            $laji .= '"' . $value . '",';
        }
        $laji = rtrim($laji, ',');
        $laji .= "}";

        $query->execute(array(
            'nimi' => $this->nimi,
            'sala' => $this->sala,
            'email' => $this->email,
            'katuosoite' => $this->katuosoite,
            'posti' => $this->posti,
            'puhelin' => $this->puhelin,
            'syntyma' => $this->syntyma,
            'huoltaja' => $this->huoltaja,
            'seura' => $this->seura,
            'laji' => $laji));
        $row = $query->fetch();
        $this->jasen_id = $row['jasen_id'];

        return $this->jasen_id;
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Jasen '
                . 'SET email=:email, sala=:sala, katuosoite=:katuosoite, '
                . 'posti=:posti, puhelin=:puhelin, laji=:laji, seura=:seura'
                . ' WHERE jasen_id=:jasen_id');
        $laji = "{";
        foreach ($this->laji as $key => $value) {
            if ($value == '') {
                continue;
            }
            $laji .= '"' . $value . '",';
        }
        $laji = rtrim($laji, ',');
        $laji .= "}";

        $query->execute(array(
            'jasen_id' => $this->jasen_id,
            'sala' => $this->sala,
            'email' => $this->email,
            'katuosoite' => $this->katuosoite,
            'posti' => $this->posti,
            'puhelin' => $this->puhelin,
            'laji' => $laji,
            'seura' => $this->seura));

        $row = $query->fetch();

        return $this->jasen_id;
    }

    public static function authenticate($nimi, $sala) {
        $query = DB::connection()->prepare('SELECT * FROM Jasen WHERE nimi = :nimi AND sala = :sala LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'sala' => $sala));
        $row = $query->fetch();

        if ($row) {
            $jasen = new Jasen(array(
                'jasen_id' => $row['jasen_id'],
                'nimi' => $row['nimi'],
                'sala' => $row['sala'],
                'email' => $row['email'],
                'katuosoite' => $row['katuosoite'],
                'posti' => $row['posti'],
                'puhelin' => $row['puhelin'],
                'syntyma' => $row['syntyma'],
                'huoltaja' => $row['huoltaja'],
                'laji' => $row['laji'],
                'status' => $row['status'],
                'skilstatus' => $row['skilstatus'],
                'seura' => $row['seura']));

            return $jasen;
        }
        return NULL;
    }

    public function hyvaksy($jasen_id) {
        $jasen = $this->find($jasen_id);

        if ($jasen && ($jasen->status === 'Kesken' || $jasen->status === 'maksu')) {
            $query = DB::connection()->prepare('UPDATE Jasen SET status=:status WHERE jasen_id=:jasen_id');
            $query->execute(array('jasen_id' => $jasen_id, 'status' => 'true'));

            $jasenmaksu = new Jasenmaksu(array());
            $jasenmaksu->paivita($jasen_id);
            return TRUE;
        }
        return FALSE;
    }

    public function poista($jasen_id) {
        $jasen = $this->find($jasen_id);
        if ($jasen && $jasen->status === 'Kesken') {
            $query = DB::connection()->prepare('DELETE FROM Jasen WHERE jasen_id = :jasen_id');
            $query->execute(array('jasen_id' => $jasen_id));
        }
        if ($this->find($jasen_id) != NULL) {
            return FALSE;
        }
        return TRUE;
    }

    public function validoi_nimi() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->nimi, "'Nimi'");
        $errors[] = $this->string_length_validator($this->nimi, 5, "'Nimi'");
        if (!strpos($this->nimi, ' ')) {
            $errors[] = 'Etu- tai sukunimesi puuttuu';
        }
        return $errors;
    }

    public function validoi_sala() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->sala, "'Salasana'");
        $errors[] = $this->string_length_validator($this->sala, 4, "'Salasana'");
        return $errors;
    }

    public function validoi_email() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->email, "'Sähköposti'");
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Tarkista sähköposti';
        }
        return $errors;
    }

    public function validoi_syntyma() {
        $errors = array();
        $errors[] = $this->string_notempty_validator($this->syntyma, "'Syntymäaika'");
        $errors[] = $this->date_validator($this->syntyma);
        return $errors;
    }

    public function validoi_ika_huoltaja() {
        $errors = array();

        $day = date("d-m-Y");
        $today = new DateTime($day);

        if ($this->date_validator($this->syntyma) == '') {
            $bday = new DateTime($this->syntyma);

            $diff = $today->diff($bday);
            $age = $diff->y;

            if ($age < 18) {
                $errors[] = $this->string_notempty_validator($this->huoltaja, "'Huoltaja'");
                if (!strpos($this->huoltaja, ' ')) {
                    $errors[] = 'Ilmoita huoltajan etu- sekä sukunimi ';
                }
            }
        }
        return $errors;
    }

    public function validoi_posti() {
        $errors = array();
        if ($this->posti && !preg_match("/^\d{5}/", $this->posti)) {
            $errors[] = 'Muistitko syöttää postinumeron';
        }
        return $errors;
    }

    public function validoi_puhelin($string) {
        $errors = "";
        if ($type === 'puhelin' && preg_match("/\D/", $string)) {
            $errors[] = 'Tarkista puhelinnumero';
        }
        return $errors;
    }

}
