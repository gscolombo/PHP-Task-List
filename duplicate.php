<?php
    require "config.php";
    require "db.php";
    require "src/Controller/task.php";
    require "src/Controller/attachment.php";

    $task = $repo -> find($_GET['id']);
    $repo -> save($task);
    
    echo json_encode(['id' => $repo -> getConnection() -> insert_id]);
?>