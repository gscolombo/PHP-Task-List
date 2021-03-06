<?php
    require "../vendor/autoload.php";

    function set_priority($n) {
        $priority = '';

        switch ($n) {
            case 1:
                $priority = 'lp';
                break;
            case 2: 
                $priority = 'mp';
                break;
            case 3:
                $priority = 'hp';
                break;            
        }

        return $priority;
    }

    function set_date($date){
        $date_obj = DateTime::createFromFormat('Y-m-d', $date);
        return $date_obj -> format('d/m/Y');
    }

    function set_task(Task $task) {
        foreach(array_keys($_POST) as $key) {
            $task -> setter($key, $_POST[$key]);
        };

        if (!array_key_exists('concluded', $_POST)) {
            $task -> setter('concluded', 0);
        }
    }

    function has_data_task() {
        if (count($_POST) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function rearrange_files($name) {
        $files = [];

        for ($i = 0; $i < count($_FILES[$name]['name']); $i++) {
            $files[$name][$i] = [
                'name' => $_FILES[$name]['name'][$i],
                'full_path' => $_FILES[$name]['full_path'][$i],
                'type' => $_FILES[$name]['type'][$i],
                'tmp_name' => $_FILES[$name]['tmp_name'][$i],
                'error' => $_FILES[$name]['error'][$i],
                'size' => $_FILES[$name]['size'][$i],
            ];
        }

        return $files;
    }

    function set_attach_index($file_name, $file_format, object $objects) {
        for ($i = 0; $i <= count($objects['Contents']); $i++) {
            $n = $i === 0 ? "" : "({$i})";
            $new_file_name = $file_name . $n . $file_format;
            
            if (!array_key_exists($i, $objects['Contents'])) {
                return $n;
            } else {
                $key = $objects['Contents'][$i]['Key'];
                if ($new_file_name !== $key) {
                    return $n;
                }
            }
        }        
    }

    function set_attachment(array $file, Attachment $attachment, $objects) {
        $file_name = substr($file['name'], 0, -4);
        $file_format = substr($file['name'], -4);

        $index = "";
        if ($objects) {
            $index = set_attach_index($file_name, $file_format, $objects);
        }
        $new_file_name = $file_name . $index . $file_format;

        $attachment -> setter('name', $file_name . $index);
        $attachment -> setter('file', $new_file_name);
    }

    function check_attach($file) {
        $pattern = '/^.+(\.pdf|\.zip)$/';
        $match = preg_match($pattern, $file['name']);;

        if ($match) {
            return true;
        } else {
            return false;
        }
    }

    // Carregamento do PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    function send_mail($task, $attachments = []) {
        $email = new PHPMailer();

        // Autentica????o
        $email -> isSMTP();
        $email -> Host = "smtp.gmail.com";
        $email -> Port = 587;
        $email -> SMTPSecure = 'tls';
        $email -> SMTPAuth = true;
        $email -> Username = EMAIL_SENDER;
        $email -> Password = EMAIL_SENDER_PASSWORD;
        $email -> setFrom(EMAIL_SENDER, "Sistema de Notifica????o");

        // E-mail do destinat??rio
        $email -> addAddress(EMAIL_RECIPIENT);

        // Assunto do e-mail
        $email -> Subject = "Lembrete de tarefa: {$task['name']}";

        // Corpo do e-mail
        $body = set_email_body($task, $attachments);
        $email -> msgHTML($body);

        // Anexos, quando necess??rio
        foreach ($attachments as $attachment) {
            $email -> addAttachment("attachments/{$attachment['file']}");
        }
        // Envio do e-mail
        if (! $email -> send()) {
            $errorMessage = "Falha no envio de e-mail: {$email -> ErrorInfo}";
            record_log($errorMessage);
        }
    }
    
    function set_email_body($task, $attachments) {
        // Iniciar buffer de sa??da e incluir template
        ob_start();
        include "template_email.php";

        // Guardar conte??do do buffer
        $body = ob_get_contents();

        // Limpar e parar buffer
        ob_end_clean();

        return $body;
    }

    function record_log($message) {
        $datetime = date("Y-m-d H:i:s");
        $log = "{$datetime} {$message}\n";
        
        file_put_contents("messages.log", $log, FILE_APPEND);
    }

    function filter_route($key) {
        if ($key !== "route") {
            return $key;
        }
    }
?>