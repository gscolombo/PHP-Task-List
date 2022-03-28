<?php
    if (!array_key_exists('attachment', $_GET)) {
        if (array_key_exists('deleteAll', $_GET)) {
            $repo -> removeAll();
            $s3 -> delete_objects();
        } else {            
            $attachments = $repo -> remove($_GET['id']);
            if ($attachments) {
                foreach($attachments as $attach) {
                    $s3 -> delete_object($attach -> getter("file"));
                }
            }

            $query = "SELECT COUNT(*) FROM tasks";
            $number_of_rows = $repo -> getConnection() -> query($query) -> fetchColumn();
            echo json_encode(["rows" => $number_of_rows]);
        }
    } else {        
        try {
            $attach_key = $repo -> removeAttach($_GET['id']);
            $s3 -> delete_object($attach_key);
        } catch(mysqli_sql_exception $e) {
            $error = ["message" => "Erro na deleção de anexo. Erro:" . $e -> getMessage()];
            echo json_encode($error);
            http_response_code(400);
        }
    }
?>