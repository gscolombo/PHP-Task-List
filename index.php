<?php 
    require 'config.php';
    require 'db.php';
    require 'helpers.php';
    require 'src/Models/task.php';
    require 'src/Models/attachment.php';

    if (array_key_exists("route", $_GET)) {
        $route = (string) $_GET['route'];
        
        $_GET =  array_filter($_GET, "filter_route", ARRAY_FILTER_USE_KEY);
        require __DIR__ . "/src/Controllers/{$route}.php";
    } else {
        $task_list = $repo -> find();
        require "src/Views/template.php";
    }
?>