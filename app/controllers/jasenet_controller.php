<?php

class JasenController extends BaseController {

    public static function jasenet() {
        $jasenet = Jasen::all();
        View::make('jasenet.html', array('jasenet' => $jasenet));
    }

    
    public static function profiili($id) {
        $jasen = Jasen::find($id);
        View::make('profiili.html', array('jasen' => $jasen));
    }

    public static function jasenrekisteri() {
        $jasenet = Jasen::all();
        View::make('jasenrekisteri.html', array('jasenet' => $jasenet));
    }
}
