<?php
    require "db.php";

    if ($_POST['deleteAll']) {
        $query = "DELETE FROM tasks";
        mysqli_query($connection, $query);
        header('Location: tasks.php');
    } else {
        delete_task($connection, $_POST['id']);
        header('Location: tasks.php');
    }
?>