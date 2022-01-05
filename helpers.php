<?php 
    function set_priority($n) {
        $priority = '';

        switch ($n) {
            case 1:
                $priority = 'Baixa';
                break;
            case 2: 
                $priority = 'Média';
                break;
            case 3:
                $priority = 'Alta';
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
?>