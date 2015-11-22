<?php

class Category extends BaseModel {

    public $id, $user_id, $name, $description;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_description');
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Category WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $category = new Category(array(
            'id' => $row['id'],
            'user_id' => $row['user_id'],
            'name' => $row['name'],
            'description' => $row['description']
          ));
          return $category;
        }
        return null;
    }
    
    public static function all($user_id){
        $query = DB::connection()->prepare('SELECT * FROM Category WHERE user_id = :user_id');
        $query->execute(array('user_id' => $user_id));
        $rows = $query->fetchAll();
        $categories = array();
        foreach ($rows as $row) {
            $categories[] = new Category(array(
            'id' => $row['id'],
            'user_id' => $row['user_id'],
            'name' => $row['name'],
            'description' => $row['description']
          ));
        }
        return $categories;
    }
    
    public function validate_name(){
        $errors = array();
        if($this->name == '' || $this->name == null){
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if(strlen($this->name) > 255){
            $errors[] = 'Nimen pituus max 255 merkkiä!';
        }
        return $errors;
    }
    public function validate_description(){
        $errors = array();
        if(strlen($this->description) > 2000){
            $errors[] = 'Kuvaus saa olla enintään 2000 merkkiä pitkä!';
        }
        return $errors;
    }

    public static function update($id, $attributes){
        $query = DB::connection()->prepare('UPDATE Category SET (name, description) = (:name, :description) WHERE id = :id');
        $query->execute(array('id' => $id, 'name' => $attributes['name'], 'description' => $attributes['description']));
    }
    
    public static function destroy($id){
        $query = DB::connection()->prepare('DELETE FROM Category WHERE id = :id');
        $query->execute(array('id' => $id));
    }
}
