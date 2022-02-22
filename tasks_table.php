<div class="list-container">
    <div class="legend">
        <span>Prioridade:</span>
        <div class="grade">
            <svg class="lp" width="10px" height="10px" xlmns="http://www.w3.org/2000/svg">
                <rect width="10px" height="10px">
            </svg>
            <span>Baixa</span>
        </div>
        <div class="grade">
            <svg class="mp" width="10px" height="10px" xlmns="http://www.w3.org/2000/svg">
                <rect width="10px" height="10px">
            </svg>
            <span>Média</span>
        </div>
        <div class="grade">
            <svg class="hp" width="10px" height="10px" xlmns="http://www.w3.org/2000/svg">
                <rect width="10px" height="10px">
            </svg>
            <span>Alta</span>
        </div>
    </div>
    <div class="list">
        <?php foreach($task_list as $task) : ?>
            <div id=<?php echo $task['id']; ?> class="task <?php echo set_priority($task['priority']) ?>">
                <div class="task-header">
                    <h2 class="task-title"><?php echo $task['name']; ?></h2>
                    <img class="<?php echo $task['concluded'] ? "" : "unshow" ?>" src="./img/conclusionSym.svg">
                </div>
                <div class="details unshow">
                    <p class="deadline">
                        <?php echo $task['deadline'] !== "" && $task['deadline'] !== "0000-00-00" ?
                            "Prazo: " . set_date($task['deadline']) : "";
                        ?>
                    </p>
                    <p class="description"><?php echo $task['description']; ?></p>
                    <?php 
                        $attachments = find_attachments($connection, $task['id']);
                        if (count($attachments) > 0) : 
                    ?>
                    <div class="attachments">
                        <h2 class="file-list-title">Anexos</h2>
                        <ul class="file-list <?php echo count($attachments) > 3 ? "custom-scrollbar" : ""; ?>">
                            <?php 
                                foreach($attachments as $attachment) :
                            ?>
                            <li class="file">
                                <p><?php echo $attachment['name']; ?></p>
                                <a href="attachments/<?php echo $attachment['file'] ?>">
                                    <img src="./img/downloadBtn.svg" alt="Botão de download">
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="options">
                    <button type="button" class="conclude <?php echo $task['concluded'] ? "disabled" : ""; ?>">
                        <?php 
                            echo $task['concluded'] ? "Concluída" : "Concluir";
                        ?>
                    </button>
                    <a class="edit" href="edit.php?id=<?php echo $task['id']; ?>">Editar</a>
                    <button class="delete">Remover</button>
                    <a class="duplicate" href="duplicate.php?id=<?php echo $task['id'] ?>">Duplicar</a>
                    <button type="button" class="details-btn">Ver detalhes</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (count($task_list) > 5) : ?>
        <div class="arrow-down">
            <img src="./img/downArrow.svg">
        </div>
    <?php endif; ?>

    <?php if ($show_tasks && count($task_list) > 0) : ?>
        <a class="eraseAll" href="delete.php?deleteAll=true">Apagar tudo</a>
    <?php endif; ?>
    <div class="form-sign">
        <img src="./img/arrows.svg">
        <h3>Formulário</h3>
    </div>
</div>
