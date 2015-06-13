<?php

class Osallistuja extends BaseModel {

    public $kokous_id, $jasen_id, $pvm, $nimi;

    public function construct($attributes) {
        parent::__construct($attributes);
    }

    public function save($kokous_id, $jasen_id) {
        $query = DB::connection()->prepare('INSERT INTO Kokous_has_Jasen (kokous_id, jasen_id)
                VALUES (:kokous_id, :jasen_id)');
        $query->execute(array(
            'kokous_id' => $kokous_id, 
            'jasen_id' => $jasen_id));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT kokous.pvm, jasen.nimi, kokous.kokous_id FROM kokous_has_jasen '
                . 'INNER JOIN jasen ON kokous_has_jasen.jasen_id=jasen.jasen_id '
                . 'INNER JOIN Kokous ON kokous_has_jasen.kokous_id=kokous.kokous_id');
        $query->execute();
        $rows = $query->fetchAll();
        $osallistujat = array();

        foreach ($rows as $row) {
            $osallistujat[] = new Osallistuja(array(
                'kokous_id' => $row['kokous_id'],
                'pvm' => $row['pvm'],
                'nimi' => $row['nimi']
            ));
        }
        return $osallistujat;
    }

}
