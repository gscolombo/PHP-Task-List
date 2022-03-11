<?php
    require "config.php";
    require "db.php";

    if (!array_key_exists('attachment', $_GET)) {
        if (array_key_exists('deleteAll', $_GET)) {
            mysqli_query($connection, "DELETE FROM tasks");
            mysqli_query($connection, "DELETE FROM attachments");
    
            $query = "SELECT * FROM attachments";
            $attachments = mysqli_query($connection, $query);
    
            while ($attachment = mysqli_fetch_assoc($attachments)) {
                unlink("attachments/{$attachment['file']}");
            }    
        } else {
            delete_task($connection, $_GET['id']);

            $query = "SELECT COUNT(*) FROM tasks";
            $number_of_rows = ["rows" => mysqli_fetch_column(mysqli_query($connection, $query))];
            echo json_encode($number_of_rows);
        }
    } else {        
        try {
            delete_attachment($connection, $_GET['id']);
        } catch(mysqli_sql_exception $e) {
            echo "Erro na deleção de anexo.";
            http_response_code(400);
        }
    }
?>