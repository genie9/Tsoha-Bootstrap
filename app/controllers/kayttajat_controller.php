<?php

class KayttajatController extends BaseController {

    public static function rek_lomake() {
        View::make('rekisterointi.html');
    }

    public static function rek_uusi() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Jasen-luokan olion käyttäjän syöttämillä arvoilla
        $jasen = new Jasen(array(
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

        // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
        $jasen->save();

        // Ohjataan käyttäjä lisäyksen jälkeen omalle profiilisivulle
        Redirect::to('/profiili/' . $jasen->id, array('message' => print_r($_POST, TRUE)));
    }

    public static function delete($id) {
        $jasen = new Jasen(array('id' => $id));
        $jasen->destroy();
        Redirect::to('/jasenrekisteri', array('message' => 'Henkilö on poistettu onnistuneesti!'));
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
