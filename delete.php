<?php
    require "config.php";
    require "db.php";

    if (!array_key_exists('attachment', $_GET)) {
        if (array_key_exists('deleteAll', $_GET)) {
            $repo -> removeAll();    
        } else {            
            $repo -> remove($_GET['id']);

            $query = "SELECT COUNT(*) FROM tasks";
            $number_of_rows = ["rows" => mysqli_fetch_column(mysqli_query($connection, $query))];
            echo json_encode($number_of_rows);
        }
    } else {        
        try {
            $repo -> removeAttach($_GET['id']);
        } catch(mysqli_sql_exception $e) {
            echo "Erro na deleção de anexo.";
            http_response_code(400);
        }
    }
?>