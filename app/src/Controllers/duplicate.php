<?php
    $task = $repo -> find($_GET['id']);

    $attachments = $task -> getter("attachments");
    if (count($attachments) > 0) {
        foreach($attachments as $attach) {
            $pattern = '/(^.+)\(\d+\)$/';
            $matches = [];
            preg_match($pattern, $attach -> getter("name"), $matches);
            if (count($matches) > 0) {
                $attach_name = $matches[1];
            } else {
                $attach_name = $attach -> getter("name");
            }
            $attach_format = substr($attach -> getter("file"), -4);
            
            $prev_attachs = $s3 -> get_objects($attach_name);
            $index = set_attach_index($attach_name, $attach_format, $prev_attachs);

            $src_name = $attach -> getter("file");
            $dest_name = $attach_name . $index . $attach_format;

            $attach -> setter("name", substr($dest_name, 0, -4));
            $attach -> setter("file", $dest_name);

            $src_object = $s3 -> get_object($src_name);
            $s3 -> put_object($dest_name, $src_object['Body'], true);
        }
    }

    $json = $repo -> save($task);

    $query = "SELECT COUNT(*) FROM tasks";
    $number_of_rows = $repo -> getConnection() -> query($query) -> fetchColumn();
    $json["rows"] = $number_of_rows;
    
    echo json_encode($json);
?>