<form method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Nova tarefa</legend>
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        <label class="task">
            Tarefa:
            <?php if ($is_invalid && array_key_exists('name', $errors)) : ?>
                <span><?php echo $errors['name']; ?></span>
            <?php endif; ?>
                <input type="text" name="name" value="<?php echo $task['name']; ?>">
        </label>
        <label class="description">
            Descrição (Opcional):
            <textarea name="description"><?php echo $task['description']; ?></textarea>
        </label>
        <label class="deadline">
            Prazo (Opcional):
            <input type="date" name="deadline" value="<?php echo $task['deadline']; ?>">
        </label>
        <fieldset class="priority">
            <legend>Prioridade:</legend>
            <div>
                <input required type="radio" name="priority" id="low-priority" value="1" 
                <?php echo ($task['priority'] == 1) ? 'checked' : ''; ?>> Baixa
                <input required type="radio" name="priority" id="medium-priority" value="2"
                <?php echo ($task['priority'] == 2) ? 'checked' : ''; ?>> Média
                <input required type="radio" name="priority" id="high-priority" value="3"
                <?php echo ($task['priority'] == 3) ? 'checked' : ''; ?>> Alta
            </div>
        </fieldset>
        <label class="attachment">
            Anexos:
            <?php if ($is_invalid && array_key_exists('attachment', $errors)) : ?>
                <span><?php echo $errors['attachment']; ?></span>
            <?php endif; ?>
                <input type="file" name="attachment[]" multiple>
        </label>
        <label class="concluded">
            Tarefa concluída:
            <input type="checkbox" name="concluded" value="1"
            <?php echo ($task['concluded'] == 1) ? 'checked' : ''; ?>>
        </label>
        <label class="reminder">
            Incluir lembrete:
            <input type="checkbox" name="reminder" value="1">
        </label>
        <input type="submit" value="<?php echo ($task['id'] > 0) ? 'Atualizar' : 'Cadastrar' ?>">
        <?php if (!$show_tasks) : ?>
            <a href="tasks.php">Cancelar edição</a>
        <?php endif; ?>
    </fieldset>
</form>