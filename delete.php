<?php
    require "config.php";
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
    } else {        
        try {
            delete_attachment($connection, $_GET['id']);
        } catch(mysqli_sql_exception $e) {
            echo "Erro na deleção de anexo.";
            http_response_code(400);
        }

        // header("Location: edit.php?id={$task_id}");
    }  
?>