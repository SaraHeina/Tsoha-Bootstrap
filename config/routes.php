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

$routes->get('/task', function() {
    TaskController::tasks();
});

$routes->post('/task', function(){
  TaskController::store();
});

$routes->get('/task/new', function(){
    TaskController::create();
});

$routes->get('/task/:id', function($id) {
    TaskController::show_task($id);
});



