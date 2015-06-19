<?php

class JasenhallintaController extends BaseController {

    public static function hallinta() {
        View::make('hallinta_base.html');
    }

    public static function jasenrekisteri() {
        self::check_logged_in();
        $vuosi = date('Y');
        $jasenet = Jasen::all();
        $jasenmaksut = Jasenmaksu::find($vuosi);
        
        if (!$jasenmaksut) {
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'vuosi' => $vuosi, 'message2' => 'Jäsenmaksuja ei ole määritetty tälle vuodelle!'));
        } else {
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'vuosi' => $vuosi, 'maksu' => $jasenmaksut));
        }
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
        $jasen = Jasen::find($jasen_id);

        $params = $_POST;
        print_r($params);
        
        if (($_POST['maksu_id']) == '') {
            $jasenet = Jasen::all();
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'message2' => 'Henkilön tietoja ei voida päivittää jäsenmaksujen puuttuessa :('));
        }
        /* jos checkbox on tyhjä määritetään muuttujat atribuutti-arraylle */
        /* tää häkki refaktoroidaan??? */
        if (!isset($_POST['maara_skil'])) {
            $maara_skil = "";
        } else {
            $maara_skil = $_POST['maara_skil'];
        }
        if (!isset($_POST['maara_aikuinen'])) {
            $maara_aikuinen = "";
        } else {
            $maara_aikuinen = $_POST['maara_aikuinen'];
        }
        if (!isset($_POST['maara_lapsi'])) {
            $maara_lapsi = "";
        } else {
            $maara_lapsi = $_POST['maara_lapsi'];
        }
        if (!isset($_POST['maara_liity'])) {
            $maara_liity = "";
        } else {
            $maara_liity = $_POST['maara_liity'];
        }

        $attributes = array(
            'maksu_id' => $params['maksu_id'],
            'vuosi' => $params['vuosi'],
            'maara_liity' => $maara_liity,
            'maara_aikuinen' => $maara_aikuinen,
            'maara_lapsi' => $maara_lapsi,
            'maara_skil' => $maara_skil);

        $maksu = new Jasenmaksu($attributes);
//        print_r($maksu);
//        exit();
        if ($jasen->hyvaksy($maara_skil) && $maksu->luo_maksu($jasen_id) ) {
            Redirect::to('/hallinta/jasenrekisteri', array('message1' => 'Henkilön tiedot päivitetty!'));
        } else {
            $jasenet = Jasen::all();
            View::make('jasenrekisteri.html', array('jasenet' => $jasenet, 'message2' => 'Henkilön tietojen päivittäminen epäonnistui :('));
        }
    }

}
