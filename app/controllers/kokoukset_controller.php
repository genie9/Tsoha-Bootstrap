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
        
        if (isset($_POST['tyyppi'])) {
            $tyyppi = $_POST['tyyppi'];
        } else {
            $tyyppi = "";
        }
        if (isset($_POST['osallistujat'])) {
            $osallistujat = $_POST['osallistujat'];
        } else {
            $osallistujat = "";
        }
        
        $params = $_POST;

        $attributes_kokous = array(
            'pvm' => $params['pvm'],
            'aika' => $params['aika'],
            'paikka' => $params['paikka'],
            'tyyppi' => $tyyppi,
            'jasenet_id' => $osallistujat);
        $kokous = new Kokous($attributes_kokous);
//        $errors_kokous = $kokous->errors();
//        if($params['osallistujat'] != ''){
//            $kokous->jasenet_id
//        }

        $maksut = FALSE;
        $errors_maksu = array();

        if ($params['vuosi'] != '') {
            $maksut = TRUE;
            $attributes_maksu = array(
                'vuosi' => $params['vuosi'],
                'maara_lapsi' => $params['maara_lapsi'],
                'maara_aikuinen' => $params['maara_aikuinen'],
                'maara_skil' => $params['maara_skil'],
                'maara_liity' => $params['maara_liity']
            );
            $maksu = new Jasenmaksu($attributes_maksu);
            $errors_maksu = $maksu->errors();
        }
//count($errors_kokous) == 0 && 
        if (count($errors_maksu) == 0) {
            $kokous->save();
            if ($maksut) {
                $maksu->save();
            }
            Redirect::to('/hallinta/kokoukset', array('message' => 'Kokous on lisätty!'));
        } else {
//            $errors = array_merge($errors_maksu, $errors_kokous);
            View::make('kokous.html', array('errors' => $errors_maksu, 'attr_kokous' => $attributes_kokous, 'attr_maksu' => $attributes_maksu));
        }
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
