<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/jasenet', function() {
    JasenController::jasenet();
});

$routes->get('/rekisterointi', function() {
    HelloWorldController::rek();
});

$routes->get('/login', function() {
    KayttajatController::login();
});

$routes->post('/login', function() {
    KayttajatController::handle_login();
});

//$routes->get('/profiili/1', function() {
//    HelloWorldController::profiili();
//});

$routes->get('/profiili/:id', function($id) {
    JasenController::profiili($id);
});

$routes->get('/hallinta', function() {
    HelloWorldController::hallinta();
});

$routes->get('/hallinta/jasenrekisteri', function() {
    HelloWorldController::jasenrekisteri();
});

$routes->get('/hallinta/kokoukset', function() {
    HelloWorldController::kokoukset();
});

$routes->get('/hallinta/kokous', function() {
    HelloWorldController::luo_kokous();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
