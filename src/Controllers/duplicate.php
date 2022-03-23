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
    
            $index = set_attach_index($attach_name, $attach_format);

            $src_name = $attach -> getter("file");
            $dest_name = $attach_name . $index . $attach_format;

            $attach -> setter("name", substr($dest_name, 0, -4));
            $attach -> setter("file", $dest_name);

            $src_path = ROOT_DIR_PATH . "/attachments/" . $src_name;
            $dest_path = ROOT_DIR_PATH . "/attachments/" . $dest_name;
            
            copy($src_path, $dest_path);
        }
    }

    $json = $repo -> save($task);
    $query = "SELECT COUNT(*) FROM tasks";
    $number_of_rows = $repo -> getConnection() -> query($query) -> fetchColumn();

    $json["rows"] = $number_of_rows;
    
    echo json_encode($json);
?>