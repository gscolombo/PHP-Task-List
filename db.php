<?php
    require 'src/Controller/repository.php';

    try{
        $repo = new Repository(mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB));
    } catch(mysqli_sql_exception $e) {
        echo "Falha na conexão com o banco de dados. Erro: ";
        echo $e -> getMessage();
        die();
    }
?>