<?php 

    session_start(); 

    if (array_key_exists('name', $_GET) && $_GET['name'] != '') {
        $task = [];

        $task['name'] = $_GET['name'];
        $task['priority'] = $_GET['priority'];

        foreach(array_keys($_GET) as $key) {
            if ($key !== 'name' && $key !== 'priority') {
                if (array_key_exists($key, $_GET)) {
                    $task[$key] = $_GET[$key];
                } else {
                    $task[$key] = '';
                }
            }
        }

        $_SESSION['task_list'][] = $task;
    }

    $task_list = [];
    if (array_key_exists('task_list', $_SESSION)){
        $task_list = $_SESSION['task_list'];
    }

    include "template.php";
?>