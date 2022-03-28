<?php
    $is_invalid = false;
    $errors = [];

    header('Content-type: application/json; charset=UTF-8');

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
                    $prev_attachs = $s3 -> get_objects($file['name']);
                    set_attachment($file, $attachment, $prev_attachs);
                    $attachments[] = $attachment;
                    $s3 -> put_object($attachment -> getter("file"), $file['tmp_name']);  
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
            $id = $repo -> save($task);
            $task -> setter('id', $id["task_id"]);
            if ($task -> getter("deadline") !== "") {
                $task -> setter("deadline", set_date($task -> getter("deadline")));
            }

            $query = "SELECT COUNT(*) FROM tasks";
            $number_of_rows = $repo -> getConnection() -> query($query) -> fetchColumn();

            echo json_encode(["task" => $task, "rows" => $number_of_rows]);
        }
    }
?>