<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('base.html');
//        echo 'Hello Universe!';
    }

    public static function hallinta() {
        // Testaa koodiasi täällä
        View::make('hallinta_base.html');
//        echo 'Hello World!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
//        echo 'Hello World!';
    }

}
