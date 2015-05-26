<?php

class KayttajatController extends BaseModel {
    
    public static function login(){
        View::make('login.html');
    }
    
    public static function handle_login(){
    $params = $_POST;

    $kayttaja = Jasen::authenticate($params['nimi'], $params['sala']);

    if(!$kayttaja){
      View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'nimi' => $params['nimi']));
    }else{
      $_SESSION['kayttaja'] = $kayttaja->id;

      Redirect::to('/profiili/'.$kayttaja->id, array('message' => 'Tervetuloa takaisin ' . $kayttaja->nimi . '!'));
    }
  }
}
