<?php
    require "config.php";
    require "db.php";

    $task = find_task($connection, $_POST['id']);

    save_task($connection, $task);
    header('Location: tasks.php');
    die();
?>