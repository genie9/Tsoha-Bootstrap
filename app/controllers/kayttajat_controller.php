<?php

class KayttajatController extends BaseController {

    public static function rek_lomake() {
        View::make('rekisterointi.html');
    }

    public static function rek_uusi() {
        $params = $_POST;

        $attributes = (array(
            'nimi' => $params['nimi'],
            'email' => $params['email'],
            'sala' => $params['sala'],
            'katuosoite' => $params['katuosoite'],
            'posti' => $params['posti'],
            'puhelin' => $params['puhelin'],
            'syntyma' => $params['syntyma'],
            'huoltaja' => $params['huoltaja'],
            'laji' => $params['laji'],
            'seura' => $params['seura']
        ));
        $jasen = new Jasen($attributes);
        $errors = $jasen->errors();

        if (count($errors) == 0) {
            $jasen->save();
            Redirect::to('/profiili/' . $jasen->id, array('message' => 'Hakemuksesi käsitellään seuraavassa hallituksen kokouksessa'));
        } else {
            View::make('rekisterointi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    

    public static function login() {
        View::make('login.html');
    }

    public static function handle_login() {
        $params = $_POST;

        $kayttaja = Jasen::authenticate($params['nimi'], $params['sala']);

        if (!$kayttaja) {
            View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;

            Redirect::to('/profiili/' . $kayttaja->id, array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
        }
    }

}
