<html>
    <head>
        <title>Gerenciador de Tarefas</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Gerenciador de Tarefas</h1>
        <form>
            <fieldset>
                <legend>Nova tarefa</legend>
                <label class="task">
                    Tarefa:
                    <input type="text" name="name">
                </label>
                <label class="description">
                    Descrição (Opcional):
                    <textarea name="description"></textarea>
                </label>
                <label class="deadline">
                    Prazo (Opcional):
                    <input type="date" name="deadline">
                </label>
                <fieldset class="priority">
                    <legend>Prioridade:</legend>
                    <div>
                        <input required type="radio" name="priority" id="low-priority" value="1" checked> Baixa
                        <input required type="radio" name="priority" id="medium-priority" value="2"> Média
                        <input required type="radio" name="priority" id="high-priority" value="3"> Alta
                    </div>
                </fieldset>
                <label class="concluded">
                    Tarefa concluída:
                    <input type="checkbox" name="concluded" value="1">
                </label>
                <input type="submit" value="Cadastrar">
            </fieldset>
        </form>

        <table>
            <tr>
                <th>Tarefa</th>
                <th>Descrição</th>
                <th>Prazo</th>
                <th>Prioridade</th>
                <th>Concluída?</th>
            </tr>
            <?php 
                foreach ($task_list as $task) :
            ?>
                
                <tr>
                    <td><?php echo $task['name']; ?></td>
                    <td><?php echo $task['description']; ?></td>
                    <td><?php echo set_date($task['deadline']); ?></td>
                    <td><?php echo set_priority($task['priority']); ?></td>
                    <td><?php echo set_concluded_state($task['concluded']); ?></td>
                </tr>

            <?php endforeach; ?>
        </table>
    </body>
</html>