<?php

class TaskController extends BaseController {

    public static function tasks() {
        self::check_logged_in();
        $user = self::get_user_logged_in();
        $user_id = $user->id;
        $tasks = Task::all($user_id);
        View::make('task/tasks.html', array('tasks' => $tasks));
    }

    public static function show_task($id) {
        self::check_logged_in();
        $task = Task::find($id);
        View::make('task/show_task.html', array('task' => $task));
    }

    public static function create() {
        self::check_logged_in();
        View::make('task/new.html');
    }
    
    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $user = self::get_user_logged_in();
        $user_id = $user->id;
        $attributes = new Task(Array(
            'user_id' => $user_id,
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline'],
        ));
        $task = new Task($attributes);
        $errors = $task->errors();
        if(count($errors) == 0){
            $task->save();
            Redirect::to('/task/' . $task->id, array('message' => 'Tehtävä on lisätty :)'));
        }else{
            View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes));
        }
        //Kint::dump($params);
        //$task->save();  
    }
    
    public static function edit($id){
        self::check_logged_in();
        $task = Task::find($id);
        View::make('task/edit.html', array('attributes' => $task));
    }
    
    public static function complete($id){
        self::check_logged_in();
        $task = new Task(array('id' => $id));
        Task::complete($id);
        Redirect::to('/task', array('message' => 'Tehtävä suoritettu!'));
    }
    
    public static function update($id){
        self::check_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'name' => $params['name'],
            'description' => $params['description'],
            'priority' => $params['priority'],
            'deadline' => $params['deadline']
        );
        
        $task = new Task($attributes);
        $errors = $task->errors();
        if(count($errors) > 0){
            View::make('task/edit.html', array('errors' => $errors, 'attributes' => $attributes));
        }else{
            $task->update($id, $attributes);
            Redirect::to('/task/' . $task->id, array('message' => 'Tehtävän muokaus onnistui!'));
        }
    }
    
    public static function destroy($id){
        self::check_logged_in();
        $task = new Task(array('id' => $id));
        $task->destroy($id);
        Redirect::to('/task', array('message' => 'Tehtävä on poistettu!'));
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

