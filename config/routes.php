<?php

$routes->get('/', function() {
    KayttajatController::index();
});

$routes->get('/jasenet', function() {
    KayttajatController::jasenet();
});

$routes->post('/rekisterointi', function() {
    KayttajatController::rek_uusi();
});

$routes->get('/rekisterointi', function() {
    KayttajatController::rek_lomake();
});

$routes->get('/login', function() {
    KayttajatController::login();
});

$routes->post('/login', function() {
    KayttajatController::handle_login();
});

$routes->post('/logout', function() {
    KayttajatController::logout();
});

$routes->post('/update/:jasen_id', function($jasen_id) {
    JasenController::paivita($jasen_id);
});

$routes->post('/muokkaa_jasen/:jasen_id', function($jasen_id) {
    JasenController::muokkaa_jasen($jasen_id);
});

$routes->get('/profiili/:jasen_id', function($jasen_id) {
    JasenController::profiili($jasen_id);
});

$routes->post('/jasenrekisteri/hyvaksy/:jasen_id', function($jasen_id) {
    JasenhallintaController::hyvaksy($jasen_id);
});

$routes->post('/jasenrekisteri/poista/:jasen_id', function($jasen_id) {
    JasenhallintaController::delete($jasen_id);
});

$routes->get('/hallinta', function() {
    JasenhallintaController::hallinta();
});

$routes->get('/hallinta/jasenrekisteri', function() {
    JasenhallintaController::jasenrekisteri();
});

$routes->get('/hallinta/kokoukset', function() {
    KokouksetController::kokoukset();
});

$routes->post('/hallinta/kokoukset/poista/:kokous_id', function($kokous_id) {
    KokouksetController::delete($kokous_id);
});

$routes->get('/hallinta/kokous', function() {
    KokouksetController::kokous_lomake();
});

$routes->post('/hallinta/kokous', function() {
    KokouksetController::kokous_uusi();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
