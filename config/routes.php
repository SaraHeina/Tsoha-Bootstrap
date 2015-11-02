<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

$routes->get('/tehtava/1/edit', function() {
    HelloWorldController::tehtava_edit();
});

$routes->get('/tehtava/1', function() {
    HelloWorldController::tehtava_show();
});

$routes->get('/tehtava', function() {
    HelloWorldController::tehtava_list();
});