<html>
    <head>
        <title>Gerenciador de Tarefas</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Gerenciador de Tarefas</h1>
        <div class="container">
            <?php require "form.php"; ?>

            <?php if ($show_tasks) : ?>
                <?php require "tasksTable.php"; ?>
            <?php else: ?>
                <section class="view">
                    <h2><?php echo $task['name']; ?></h2>
                    <p><?php echo $task['description']; ?></p>
                    <p><b>Prazo: </b><?php echo set_date($task['deadline']); ?></p>
                    <p><b>Prioridade: </b><?php echo set_priority($task['priority']);  ?></p>
                    <p><b>Concluída? </b><?php echo set_concluded_state($task['concluded']);  ?></p>
                    <?php if (count($attachments) > 0) : ?>
                        <div class="attachments">
                            <h3>Anexos</h3>
                            <ul>
                                <?php foreach ($attachments as $attachment) : ?>
                                    <li><?php echo $attachment['name']; ?>
                                    </li>
                                    <a href="attachments\<?php echo $attachment['file']; ?>">Baixar</a>
                                    <a href="delete.php?attachment=true&id=<?php echo $attachment['id']; ?>">Deletar</a>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>
        </div>
        
    </body>
</html>