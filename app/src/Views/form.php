<form class="save" method="post" enctype="multipart/form-data">
    <fieldset>
        <input id="id" type="hidden" name="id">
        <legend class="form-title">Nova tarefa</legend>
        <label class="task-name">*Tarefa:</label>
        <?php if (isset($is_invalid, $errors) && array_key_exists('name', $errors)) : ?>
            <span><?php echo $errors['name']; ?></span>
        <?php endif; ?>
            <input id="name" type="text" name="name">
        <label class="description">Descrição:</label>
        <textarea id="description" name="description"></textarea>
        <div class="deadline-and-priority">
            <div class="deadline-box">
                <label class="deadline">Prazo:</label>
                <input id="deadline" type="date" name="deadline" placeholder="dd/mm/aaaa">
            </div>
            <div class="priority-box">
            <label class="priority">Prioridade:</label>
                <div class="priority-options">
                    <input required type="radio" name="priority" id="low-priority" value="1" checked>
                    <label for="low-priority">Baixa</label>
                    <input required type="radio" name="priority" id="medium-priority" value="2">
                    <label for="medium-priority">Média</label>
                    <input required type="radio" name="priority" id="high-priority" value="3">
                    <label for="high-priority">Alta</label>
                </div>
            </div>
        </div>
        
        <div class="attachments">
            <label for="attachment" class="attachment">Anexar arquivos</label>
            <?php if (isset($is_invalid, $errors) && array_key_exists('attachment', $errors)) : ?>
                <span><?php echo $errors['attachment']; ?></span>
            <?php endif; ?>
                <input type="file" id="attachment" name="attachment[]" multiple>
            
            <h2 class="file-list-title">Anexos</h2>
            <ul class="file-list custom-scrollbar">
            </ul>
        </div>
        

        <div class="concluded-and-reminder">
            <input type="checkbox" id="concluded" name="concluded" value="1">
            <label for="concluded" class="concluded">Tarefa concluída</label>
            <input type="checkbox" id="reminder" name="reminder" value="1">
            <label for="reminder" class="reminder">Incluir lembrete</label>
        </div>
        
        <button class="save" type="button">Salvar<butto>
    </fieldset>
    <div class="list-sign">
        <h3>Lista de tarefas</h3>
        <img src="./public/img/arrows.svg">
    </div>
</form>