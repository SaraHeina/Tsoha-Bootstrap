<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }

    public static function handle_login() {
        $params = $_POST;
        $user = User::authenticate($params['name'], $params['password']);
        if (!$user) {
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'name' => $params['name']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/task', array('message' => 'Tervetuloa ' . $user->name . '!'));
        }
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function register() {
        View::make('user/register.html');
    }

    public static function handle_registration() {
        $params = $_POST;
        $password1 = $params['password'];
        $password2 = $params['password2'];
        $attributes = new User(array(
            'name' => $params['name'],
            'password' => $params['password']
        ));
        $user = new User($attributes);
        if ($password1 != $password2) {
            View::make('user/register.html', array('errors' => array('Salasanat eivät täsmää!'), 'user' => $user));
        }
        $errors = $user->errors();
        if (count($errors) == 0) {
            $user->create();
            Redirect::to('/login', array('message' => 'Käyttäjätunnus luotiin onnistuneesti! Nyt voit kirjautua sisään.'));
        } else {
            View::make('user/register.html', array('errors' => $errors, 'user' => $user));
        }
    }

}
