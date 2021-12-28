<?php 
    $dbServer = '127.0.0.1';
    $dbUser = 'systemtasks';
    $dbPassword = 'system';
    $db = 'tasks';
    
    try{
        $connection = mysqli_connect($dbServer, $dbUser, $dbPassword, $db);
    } catch(mysqli_sql_exception $e) {
        echo "Falha na conexão com o banco de dados. Erro: ";
        echo $e -> getMessage();
        die();
    }

    function find_tasks($conn) {
        $query = 'SELECT * FROM tasks';
        $query_result = mysqli_query($conn, $query);

        $tasks = [];

        while ($task = mysqli_fetch_assoc($query_result)) {
            $tasks[] = $task;
        }

        return $tasks;
    }

    function save_task($conn, $task) {
        $query = "INSERT INTO tasks
            (name, description, priority, deadline, concluded)
            VALUES
            (
                '{$task['name']}',
                '{$task['description']}',
                {$task['priority']},
                '{$task['deadline']}',
                {$task['concluded']}
            )";

        mysqli_query($conn, $query);
    }
?>