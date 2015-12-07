<?php

$routes->get('/', function() {
    TaskController::tasks();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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

$routes->post('/task', function() {
    TaskController::store();
});

$routes->get('/task/new', function() {
    TaskController::create();
});

$routes->get('/task/:id', function($id) {
    TaskController::show_task($id);
});

$routes->get('/task/:id/edit', function($id) {
    TaskController::edit($id);
});

$routes->post('/task/:id/edit', function($id) {
    TaskController::update($id);
});

$routes->post('/task/:id/destroy', function($id) {
    TaskController::destroy($id);
});

$routes->get('/tasks/complete/:id', function($id) {
    TaskController::complete($id);
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->post('/logout', function() {
    UserController::logout();
});

$routes->get('/register', function() {
    UserController::register();
});

$routes->post('/register', function() {
    UserController::handle_registration();
});

$routes->get('/categories', function() {
    CategoryController::categories();
});

$routes->get('/categories/:id/edit', function($id) {
    CategoryController::edit_category($id);
});

$routes->post('/categories/:id/edit', function($id) {
    CategoryController::update($id);
});

$routes->post('/categories/:id/destroy', function($id) {
    CategoryController::destroy($id);
});

$routes->post('/categories', function() {
    CategoryController::store();
});

$routes->get('/categories/new', function() {
    CategoryController::create();
});

