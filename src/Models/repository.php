<?php
    class Repository {
        private PDO $connection;
        public function __construct(PDO $connection) {
            $this -> connection = $connection;
        }

        public function getConnection() {
            return $this -> connection;
        }

        private function getTask(Task $task, $with_id = false) {
            $id = $task -> getter('id');
            $name = strip_tags($task -> getter('name'));
            $description = strip_tags($task -> getter('description'));
            $deadline = $task -> getter('deadline');
            $priority = $task -> getter('priority');
            $concluded = ($task -> getter('concluded')) ? 1 : 0;

            if ($with_id) {
                return [
                    'id' => $id,
                    'name' => $name, 
                    'description' => $description, 
                    'deadline' => $deadline, 
                    'priority' => $priority, 
                    'concluded' => $concluded, 
                ];
            } else {
                return [
                    'name' => $name, 
                    'description' => $description, 
                    'deadline' => $deadline, 
                    'priority' => $priority, 
                    'concluded' => $concluded, 
                ];
            }
        }

        public function save(Task $task) {
            $sql = "INSERT INTO tasks
                (name, description, priority, deadline, concluded)
                VALUES
                (
                    :name,
                    :description,
                    :priority,
                    :deadline,
                    :concluded
                )";

            $query = $this -> connection -> prepare($sql);
            $query -> execute($this -> getTask($task));
            $last_task_id = $this -> connection -> lastInsertId();
            
            $attachments = $task -> getter('attachments');
            if ($attachments) {
                $attach_ids = $this -> save_attachment($attachments);
            } else {
                $attach_ids = [];
            }

            return ["task_id" => $last_task_id, "attach_ids" => $attach_ids];
        }

        public function edit(Task $task) {
            $sql = "UPDATE tasks SET
                    name = :name,
                    description = :description,
                    deadline = :deadline,
                    priority = :priority,
                    concluded = :concluded
                WHERE id = :id";

            $query = $this -> connection -> prepare($sql);
            $query -> execute($this -> getTask($task, true));
            
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
            $task = $this -> connection -> query($query, PDO::FETCH_CLASS, 'Task') -> fetch();

            $attachments = $this -> check_attachments($id);
            if (is_array($attachments) && count($attachments) > 0) {
                $task -> setter('attachments', $attachments);
            }

            return $task;
        }

        private function find_tasks() {
            $query = 'SELECT * FROM tasks';
            $query_result = $this -> connection -> query($query, PDO::FETCH_CLASS, 'Task');

            $tasks = [];
            
            foreach ($query_result as $task) {
                $attach_check = $this -> check_attachments($task -> getter('id'));
                if ($attach_check) {
                    $attachments = [];
                    foreach ($attach_check as $attach) {
                        $attachments[] = $attach;
                    }
                    $task -> setter("attachments", $attachments);
                }

                $tasks[] = $task;
            }

            return $tasks;
        }

        public function conclude(int $task_id) {
            $this -> connection -> query("UPDATE tasks SET concluded = 1 WHERE id = {$task_id}");
        }

        public function remove(int $task_id) {
            $this -> connection -> query("DELETE FROM tasks WHERE id = {$task_id}");

            $attachments = $this -> check_attachments($task_id);
            if (is_array($attachments) && count($attachments) > 0) {
                foreach ($attachments as $attach) {
                    $attach_query = "DELETE FROM attachments WHERE id = {$attach -> getter('id')}";
                    $this -> connection -> query($attach_query);
                    unlink("attachments/{$attach -> getter('file')}");
                }
            } 
        }

        public function removeAll() {
            $this -> connection -> query("DELETE FROM tasks");

            $attachments = $this -> connection -> query("SELECT * FROM attachments");
            while ($attach = $attachments -> fetch(PDO::FETCH_ASSOC)) {
                unlink("attachments/{$attach['file']}");
            }
            $this -> connection -> query("DELETE FROM attachments");
        }

        public function removeAttach(int $id) {
            $query = "SELECT * FROM attachments WHERE id = {$id}";
            $attachment = $this -> connection -> query($query) -> fetch(PDO::FETCH_ASSOC);

            $this -> connection -> query("DELETE FROM attachments WHERE id = {$id}");
            unlink("attachments/{$attachment['file']}");
        }

        private function check_attachments(int $task_id) {
            $check_attach_query = "SELECT * FROM attachments WHERE task_id = :task_id";
            $attach_result = $this -> connection -> prepare($check_attach_query);
            $attach_result -> execute(['task_id' => $task_id]);
            
            if ($attach_result -> rowCount() > 0) {
                $attachments = [];
                while ($attach = $attach_result -> fetchObject('Attachment')) {
                    $attachments[] = $attach;
                }
                return $attachments;
            } else {
                return false;
            }
        }

        private function save_attachment(array $attachments, $edit = false) {
            if (count($attachments) > 0) {
                
                $edit ? $id = $_POST['id'] : $id = $this -> connection -> lastInsertId();
                
                $attach_ids = [];
                foreach ($attachments as $attach) {
                    $attach -> setter('task_id', $id);

                    $data = [
                        "task_id" => $attach -> getter('task_id'),
                        "name" => strip_tags($attach -> getter('name')),
                        "file" => strip_tags($attach -> getter('file'))
                    ];
                    
                    $sql = "INSERT INTO attachments
                        (task_id, name, file)
                        VALUES
                        (
                            :task_id,
                            :name,
                            :file
                        )
                    ";

                    $query = $this -> connection -> prepare($sql);
                    $query -> execute($data);

                    $attach -> setter('id', $this -> connection -> lastInsertId());

                    $attach_ids[] = $attach -> getter("id");
                }
                
                return $attach_ids;
            }
        }
    }
?>