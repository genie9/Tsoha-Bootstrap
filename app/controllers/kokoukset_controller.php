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
        $muokkaa = FALSE;
        View::make('kokous.html', array('jasenet' => $jasenet, 'muokkaa'=>$muokkaa));
    }

    public static function kokous_uusi() {
        self::check_logged_in();
        $muokkaa = FALSE;
        /* checkboxien inputit jos tyhjät käsitellään erikseen*/
        if (isset($_POST['tyyppi'])) {
            $tyyppi = $_POST['tyyppi'];
        } else {
            $tyyppi = "";
        }
        if (isset($_POST['osallistujat'])) {
            $osallistujat = $_POST['osallistujat'];
        } else {
            $osallistujat = array();
        }

        $params = $_POST;

        $attributes_kokous = array(
            'pvm' => $params['pvm'],
            'aika' => $params['aika'],
            'paikka' => $params['paikka'],
            'tyyppi' => $tyyppi,
            'jasenet_id' => $osallistujat);

        $kokous = new Kokous($attributes_kokous);
        $errors_kokous = $kokous->errors();
        
        /* jos jäsenmaksuja ei aseteta määritellään maksuihin liittyvät muuttujat tyhjiksi*/
        /* voisi refaktoroida omaksi funktioksi */
        $maksut = FALSE;
        $errors_maksu = array();
        $attributes_maksu = array();
        $message = '';

        if ($params['vuosi'] != '') {
            print_r($_POST);
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

        if (count($errors_kokous) == 0 && count($errors_maksu) == 0) {
            $kokous->save();
            if ($maksut) {
                $maksu->save();
                $message = ' ja jäsenmaksut vuodelle ' . $params['vuosi'] . ' asetettu';
            }
            Redirect::to('/hallinta/kokoukset', array('message1' => 'Kokous on lisätty' . $message . '!'));
        } else {
            $jasenet = Jasen::all();
            $errors = array_merge($errors_maksu, $errors_kokous);
            $attributes = array_merge($attributes_maksu, $attributes_kokous);
            View::make('kokous.html', array('errors' => $errors, 'attributes' => $attributes, 'jasenet' => $jasenet, 'muokkaa'=>$muokkaa));
        }
    }

    public static function muokkaa_kokous($kokous_id) {
        self::check_logged_in();
        $jasenet = Jasen::all();
        $kokous = Kokous::find($kokous_id);
        $muokkaa = TRUE;
        View::make('kokous.html', array('jasenet' => $jasenet, 'attributes' => $kokous, 'muokkaa' => $muokkaa));
    }

    public static function paivita($kokous_id) {
        self::check_logged_in();
        $muokkaa = TRUE;
        /* checkboxien inputit jos tyhjät käsitellään erikseen*/
        if (isset($_POST['tyyppi'])) {
            $tyyppi = $_POST['tyyppi'];
        } else {
            $tyyppi = "";
        }
        if (isset($_POST['osallistujat'])) {
            $osallistujat = $_POST['osallistujat'];
        } else {
            $osallistujat = array();
        }        
        
        $params = $_POST;

        $attributes = array(
            'kokous_id' => $kokous_id,
            'pvm' => $params['pvm'],
            'aika' => $params['aika'],
            'paikka' => $params['paikka'],
            'tyyppi' => $tyyppi,
            'jasenet_id' => $osallistujat);

        $kokous = new Kokous($attributes);
        $errors = $kokous->errors();

        if (count($errors) == 0) {
            $kokous->update();
            Redirect::to('/hallinta/kokoukset', array('message1' => 'Kokous on päivitetty!'));
        } else {
            $jasenet = Jasen::all();
            View::make('kokous.html', array('errors' => $errors, 'attributes' => $attributes, 'jasenet' => $jasenet, 'muokkaa'=>$muokkaa));
        }
    }

    public static function delete($kokous_id) {
        self::check_logged_in();
        $kokous = Kokous::find($kokous_id);

        if ($kokous->poista()) {
            Redirect::to('/hallinta/kokoukset', array('message1' => 'Kokous on poistettu onnistuneesti!'));
        } else {
            $kokoukset = Kokous::all();
            View::make('kokoukset.html', array('kokoukset' => $kokoukset, 'message2' => 'Kokousta ei voida poistaa :('));
        }
    }

}
