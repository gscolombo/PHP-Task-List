<html>
    <head>
        <title>Gerenciador de Tarefas</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Gerenciador de Tarefas</h1>
        <?php require "form.php"; ?>

        <?php if ($show_tasks) : ?>
            <?php require "tasksTable.php"; ?>
        <?php endif; ?>
        
        <?php if ($show_tasks && count($task_list) > 0) : ?>
            <a href="delete.php?deleteAll=true">Apagar tudo</a>
        <?php endif; ?>
    </body>
</html>