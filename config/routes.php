<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/jasenet', function() {
    JasenController::jasenet();
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

$routes->get('/muokkaa_jasen/:id', function($id) {
    JasenController::jasen_muokkaa($id);
});

$routes->post('/jasenrekisteri/hyvaksy/:id', function($id) {
    JasenController::hyvaksy($id);
});

$routes->post('/jasenrekisteri/poista/:id', function($id) {
    JasenController::delete($id);
});

$routes->get('/profiili/:id', function($id) {
    JasenController::profiili($id);
});

$routes->get('/hallinta', function() {
    HelloWorldController::hallinta();
});

$routes->get('/hallinta/jasenrekisteri', function() {
    JasenController::jasenrekisteri();
});

$routes->get('/hallinta/kokoukset', function() {
    KokouksetController::kokoukset();
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
