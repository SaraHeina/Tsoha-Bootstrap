<?php

class Task extends BaseModel {

    public $id, $user_id, $priority, $deadline, $completed, $name, $description;

    public function __construct($attributes) {
        parent::__construct($attributes);
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

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Task');
        $query->execute();
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

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

