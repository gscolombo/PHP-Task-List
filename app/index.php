<?php 
    require 'config.php';
    require 'helpers.php';
    require 'db.php';
    require 'src/Models/task.php';
    require 'src/Models/attachment.php';

    if (array_key_exists("route", $_GET)) {
        $route = (string) $_GET['route'];
        
        if ($route !== "storage") {
            $_GET =  array_filter($_GET, "filter_route", ARRAY_FILTER_USE_KEY);
            require __DIR__ . "/src/Controllers/{$route}.php";
        } else {
            if (array_key_exists("key", $_GET)) {
                $url = $s3 -> get_presigned_url($_GET["key"]);
                echo json_encode(["url" => $url]);
            }
        }
    } else {
        $task_list = $repo -> find();
        require "src/Views/template.php";
    }
?>