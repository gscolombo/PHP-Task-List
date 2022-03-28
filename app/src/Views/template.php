<html>
    <head>
        <title>Gerenciador de Tarefas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./public/css/style.css">
    </head>
    <body>
        <h1 class="title">Gerenciador de Tarefas</h1>
        <div class="container">
            <?php 
                require "form.php"; 
                require "tasks_table.php";
            ?>
        </div>
        <script type="module" src="./public/js/script.js"></script>
    </body>
</html>