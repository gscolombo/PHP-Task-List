<html>
    <head>
        <title>Gerenciador de Tarefas</title>
    </head>
    <body>
    <style>

        * {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 40%;
        }

        form legend {
            background-color: black;
            color: white;
            padding: 5px 10px;
            margin-bottom: 5px;
        }
        
        fieldset {
            display: flex;
            flex-direction: column;
        }

        fieldset label input {
            min-width: 100%;
            margin-top: 2.5px;
        }

        fieldset input[type='submit'] {
            align-self: flex-end;
            max-width: fit-content;
            padding: 5px;
            margin-top: 5px;
        }

        table th {
            background-color: lightgrey;
            padding: 5px;
            border: 2px solid black;
            text-transform: uppercase;
        }

        table td {
            padding: 10px 5px 0 5px;
            border-bottom: 1px solid black;
            display: flex;
            align-items: center;
        }

        table td::before {
            content: '';
            display: block;
            width: 0;
            float: left;
            border-top: 5px solid white;
            border-left: 5px solid black;
            border-bottom: 5px solid white;
            margin-right: 5px;
        }
    </style>

        <h1>Gerenciador de Tarefas</h1>
        <form>
            <fieldset>
                <legend>Nova tarefa</legend>
                <label>
                    Tarefa:
                    <input type="text" name="task">
                </label>
                <input type="submit" value="Cadastrar">
            </fieldset>
        </form>
        <?php

            if (array_key_exists('task', $_GET)) {
                setcookie('task_' . (count($_COOKIE) + 1), $_GET['task']);
            }
            
        ?>

        <table>
            <tr>
                <th>Tarefas</th>
            </tr>
            <?php foreach ($_COOKIE  as $task) :?>
                
                <tr>
                    <td><?php echo $task; ?></td>
                </tr>

            <?php endforeach; ?>
        </table>
    </body>
</html>