<section class="email">
    <h1>Tarefa: <?php echo $task['name']; ?></h1>
    <p><?php echo $task['description']; ?></p>
    <p><b>Prazo: </b><?php echo set_date($task['deadline']); ?></p>
    <p><b>Prioridade: </b><?php echo set_priority($task['priority']);  ?></p>
    <p><b>Concluída? </b><?php echo $task['concluded'] ? "Sim" : "Não";  ?></p>
    <?php if (count($attachments) > 0) : ?>
        <p><strong>Essa tarefa contêm anexos! :)</strong></p>
    <?php endif; ?>
    <p>É nóis</p>
</section>