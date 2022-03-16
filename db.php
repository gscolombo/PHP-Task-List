<?php
    require 'src/Controller/repository.php';

    try{
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $repo = new Repository($pdo);
    } catch(PDOException $e) {
        echo "Falha na conexão com o banco de dados. Erro: ";
        echo $e -> getMessage();
        die();
    }
?>