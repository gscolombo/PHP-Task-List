<?php
    require "config.php";
    require "db.php";
    require "helpers.php";
    require 'src/Controller/task.php';
    require 'src/Controller/attachment.php';

    $show_tasks = false;
    $is_invalid = false;
    $errors = [];
    $response = [];
    $attachments = [];

    if (has_data_task()) {
        // $task = set_task();

        // if (array_key_exists('name', $_POST) && $_POST['name'] != '') {
        //     $task['name'] = $_POST['name'];
        // } else {
        //     $is_invalid = true;
        //     $errors['name'] = 'O título da tarefa é obrigatório!';
        // };
        if (array_key_exists('name', $_POST) && $_POST['name'] === '') {
            $is_invalid = true;
            $errors['name'] = 'O título da tarefa é obrigatório!';
        };

        $task = new Task();
        set_task($task);

        $response['post'] = $task;
        
        // Upload de anexos
        $has_file = false;
        foreach ($_FILES['attachment-edit']['name'] as $file) {
            if ($file !== "") {
                $has_file = true;
            }
        }
        
        if ($has_file) {
            $files = rearrange_files('attachment-edit');
            foreach ($files['attachment-edit'] as $file) {
                if (check_attach($file)) {
                    $attachment = new Attachment();
                    set_attachment($file, $attachment);
                    $attachments[] = $attachment;
                } else {
                    $is_invalid = true;
                    $errors['attachment'] = "O formato do arquivo não é permitido! \n (Somente .pdf ou .zip)";
                    break;
                }
            }
        }
        

        if (! $is_invalid) {
            $has_attachments = isset($attachments) && is_array($attachments);

            if (array_key_exists('reminder', $_POST) && $_POST['reminder'] == 1) {
                $has_attachments ? send_mail($task, $attachments) : send_mail($task);
            }

            if ($has_attachments) {
                $task -> setter('attachments', $attachments);
            }
            
            $repo -> edit($task);
            $response['files'] = $attachments;
            $response['status'] = "success";
        } else {
            http_response_code(400);
            $response['status'] = "failure";
            $response['errors'] = $errors;
        }
        echo json_encode($response);
    }
    
    if (array_key_exists("id", $_GET) && $_GET['id'] !== "") {
        $task = $repo -> find($_GET['id']) -> jsonSerialize();
        echo json_encode($task);
    }

    header('Content-type: application/json; charset=UTF-8');
?>