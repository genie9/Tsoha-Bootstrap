<?php

class JasenController extends BaseController {

    public static function jasenet() {
        $jasenet = Jasen::all();
        View::make('jasenet.html', array('jasenet' => $jasenet));
    }

    public static function profiili($id) {
        $jasen = Jasen::find($id);
        $year = date("Y");
        View::make('profiili.html', array('jasen' => $jasen, 'year' => $year));
    }

    public static function muokkaa_jasen($id) {
        $jasen = Jasen::find($id);
        View::make('profiili/muokkaaJasen.html', array('jasen'=>$jasen));
    }

    public static function paivita($id) {
        $params = $_POST;

        $attributes = array(
            'nimi' => $jasen->nimi,
            'email' => $jasen->email,
            'sala' => $jasen->sala,
            'katuosoite' => $jasen->katuosoite,
            'posti' => $jasen->posti
        );
    }

    public static function jasenrekisteri() {
        $jasenet = Jasen::all();
        View::make('jasenrekisteri.html', array('jasenet' => $jasenet));
    }

    public static function delete($id) {
        $jasen = new Jasen(array('id' => $id));

        if ($jasen->poista($id)) {
            Redirect::to('/hallinta/jasenrekisteri', array('message1' => 'Henkilö on poistettu onnistuneesti!'));
        } else {
            $jasenet = Jasen::all();
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'message2' => 'Poistaminen epäonnistui :('));
        }
    }

    public static function hyvaksy($id) {
        $jasen = new Jasen(array('id' => $id));

        if ($jasen->hyvaksy($id)) {
            Redirect::to('/hallinta/jasenrekisteri', array('message1' => 'Henkilön tiedot päivitetty!'));
        } else {
            $jasenet = Jasen::all();
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'message2' => 'Henkilön tietojen päivittäminen epäonnistui:('));
        }
    }

}
