<?php

class JasenController extends BaseController {

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
            'jasen_id' => $jasen_old->jasen_id,
            'nimi' => $jasen_old->nimi,
            'email' => $params['email'],
            'syntyma' => $jasen_old->syntyma,
            'huoltaja' => $jasen_old->huoltaja,
            'sala' => $params['sala'],
            'katuosoite' => $params['katuosoite'],
            'posti' => $params['posti'],
            'puhelin' => $params['puhelin'],
            'laji' => $params['laji'],
            'seura' => $params['seura']
        );

        $jasen = new Jasen($attributes);
        $errors = $jasen->errors();

        if (count($errors) == 0) {
            $jasen->update($jasen);
            Redirect::to('/profiili/' . $jasen->jasen_id, array('message' => 'Muutokset OK'));
        } else {
            View::make('muokkaa_jasen.html', array('errors' => $errors, 'attributes' => $jasen));
        }
    }

}
