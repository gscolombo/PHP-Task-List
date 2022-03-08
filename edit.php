<?php
    require "config.php";
    require "db.php";
    require "helpers.php";

    $show_tasks = false;
    $is_invalid = false;
    $errors = [];
    $response = [];
    $attachments = [];

    if (has_data_task()) {
        $task = set_task();

        if (array_key_exists('name', $_POST) && $_POST['name'] != '') {
            $task['name'] = $_POST['name'];
        } else {
            $is_invalid = true;
            $errors['name'] = 'O título da tarefa é obrigatório!';
        };

        $response['post'] = $task;
        
        // Upload de anexos
        if (array_key_exists('attachment-edit', $_FILES)) {
            $files = [];
            $files = rearrange_files('attachment-edit');

            foreach ($files['attachment-edit'] as $file) {
                if (check_attach($file)) {
                    $attachment = set_attachment($file);
                    $attachments[] = $attachment;
                } else {
                    $is_invalid = true;
                    $errors['attachment'] = "O formato do arquivo não é permitido! \n (Somente .pdf ou .zip)";
                    break;
                }
            }
        }

        if (! $is_invalid) {
            edit_task($connection, $task);
            $has_attachments = isset($attachments) && is_array($attachments);

            if (array_key_exists('reminder', $_POST) && $_POST['reminder'] == 1) {
                $has_attachments ? send_mail($task, $attachments) : send_mail($task);
            }

            if ($has_attachments) {
                foreach($attachments as $attachment) {
                    $attachment['task_id'] = $_POST['id'];
                    save_attachment($connection, $attachment);

                    $id = mysqli_insert_id($connection);
                    $attachment['id'] = $id;
                    $response['files'][] = $attachment;
                }
            }
            
            $response['status'] = "success";
        } else {
            http_response_code(400);
            $response['status'] = "failure";
            $response['errors'] = $errors;
        }
        echo json_encode($response);
    }
    
    if (array_key_exists("id", $_GET) && $_GET['id'] !== "") {
        $task = find_task($connection, $_GET['id']);
        $attachments = find_attachments($connection, $_GET['id']);
    
        $json = $task;
        $json['attachments'] = $attachments;
        echo json_encode($json);
    }

    header('Content-type: application/json; charset=UTF-8');
?>