<?php
    class Repository {
        private mysqli $connection;
        public function __construct($connection) {
            $this -> connection = $connection;
        }

        public function getConnection() {
            return $this -> connection;
        }

        private function getTask(Task $task) {
            $id = $task -> getter('id');
            $name = strip_tags($this -> connection -> escape_string($task -> getter('name')));
            $description = strip_tags($this -> connection -> escape_string($task -> getter('description')));
            $deadline = $task -> getter('deadline');
            $priority = $task -> getter('priority');
            $concluded = ($task -> getter('concluded')) ? 1 : 0;

            return [$name, $description, $deadline, $priority, $concluded, $id];
        }

        public function save(Task $task) {
            list($name, $description, $deadline, $priority, $concluded) = $this -> getTask($task); 

            $task_query = "INSERT INTO tasks
                (name, description, priority, deadline, concluded)
                VALUES
                (
                    '{$name}',
                    '{$description}',
                    {$priority},
                    '{$deadline}',
                    {$concluded}
                )";

            $this -> connection -> query($task_query);
            
            $attachments = $task -> getter('attachments');
            $this -> save_attachment($attachments);
        }

        public function edit(Task $task) {
            list($name, $description, $deadline, $priority, $concluded, $id) = $this -> getTask($task);

            $query = "UPDATE tasks SET
                    name = '{$name}',
                    description = '{$description}',
                    deadline = '{$deadline}',
                    priority = {$priority},
                    concluded = {$concluded}
                WHERE id = {$id}";

            $this -> connection -> query($query);

            $attachments = $task -> getter('attachments');
            $this -> save_attachment($attachments, true);
        }

        public function find(int $task_id = 0) {
            if ($task_id > 0) {
                return $this -> find_task($task_id);
            } else {
                return $this -> find_tasks();
            }
        }

        private function find_task(int $id) {
            $query = "SELECT * FROM tasks WHERE id = {$id}";
            $task = mysqli_query($this -> connection, $query) -> fetch_object('Task');

            $attach_check = $this -> check_attachments($id);
            if ($attach_check) {
                $attachments = [];
                while ($attach = $attach_check -> fetch_object('Attachment')) {
                    $attachments[] = $attach;
                }

                $task -> setter('attachments', $attachments);
            }

            return $task;
        }

        private function find_tasks() {
            $query = 'SELECT * FROM tasks';
            $query_result = mysqli_query($this -> connection, $query);

            $tasks = [];

            while ($task = mysqli_fetch_object($query_result, 'Task')) {
                $attach_check = $this -> check_attachments($task -> getter('id'));
                if ($attach_check) {
                    $attachments = [];
                    while ($attach = $attach_check -> fetch_object('Attachment')) {
                        $attachments[] = $attach;
                    }
                    $task -> setter("attachments", $attachments);
                }
                $tasks[] = $task;
            }

            return $tasks;
        }

        public function remove(int $task_id) {
            $obj_query = mysqli_query($this -> connection, "SELECT * FROM tasks WHERE id = {$task_id}");
            $task = mysqli_fetch_object($obj_query);

            $attachments = $this -> check_attachments($task_id);

            if ($attachments) {
                while ($attach = $attachments -> fetch_assoc()) {
                    mysqli_query($this -> connection, "DELETE FROM attachments WHERE id = {$attach['id']}");
                    unlink("attachments/{$attach['file']}");
                }
            }
            
            $query = "DELETE FROM tasks WHERE id = {$task_id}";
            mysqli_query($this -> connection, $query);
        }

        public function removeAll() {
            $delete_query = "DELETE FROM tasks, attachments";

            $attachments = $this -> connection -> query("SELECT * FROM attachments");
            while ($attach = $attachments -> fetch_assoc()) {
                unlink("attachments/{$attach['file']}");
            }
        }

        public function removeAttach(int $id) {
            $query = "SELECT * FROM attachments WHERE id = {$id}";
            $attachment = $this -> connection -> query($query) -> fetch_assoc();

            $this -> connection -> query("DELETE FROM attachments WHERE id = {$id}");
            unlink("attachments/{$attachment['file']}");
        }

        private function check_attachments(int $task_id) {
            $check_attach_query = "SELECT * FROM attachments WHERE task_id = {$task_id}";
            $attach_result = mysqli_query($this -> connection, $check_attach_query);

            if ($attach_result -> num_rows > 0) {
                return $attach_result;
            } else {
                return false;
            }
        }

        private function save_attachment(array $attachments, $edit = false) {
            if (count($attachments) > 0) {
                
                $edit ? $id = $_POST['id'] : $id = $this -> connection -> insert_id;

                foreach ($attachments as $attach) {
                    $attach -> setter('task_id', $id);

                    $attach_name = strip_tags($this -> connection -> escape_string($attach -> getter('name')));
                    $attach_file = strip_tags($this -> connection -> escape_string($attach -> getter('file')));

                    $attach_query = "INSERT INTO attachments
                        (task_id, name, file)
                        VALUES
                        (
                            {$attach -> getter('task_id')},
                            '{$attach_name}',
                            '{$attach_file}'
                        )
                    ";

                    $this -> connection -> query($attach_query);
                    $attach -> setter('id', $this -> connection -> insert_id);
                }   
            }
        }
    }
?>