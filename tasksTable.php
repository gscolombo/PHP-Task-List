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
            <td>
                <a href="edit.php?id=<?php echo $task['id']; ?>">Editar</a>
                <a href="delete.php?id=<?php echo $task['id'] ?>">Remover</a>
                <a href="duplicate.php?id=<?php echo $task['id'] ?>">Duplicar</a>
            </td>
        </tr>

    <?php endforeach; ?>
</table>