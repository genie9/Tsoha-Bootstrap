<?php

class KokouksetController extends BaseController {

    public static function kokoukset() {
        $kokoukset = Kokous::all();
        View::make('kokoukset.html', array('kokoukset' => $kokoukset));
    }

    public static function kokous_lomake() {
        $jasenet = Jasen::all();
        View::make('kokous.html', array('jasenet' => $jasenet));
    }

    public static function kokous_uusi() {
        $params = $_POST;
        $kokous = new Kokous(array(
            'pvm' => $params['pvm'],
            'aika' => $params['aika'],
            'paikka' => $params['paikka'],
            'tyyppi' => $params['tyyppi']
        ));
        $kokous->save();
        Redirect::to('/kokoukset', array('message' => 'Kokous on lisätty!'));
    }

}
