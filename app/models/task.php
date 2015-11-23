<?php

class Task extends BaseModel {

    public $id, $user_id, $priority, $deadline, $completed, $name, $description;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array(
            'validate_priority', 'validate_name', 'validate_description', 'validate_deadline');
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Task WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $task = new Task(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'priority' => $row['priority'],
                'deadline' => $row['deadline'],
                'completed' => $row['completed'],
                'name' => $row['name'],
                'description' => $row['description']
            ));
            return $task;
        }
        return null;
    }

    public static function all($user_id) {
        $query = DB::connection()->prepare('SELECT * FROM Task WHERE user_id = :user_id');
        $query->execute(array('user_id' => $user_id));
        $rows = $query->fetchAll();
        $tasks = array();

        foreach ($rows as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'priority' => $row['priority'],
                'deadline' => $row['deadline'],
                'completed' => $row['completed'],
                'name' => $row['name'],
                'description' => $row['description']
            ));
        }
        return $tasks;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Task (user_id, name, description, priority, deadline) VALUES (:user_id, :name, :description, :priority, :deadline) RETURNING id');
        $query->execute(array('user_id' => $this->user_id, 'name' => $this->name, 'description' => $this->description, 'priority' => $this->priority, 'deadline' => $this->deadline));
        $row = $query->fetch();
        Kint::trace();
        Kint::dump($row);
        $this->id = $row['id'];
    }

    public static function destroy($id) {
        self::disconnect_categories($id);
        $query = DB::connection()->prepare('DELETE FROM Task WHERE id = :id');
        $query->execute(array('id' => $id));
    }

    public static function complete($id) {
        $query = DB::connection()->prepare('UPDATE Task SET completed = true WHERE id = :id');
        $query->execute(array('id' => $id));
    }

    public static function update($id, $attributes) {
        $query = DB::connection()->prepare('UPDATE Task SET (priority, deadline, name, description) = (:priority, :deadline, :name, :description) WHERE id = :id');
        $query->execute(array('id' => $id, 'priority' => $attributes['priority'], 'deadline' => $attributes['deadline'], 'name' => $attributes['name'], 'description' => $attributes['description']));
    }

    public function validate_priority() {
        $errors = array();
        if ($this->priority == '' || $this->priority == null) {
            $errors[] = 'Tehtävälle pitää antaa prioriteetti!';
        }
        if ($this->priority != 0 && $this->priority != 1 && $this->priority != 2) {
            $errors[] = 'Prioriteettivirhe!';
        }
        return $errors;
    }

    public function validate_name() {
        $errors = array();
        if ($this->name == '' || $this->name == null) {
            $errors[] = 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->name) > 255) {
            $errors[] = 'Nimen pituus max 255 merkkiä!';
        }
        return $errors;
    }

    public function validate_description() {
        $errors = array();
        if (strlen($this->description) > 2000) {
            $errors[] = 'Kuvaus saa olla enintään 2000 merkkiä pitkä!';
        }
        return $errors;
    }

    public function validate_deadline() {
        $errors = array();
        if (!isset($this->deadline) || $this->deadline == '') {
            $errors[] = 'Tehtävällä pitää olla deadline!';
        } else {
            $date = DateTime::createFromFormat('Y-m-d', $this->deadline);
            $date_errors = DateTime::getLastErrors();
            if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) {
                $errors[] = 'Deadlinen päivämäärä ei ole kelvollinen!';
            }
        }
        return $errors;
    }

    public function categories() {
        $categories = array();
        $query = DB::connection()->prepare('SELECT * FROM Category WHERE id IN (SELECT category_id FROM TaskCategory WHERE task_id = :task_id )');
        $query->execute(array('task_id' => $this->id));
        $rows = $query->fetchAll();
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
    
    public static function connect_categories($category_ids, $task_id){
        foreach($category_ids as $category_id){
            $query = DB::connection()->prepare('INSERT INTO TaskCategory (category_id, task_id) VALUES (:category_id, :task_id)');
            $query->execute(array('category_id' => $category_id, 'task_id' => $task_id));
        }
    }
    
    public static function disconnect_categories($task_id){
        $query = DB::connection()->prepare('DELETE FROM TaskCategory WHERE task_id = :id');
        $query->execute(array('id' => $task_id));
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

