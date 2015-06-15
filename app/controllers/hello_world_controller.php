<?php

class HelloWorldController extends BaseController {

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
