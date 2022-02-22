<?php
    require "config.php";
    require "db.php";

    if (array_key_exists("id", $_GET) && $_GET['id'] !== "") {
        $query = "UPDATE tasks SET concluded = 1 WHERE id = {$_GET['id']}";

        try {
            mysqli_query($connection, $query);
        } catch (mysqli_sql_exception $e) {
            http_response_code(400);
        }   
    }
?>