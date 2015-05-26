<?php

class Jasen extends BaseModel {

    public $id, $nimi, $email, $katuosoite, $posti,
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
                'laji' => $row['rek_aika'],
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
        
        if($row){
            $jasen = new Jasen(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'email' => $row['email'],
                'katuosoite' => $row['katuosoite'],
                'posti' => $row['posti'],
                'puhellin' => $row['puhelin'],
                'syntyma' => $row['syntyma'],
                'huoltaja' => $row['huoltaja'],
                'laji' => $row['rek_aika'],
                'status' => $row['status'],
                'skilstatus' => $row['skilstatus'],
                'seura' => $row['seura']));
            return $jasen;
        }
        return NULL;
    }

}
