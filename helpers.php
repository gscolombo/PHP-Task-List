<?php 
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

    function set_date($date, $toDB = false){
        if ($date == '' OR $date == '0000-00-00') {
            return '';
        }

        if (!$toDB) {
            $date_obj = DateTime::createFromFormat('Y-m-d', $date);
            return $date_obj -> format('d/m/Y');
        } else {
            return $date;
        }
        
    }

    function set_concluded_state($n) {
        if ($n) {
            return 'Sim';
        } else {
            return 'Não';
        }
    }

    function set_task() {
        $task = [];

        foreach(array_keys($_POST) as $key) {
            $task[$key] = $_POST[$key];
        };

        if (array_key_exists('deadline', $task)) {
            $task['deadline'] = set_date($task['deadline'], true);
        }

        if (!array_key_exists('concluded', $task)) {
            $task['concluded'] = 0;
        } else {
            $task['concluded'] = 1;
        }

        return $task;
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

    function set_attachment($file) {
        $attachment = [
            'name' => substr($file['name'], 0, -4),
            'file' => $file['name'],
        ];
        return $attachment;
    }

    function check_attach($file) {
        $pattern = '/^.+(\.pdf|\.zip)$/';
        $match = preg_match($pattern, $file['name']);;

        if ($match) {
            move_uploaded_file($file['tmp_name'], "attachments/{$file['name']}");
            return true;
        } else {
            return false;
        }
    }

    // Carregamento do PHPMailer
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "vendor/autoload.php";
    
    function send_mail($task, $attachments = []) {
        $email = new PHPMailer();

        // Autenticação
        $email -> isSMTP();
        $email -> Host = "smtp.gmail.com";
        $email -> Port = 587;
        $email -> SMTPSecure = 'tls';
        $email -> SMTPAuth = true;
        $email -> Username = EMAIL_SENDER;
        $email -> Password = EMAIL_SENDER_PASSWORD;
        $email -> setFrom(EMAIL_SENDER, "Sistema de Notificação");

        // E-mail do destinatário
        $email -> addAddress(EMAIL_RECIPIENT);

        // Assunto do e-mail
        $email -> Subject = "Lembrete de tarefa: {$task['name']}";

        // Corpo do e-mail
        $body = set_email_body($task, $attachments);
        $email -> msgHTML($body);

        // Anexos, quando necessário
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
        // Iniciar buffer de saída e incluir template
        ob_start();
        include "template_email.php";

        // Guardar conteúdo do buffer
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
?>