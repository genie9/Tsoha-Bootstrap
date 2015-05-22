<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/jasenet', function() {
    HelloWorldController::jasenet();
});

$routes->get('/rekisterointi', function() {
    HelloWorldController::rek();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/profiili', function() {
    HelloWorldController::profiili();
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
