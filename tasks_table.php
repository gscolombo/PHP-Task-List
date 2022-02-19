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
            <div class="task <?php echo set_priority($task['priority']) ?>">
                <h2 class="task-title"><?php echo $task['name']; ?></h2>
                <div class="details unshow">
                    <p class="deadline">Prazo: <?php echo set_date($task['deadline']); ?></p>
                    <p class="description"><?php echo $task['description']; ?></p>
                    <?php 
                        $attachments = find_attachments($connection, $task['id']);
                        if (count($attachments) > 0) : 
                    ?>
                    <div class="attachments">
                        <h2 class="file-list-title">Anexos</h2>
                        <ul class="file-list">
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
                    <a class="conclude <?php echo $task['concluded'] ? "disabled" : ""; ?>" href="">
                        <?php 
                            echo $task['concluded'] ? "Concluída" : "Concluir";
                        ?>
                    </a>
                    <a class="edit" href="edit.php?id=<?php echo $task['id']; ?>">Editar</a>
                    <a class="delete" href="delete.php?id=<?php echo $task['id'] ?>">Remover</a>
                    <a class="duplicate" href="duplicate.php?id=<?php echo $task['id'] ?>">Duplicar</a>
                    <button type="button">Ver detalhes</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($show_tasks && count($task_list) > 0) : ?>
        <a class="eraseAll" href="delete.php?deleteAll=true">Apagar tudo</a>
    <?php endif; ?>
    <div class="form-sign">
        <img src="./img/arrows.svg">
        <h3>Formulário</h3>
    </div>
</div>
