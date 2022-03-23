<?php
    if (!array_key_exists('attachment', $_GET)) {
        if (array_key_exists('deleteAll', $_GET)) {
            $repo -> removeAll();    
        } else {            
            $repo -> remove($_GET['id']);

            $query = "SELECT COUNT(*) FROM tasks";
            $number_of_rows = $repo -> getConnection() -> query($query) -> fetchColumn();
            echo json_encode(["rows" => $number_of_rows]);
        }
    } else {        
        try {
            $repo -> removeAttach($_GET['id']);
        } catch(mysqli_sql_exception $e) {
            $error = ["message" => "Erro na deleção de anexo. Erro:" . $e -> getMessage()];
            echo json_encode($error);
            http_response_code(400);
        }
    }
?>