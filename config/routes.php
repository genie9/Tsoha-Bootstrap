<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hallinta', function() {
    HelloWorldController::hallinta();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});
