<?php 
    require 'db.php';
    require 'helpers.php';

    $show_tasks = true;
    $is_invalid = false;
    $errors = [];

    if (has_data_task()) {
        $task = set_task(); 
        
        if (array_key_exists('name', $_POST) && $_POST['name'] != '') {
            $task['name'] = $_POST['name'];
        } else {
            $is_invalid = true;
            $errors['name'] = 'O título da tarefa é obrigatório!';
        };

        if (! $is_invalid) {
            save_task($connection, $task);
            header('Location: tasks.php');
            die();
        }
    }
    

    $task_list = find_tasks($connection);
    
    if (!isset($task)) {
        $task = [
            'id' => 0,
            'name' => array_key_exists('name', $_POST) ? $_POST['name'] : '',
            'description' => array_key_exists('description', $_POST) ? $_POST['description'] : '',
            'deadline' => array_key_exists('deadline', $_POST) ? $_POST['deadline'] : '',
            'priority' => array_key_exists('priority', $_POST) ? $_POST['priority'] : '',
            'concluded' => array_key_exists('concluded', $_POST) ? $_POST['concluded'] : '',
        ];
    }

    require "template.php";
?>