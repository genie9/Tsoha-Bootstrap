<?php

class JasenController extends BaseController {

    public static function jasenet() {
        $jasenet = Jasen::all();
        View::make('jasenet.html', array('jasenet' => $jasenet));
    }

    public static function profiili($jasen_id) {
        $jasen = Jasen::find($jasen_id);
        $year = date("Y");
        View::make('profiili.html', array('jasen' => $jasen, 'year' => $year));
    }

    public static function muokkaa_jasen($jasen_id) {
        self::check_logged_in();
        $jasen = Jasen::find($jasen_id);

        View::make('muokkaa_jasen.html', array('attributes' => $jasen));
    }

    public static function paivita($jasen_id) {
        self::check_logged_in();
        $params = $_POST;
        $jasen_old = Jasen::find($jasen_id);

        $attributes = array(
            'jasen_id' => $jasen_id,
            'nimi' => $params['nimi'],
            'email' => $params['email'],
            'syntyma' => $params['syntyma'],
            'sala' => $params['sala'],
            'katuosoite' => $params['katuosoite'],
            'posti' => $params['posti'],
            'puhelin' => $params['puhelin'],
            'laji' => $params['laji'],
            'seura' => $params['seura']
        );
        $attributes['nimi'] = $jasen_old->nimi;
        $attributes['syntyma'] = $jasen_old->syntyma;

        $jasen = new Jasen($attributes);

        $errors = $jasen->errors();

        if (count($errors) == 0) {
            $jasen->update($jasen);
            Redirect::to('/profiili/' . $jasen->jasen_id, array('message' => 'Muutokset OK'));
        } else {
            View::make('muokkaa_jasen.html', array('errors' => $errors, 'attributes' => $jasen,
                'message' => "ei mitään käsitystä miksi pitää olla nimi vaikka se on jo siinä!!! ", print_r($attributes)));
        }
    }

    public static function jasenrekisteri() {
        self::check_logged_in();
        $jasenet = Jasen::all();
        View::make('jasenrekisteri.html', array('jasenet' => $jasenet));
    }

    public static function delete($jasen_id) {
        self::check_logged_in();
        $jasen = new Jasen(array('jasen_id' => $jasen_id));

        if ($jasen->poista($jasen_id)) {
            Redirect::to('/hallinta/jasenrekisteri', array('message1' => 'Henkilö on poistettu onnistuneesti!'));
        } else {
            $jasenet = Jasen::all();
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'message2' => 'PHenkilöä ei voida poistaa :('));
        }
    }

    public static function hyvaksy($jasen_id) {
        self::check_logged_in();
        $jasen = new Jasen(array('jasen_id' => $jasen_id));

        if ($jasen->hyvaksy($jasen_id)) {
            Redirect::to('/hallinta/jasenrekisteri', array('message1' => 'Henkilön tiedot päivitetty!'));
        } else {
            $jasenet = Jasen::all();
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'message2' => 'Henkilön tietojen päivittäminen epäonnistui :('));
        }
    }

}
