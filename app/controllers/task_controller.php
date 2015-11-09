<?php

class TaskController extends BaseController {
     public static function tasks(){
         $tasks = Task::all();
         View::make('task/tasks.html', array('tasks' => $tasks));
     }
     
     public static function show_task($id){
         $task = Task::find($id);
         View::make('task/show_task.html', array('task' => $task));
     }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

