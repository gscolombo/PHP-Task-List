<?php 

    session_start(); 

    if (array_key_exists('name', $_GET) && $_GET['name'] != '') {
        $task = [];

        foreach(array_keys($_GET) as $key) {
            $task[$key] = $_GET[$key];
        }

        if (!array_key_exists('concluded', $task)) {
            $task['concluded'] = "Não";
        }

        $_SESSION['task_list'][] = $task;
    }

    $task_list = [];
    if (array_key_exists('task_list', $_SESSION)){
        $task_list = $_SESSION['task_list'];
    }
    
    include "template.php";
?>