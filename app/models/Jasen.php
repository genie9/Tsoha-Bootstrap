<?php

class Jasen extends BaseModel {

    public $id, $sala, $nimi, $email, $katuosoite, $posti,
            $puhelin, $syntyma, $huoltaja, $laji, $rek_aika, $status, $skilstatus, $seura;

    public function construct($attributes) {
        parent::construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Jasen');
        $query->execute();
        $rows = $query->fetchAll();
        $jasenet = array();

        foreach ($rows as $row) {
            $jasenet[] = new Jasen(array(
                'id' => $row['id'],
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

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Jasen WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $jasen = new Jasen(array(
                'id' => $row['id'],
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
                'id' => $row['id'],
                'email' => $row['email']));
            return $jasen;
        }
        return NULL;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Jasen (nimi, sala, email, katuosoite, posti,
            puhelin, syntyma, huoltaja, seura, laji) VALUES (:nimi, :sala, :email, :katuosoite, :posti,
            :puhelin, :syntyma, :huoltaja, :seura, :laji) RETURNING id');
        $laji = "{";
        foreach ($this->laji as $key => $value) {
            if ($value == '') {
                continue;
            }
            $laji .= '"'.$value . '",';
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
        Kint::trace();
        Kint::dump($row);
        $this->id = $row['id'];
    }

    /* 'laji' => $this->laji, */

    public static function authenticate($nimi, $sala) {
        $query = DB::connection()->prepare('SELECT * FROM Jasen WHERE nimi = :nimi AND sala = :sala LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'sala' => $sala));
        $row = $query->fetch();

        if ($row) {
            $jasen = new Jasen(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'sala' => $row['sala'],
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

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Jasen WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $jasen = new Jasen(array(
                'id' => $row['id'],
                'nimi' => $row['nimi']));
            return $jasen;
        }
        return NULL;
    }

}
