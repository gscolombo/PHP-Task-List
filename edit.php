<?php
    require "db.php";
    require "helpers.php";

    $show_tasks = false;

    if (array_key_exists('name', $_GET) && $_GET['name'] != '') {
        $task = set_task();
        
        edit_task($connection, $task);
        header('Location: tasks.php');
        die();    
    }

    $task = find_task($connection, $_GET['id']);
    
    require "template.php";
?>