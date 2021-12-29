<?php
    require "db.php";

    $task = find_task($connection, $_GET['id']);

    save_task($connection, $task);
    header('Location: tasks.php');
    die();
?>