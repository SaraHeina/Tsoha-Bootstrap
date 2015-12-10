<?php

class User extends BaseModel {

    public $id, $name, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_password');
    }

    public function create() {
        $query = DB::connection()->prepare('INSERT INTO Person (name, password) VALUES (:name, :password) RETURNING id');
        $query->execute(array('name' => $this->name, 'password' => $this->password));
        $row = $query->fetch();
        Kint::trace();
        Kint::dump($row);
        $this->id = $row['id'];
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Person');
        $query->execute();
        $rows = $query->fetchAll();
        $users = array();

        foreach ($rows as $row) {
            $users[] = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));
        }
        return $users;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'password' => $row['password']
            ));

            return $user;
        }
        return null;
    }

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Käyttäjätunnus ei saa olla tyhjä!';
        }
        if (strlen($this->name) > 30) {
            $errors[] = 'Käyttäjätunnuksen pituus saa olla enintään 30 merkkiä!';
        }
        if(self::name_exists($this->name)){
            $errors[] = 'Käyttäjätunnus on jo käytössä, valitse toinen!';
        }
        return $errors;
    }
    
    public static function name_exists($name){
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE name = :name LIMIT 1');
        $query->execute(array('name' => $name));
        $row = $query->fetchAll();
        if(count($row) > 0){
            return true;
        }
        return false;
    }

    public function validate_password() {
        $errors = array();
        if ($this->password == '' || $this->password == null) {
            $errors[] = 'Salasana ei saa olla tyhjä!';
        }
        if (strlen($this->password) > 30) {
            $errors[] = 'Salasana saa olla enintään 30 merkkiä pitkä!';
        }
        return $errors;
    }

    public static function authenticate($name, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Person WHERE name = :name AND password = :password LIMIT 1');
        $query->execute(array('name' => $name, 'password' => $password));
        $row = $query->fetch();
        $user = new User(array(
            'id' => $row['id'],
            'name' => $row['name'],
            'password' => $row['password']
        ));
        if ($user->password == $password) {
            return $user;
        }
        return false;
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

