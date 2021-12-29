<?php 
    require 'db.php';
    require 'helpers.php';

    $show_tasks = true;

    if (array_key_exists('name', $_GET) && $_GET['name'] != '') {
        $task = set_task();

        save_task($connection, $task);
        header('Location: tasks.php');
        die();
    }

    $task_list = find_tasks($connection);
    
    require "template.php";
?>