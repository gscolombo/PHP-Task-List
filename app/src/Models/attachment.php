<?php
    class Attachment implements JsonSerializable {
        private int $id, $task_id;
        private string $name, $file;

        public function setter($property, $value) {
            switch ($property) {
                case "id":
                    $this -> id = $value;
                    break;
                case "task_id":
                    $this -> task_id = $value;
                    break;
                case "name":
                    $this -> name = $value;
                    break;
                case "file":
                    $this -> file = $value;
                    break;
            }
        }

        public function getter($property) {
            switch ($property) {
                case "id":
                    return $this -> id;
                    break;
                case "task_id":
                    return $this -> task_id;
                    break;
                case "name":
                    return $this -> name;
                    break;
                case "file":
                    return $this -> file;
                    break;
            }   
        }

        public function jsonSerialize() {
            return [
                'id' => $this -> getter('id'),
                'task_id' => $this -> getter('task_id'),
                'name' => $this -> getter('name'),
                'file' => $this -> getter('file'),
            ];
        }
    }
?>