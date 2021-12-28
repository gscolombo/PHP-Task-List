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

    function set_date($date){
        if ($date == '') {
            return "";
        }

        $date_obj = DateTime::createFromFormat('Y-m-d', $date);
        return $date_obj -> format('d/m/Y');
    }

    function set_concluded_state($n) {
        if ($n) {
            return 'Sim';
        } else {
            return 'Não';
        }
    }
?>