<?php 
    require "config.php";
    require 'db.php';
    require 'helpers.php';

    $show_tasks = true;
    $is_invalid = false;
    $errors = [];

    if (has_data_task()) {
        $task = set_task();

        if (array_key_exists('name', $_POST) && $_POST['name'] != '') {
            $task['name'] = $_POST['name'];
        } else {
            $is_invalid = true;
            $errors['name'] = 'O título da tarefa é obrigatório!';
        };

        // Upload de anexos
        $has_file = false;
        foreach ($_FILES['attachment']['name'] as $file) {
            if ($file !== "") {
                $has_file = true;
            }
        }

        if ($has_file) {
            $files = [];
            $files = rearrange_files('attachment');

            foreach ($files['attachment'] as $file) {
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
            save_task($connection, $task);
            $has_attachments = isset($attachments) && is_array($attachments);

            if (array_key_exists('reminder', $_POST) && $_POST['reminder'] == 1) {
                $has_attachments ? send_mail($task, $attachments) : send_mail($task);
            }

            if ($has_attachments) {
                $id = mysqli_insert_id($connection);
                foreach($attachments as $attachment) {
                    $attachment['task_id'] = $id;
                    save_attachment($connection, $attachment);
                }
            }

            header('Location: tasks.php');
            die();
        }
    }
    
    if (!isset($task)) {
        $task = [
            'id' => 0,
            'name' => array_key_exists('name', $_POST) ? $_POST['name'] : '',
            'description' => array_key_exists('description', $_POST) ? $_POST['description'] : '',
            'deadline' => array_key_exists('deadline', $_POST) ? $_POST['deadline'] : '',
            'priority' => array_key_exists('priority', $_POST) ? $_POST['priority'] : '',
            'concluded' => array_key_exists('concluded', $_POST) ? $_POST['concluded'] : '',
        ];
    }

    $task_list = find_tasks($connection);
    require "template.php";
?>