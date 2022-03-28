<?php
    class Task implements JsonSerializable {
        private int $id, $priority;
        private string $name, $description, $deadline;
        private bool $concluded;
        private array $attachments = [];

        public function setter($property, $value) {
            if ($property === "attachments" && is_array($value)) {
                foreach ($value as $attach) {
                    $this -> addAttach($attach);
                }
            } else {
                switch ($property) {
                    case "id": 
                        $this -> id = (int) $value;
                        break;
                    case "name": 
                        $this -> name = $value;
                        break;
                    case "description": 
                        $this -> description = $value;
                        break;
                    case "deadline":
                        if ($value !== "" && $value !== "0000-00-00") {
                            $this -> deadline = $value;
                        } else {
                            $this -> deadline = "";
                        }
                        break;
                    case "priority":
                        $this -> priority = $value;
                        break;
                    case "concluded": 
                        $this -> concluded = $value;
                        break;
                }
            }
        }

        public function getter($property) {
            switch ($property) {
                case "id": 
                    return $this -> id;
                    break;
                case "name": 
                    return $this -> name;
                    break;
                case "description": 
                    return $this -> description;
                    break;
                case "deadline": 
                    return $this -> deadline;
                    break;
                case "priority": 
                    return $this -> priority;
                    break;
                case "concluded": 
                    return $this -> concluded;
                    break;
                case "attachments": 
                    return $this -> attachments;
                    break;
            }
        }

        private function addAttach(Attachment $attach) {
            array_push($this -> attachments, $attach);
        }

        public function jsonSerialize() {
            $attachments = [];
            foreach ($this -> getter('attachments') as $attach) {
                $attachments[] = $attach -> jsonSerialize();

            }

            return [
                'id' => $this -> getter('id'),
                'name' => $this -> getter('name'),
                'description' => $this -> getter('description'),
                'deadline' => $this -> getter('deadline'),
                'priority' => $this -> getter('priority'),
                'concluded' => $this -> getter('concluded'),
                'attachments' => $attachments
            ];
        }
    }

?>