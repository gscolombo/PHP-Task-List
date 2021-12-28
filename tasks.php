<?php 
    require 'db.php';
    require 'helpers.php';

    if (array_key_exists('name', $_GET) && $_GET['name'] != '') {
        $task = [];

        foreach(array_keys($_GET) as $key) {
            $task[$key] = $_GET[$key];
        }

        if (!array_key_exists('concluded', $task)) {
            $task['concluded'] = 0;
        } else {
            $task['concluded'] = 1;
        }

        save_task($connection, $task);
    }


    $task_list = find_tasks($connection);
    
    require "template.php";
?>