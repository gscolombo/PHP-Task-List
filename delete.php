<?php
    require "db.php";

    if (! $_GET['attachment']) {
        if ($_POST['deleteAll']) {
            mysqli_query($connection, "DELETE FROM tasks");
            mysqli_query($connection, "DELETE FROM attachments");
    
            $query = "SELECT * FROM attachments";
            $attachments = mysqli_query($connection, $query);
    
            while ($attachment = mysqli_fetch_assoc($attachments)) {
                unlink("attachments/{$attachment['file']}");
            }    
        } else {
            delete_task($connection, $_GET['id']);
        }
        header('Location: tasks.php');
    } else {
        $query = "SELECT task_id FROM attachments WHERE id = {$_GET['id']}";
        $query_result = mysqli_query($connection, $query);
        $task_id = mysqli_fetch_column($query_result);
        
        delete_attachment($connection, $_GET['id']);
        header("Location: edit.php?id={$task_id}");
    }  
?>