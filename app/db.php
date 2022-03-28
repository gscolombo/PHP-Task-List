<?php
    require 'src/Models/repository.php';
    require 'src/Models/storage.php';

    try{
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $repo = new Repository($pdo);
    } catch(PDOException $e) {
        echo "Falha na conexão com o banco de dados. Erro: ";
        echo $e -> getMessage();
        record_log("Falha na conexão com o banco de dados. Erro: " . $e -> getMessage());
        die();
    }

    try {
        $s3 = new Storage("latest", "sa-east-1");
    } catch(TypeError $e) {
        echo "Falha na criação de instância de cliente AWS S3. Erro: ";
        echo $e -> getMessage();
        record_log("Falha na criação de instância de cliente AWS S3. Erro: " . $e -> getMessage());
        die();
    }
?>