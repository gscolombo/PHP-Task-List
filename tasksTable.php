<div class="table">
    <table>
        <tr>
            <th>Tarefa</th>
            <th>Descrição</th>
            <th>Prazo</th>
            <th>Prioridade</th>
            <th>Concluída?</th>
            <th>Opções</th>
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
                <td class="options">
                    <a class="edit" href="edit.php?id=<?php echo $task['id']; ?>">Visualizar e Editar</a>
                    <a class="delete" href="delete.php?id=<?php echo $task['id'] ?>">Remover</a>
                    <a class="duplicate" href="duplicate.php?id=<?php echo $task['id'] ?>">Duplicar</a>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>

    <?php if ($show_tasks && count($task_list) > 0) : ?>
        <a class="eraseAll" href="delete.php?deleteAll=true">Apagar tudo</a>
    <?php endif; ?>
</div>
