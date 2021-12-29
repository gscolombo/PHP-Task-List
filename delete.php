<?php
    require "db.php";

    if ($_GET['deleteAll']) {
        $query = "DELETE FROM tasks";
        mysqli_query($connection, $query);
        header('Location: tasks.php');
    } else {
        delete_task($connection, $_GET['id']);
        header('Location: tasks.php');
    }
?>