<?php

class JasenController extends BaseModel {

    public static function jasenet() {
        $jasenet = Jasen::all();
        View::make('jasenet.html', array('jasenet' => $jasenet));
    }

    public static function profiili($id) {
        $jasen = Jasen::find($id);
        View::make('profiili.html', array('jasen' => $jasen));
    }

}
