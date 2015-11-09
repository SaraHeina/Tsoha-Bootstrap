<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        $some = User::find(1);
        $users = User::all();
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($users);
        Kint::dump($some);
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }

    public static function login() {
        View::make('suunnitelmat/login.html');
    }

    public static function tehtava_edit() {
        View::make('suunnitelmat/tehtava_edit.html');
    }

    public static function tehtava_show() {
        View::make('suunnitelmat/tehtava_show.html');
    }

    public static function tehtava_list() {
        View::make('suunnitelmat/tehtava_list.html');
    }

}
