<?php

class JasenhallintaController extends BaseController {

    public static function hallinta() {
        View::make('hallinta_base.html');
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
