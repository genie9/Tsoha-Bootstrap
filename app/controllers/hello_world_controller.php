<?php

class HelloWorldController extends BaseController {

    public static function index() {
        View::make('base.html');
    }

    public static function rek() {
        View::make('rekisterointi.html');
    }

    public static function login() {
        View::make('login.html');
    }

    public static function profiili() {
        View::make('profiili.html');
    }

    public static function hallinta() {
        View::make('hallinta_base.html');
    }

    public static function jasenrekisteri() {
        View::make('jasenrekisteri.html');
    }

    public static function jasenet() {
        View::make('jasenet.html');
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
//        echo 'Hello World!';
    }

}
