<?php

class KokouksetController extends BaseController {

    public static function kokoukset() {
        self::check_logged_in();
        $kokoukset = Kokous::all();
        $osallistujat = Osallistuja::all();
        View::make('kokoukset.html', array('kokoukset' => $kokoukset, 'osallistujat' => $osallistujat));
    }

    public static function kokous_lomake() {
        self::check_logged_in();
        $jasenet = Jasen::all();
        View::make('kokous.html', array('jasenet' => $jasenet));
    }

    public static function kokous_uusi() {
        self::check_logged_in();
        $params = $_POST;
        $kokous = new Kokous(array(
            'pvm' => $params['pvm'],
            'aika' => $params['aika'],
            'paikka' => $params['paikka'],
            'tyyppi' => $params['tyyppi'],
            'kokous_pvm' => $params['pvm'],
            'jasenet_id' => $params['osallistujat']
        ));
        $kokous->save();

        $maksu = new Jasenmaksu(array(
            'vuosi' => $params['vuosi'],
            'maara_lapsi' => $params['maara_lapsi'],
            'maara_aikuinen' => $params['maara_aikuinen'],
            'maara_skil' => $params['maara_skil'],
            'maara_liity' => $params['maara_liity']
        ));
        $maksu->save();
        
        Redirect::to('/hallinta/kokoukset', array('message' => 'Kokous on lisätty!'));
    }
    
    public static function delete($kokous_id) {
        self::check_logged_in();
        $kokous = new Kokous(array('kokous_id' => $kokous_id));

        if ($kokous->poista($kokous_id)) {
            Redirect::to('/hallinta/kokoukset', array('message1' => 'Kokous on poistettu onnistuneesti!'));
        } else {
            $kokoukset = Kokous::all();
            View::make('kokoukset.html', array('kokoukset' => $kokoukset, 'message2' => 'Kokousta ei voida poistaa :('));
        }
    }

}
