<?php

class HelloWorldController extends BaseController {

    public static function index() {
        View::make('base.html');
    }

    public static function hallinta() {
        View::make('hallinta_base.html');
    }

    public static function sandbox() {
        $jasen = new Jasen(array(
            'nimi'=>'',
            'sala'=>'elel',
            'email'=>'y',
            'syntyma'=>'12.12.1923'
        ));
        $errors = $jasen->errors();
        Kint::dump($errors);
    }

}
