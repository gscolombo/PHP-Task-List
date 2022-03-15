<?php 
    require "config.php";
    require 'db.php';
    require 'helpers.php';
    require 'src/Controller/task.php';
    require 'src/Controller/attachment.php';

    $show_tasks = true;
    $is_invalid = false;
    $errors = [];

    if (has_data_task()) {
        if (array_key_exists('name', $_POST) && $_POST['name'] === '') {
            $is_invalid = true;
            $errors['name'] = 'O título da tarefa é obrigatório!';
        };

        $task = new Task();
        set_task($task);

        // Upload de anexos
        $has_file = false;
        foreach ($_FILES['attachment']['name'] as $file) {
            if ($file !== "") {
                $has_file = true;
            }
        }

        if ($has_file) {
            $files = rearrange_files('attachment');

            foreach ($files['attachment'] as $file) {
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
            $repo -> save($task);
            header('Location: tasks.php');
            die();
        }
    }

    $task_list = $repo -> find();
    require "template.php";
?>