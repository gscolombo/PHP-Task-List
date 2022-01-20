<?php
    require "db.php";
    require "helpers.php";

    $show_tasks = false;
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
            edit_task($connection, $task);
            header('Location: tasks.php');
            die();
        }
    }
    
    $task = find_task($connection, $_GET['id']);
    $attachments = find_attachments($connection, $_GET['id']);

    $task['name'] = array_key_exists('name', $_POST) ? $_POST['name'] : $task['name'];
    $task['description'] = array_key_exists('description', $_POST) ? $_POST['description'] : $task['description'];
    $task['deadline'] = array_key_exists('deadline', $_POST) ? $_POST['deadline'] : $task['deadline'];
    $task['priority'] = array_key_exists('priority', $_POST) ? $_POST['priority'] : $task['priority'];
    $task['concluded'] = array_key_exists('concluded', $_POST) ? $_POST['concluded'] : $task['concluded'];
    
    require "template.php";
?>