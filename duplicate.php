<?php
    require "config.php";
    require "db.php";

    $task = find_task($connection, $_GET['id']);
    save_task($connection, $task);
    
    echo json_encode(['id' => mysqli_insert_id($connection)]);
?>