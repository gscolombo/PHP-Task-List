<?php     
    try{
        $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB);
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

    function find_task($conn, $id) {
        $query = "SELECT * FROM tasks WHERE id = {$id}";
        $query_result = mysqli_query($conn, $query);
        return mysqli_fetch_assoc($query_result);
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

    function edit_task($conn, $task) {
        $query = 
        "UPDATE tasks SET
            name = '{$task['name']}',
            description = '{$task['description']}',
            deadline = '{$task['deadline']}',
            priority = {$task['priority']},
            concluded = {$task['concluded']}
        WHERE id = {$task['id']}";

        mysqli_query($conn, $query);
    }

    function delete_task($conn, $id) {
        $attach_query = "SELECT * FROM attachments WHERE task_id = {$id}";
        $result = mysqli_query($conn, $attach_query);

        while ($attach = mysqli_fetch_assoc($result)) {
            mysqli_query($conn, "DELETE FROM attachments WHERE id = {$attach['id']}");
            unlink("attachments/{$attach['file']}");
        };
        
        $query = "DELETE FROM tasks WHERE id = {$id}";
        mysqli_query($conn, $query);
    }

    function save_attachment($conn, $attachment) {
        $query = "INSERT INTO attachments
                (task_id, name, file)
                VALUES
                (
                    {$attachment['task_id']},
                    '{$attachment['name']}',
                    '{$attachment['file']}'
                )
            ";
            
        mysqli_query($conn, $query);
    }

    function delete_attachment($conn, $id) {
        $query = "SELECT * FROM attachments WHERE id = {$id}";
        $attachment = mysqli_fetch_assoc(mysqli_query($conn, $query)); 

        mysqli_query($conn, "DELETE FROM attachments WHERE id = {$id}");
        unlink("attachments/{$attachment['file']}");
    }

    function find_attachments($conn, $id) {
        $query = "SELECT * FROM attachments WHERE task_id = $id";
        $result = mysqli_query($conn, $query);

        $attachments = [];
        while ($attachment = mysqli_fetch_assoc($result)) {
            $attachments[] = $attachment;
        }
        return $attachments;
    }
?>