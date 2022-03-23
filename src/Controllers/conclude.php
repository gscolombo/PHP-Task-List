<?php
    if (array_key_exists("id", $_GET) && $_GET['id'] !== "") {
        $repo -> conclude($_GET['id']);  
    }
?>