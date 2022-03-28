<div class="list-container">
    <div class="wrapper <?php echo (count($task_list) > 0) ? "" : "unshow"; ?>">
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
                <div id=<?php echo $task -> getter('id'); ?> class="task <?php echo set_priority($task -> getter('priority')) ?>">
                    <div class="task-header">
                        <h2 class="task-title"><?php echo htmlentities($task -> getter('name')); ?></h2>
                        <img class="<?php echo $task -> getter('concluded') ? "" : "unshow" ?>" src="./public/img/conclusionSym.svg">
                    </div>
                    <div class="details unshow">
                        <p class="deadline">
                            <?php echo $task -> getter('deadline') !== "" && $task -> getter('deadline') !== "0000-00-00" ?
                                "Prazo: " . set_date($task -> getter('deadline')) : "";
                            ?>
                        </p>
                        <p class="description"><?php echo nl2br(htmlentities($task -> getter('description'))); ?></p>
                        <?php 
                            $attachments = $task -> getter('attachments');
                            if (count($attachments) > 0) : 
                        ?>
                        <div class="attachments">
                            <h2 class="file-list-title">Anexos</h2>
                            <ul class="file-list <?php echo count($attachments) > 3 ? "custom-scrollbar" : ""; ?>">
                                <?php 
                                    foreach($attachments as $attachment) :
                                ?>
                                <li class="file" id="<?php echo $attachment -> getter('id')?>">
                                    <p><?php echo htmlentities($attachment -> getter('name')); ?></p>
                                    <a id="<?php echo $attachment -> getter('file'); ?>">
                                        <img class="download" src="./public/img/downloadBtn.svg" alt="Botão de download">
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="options">
                        <button type="button" class="conclude <?php echo $task -> getter('concluded') ? "disabled" : ""; ?>">
                            <?php 
                                echo $task -> getter('concluded') ? "Concluída" : "Concluir";
                            ?>
                        </button>
                        <button type="button"  class="edit">Editar</button>
                        <button type="button"  class="delete">Remover</button>
                        <button type="button"  class="duplicate">Duplicar</button>
                        <button type="button" class="show-details">Ver detalhes</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="eraseAll <?php echo (count($task_list) > 0) ? "" : "unshow"; ?>" type="button">Apagar tudo</button>
    </div>
    <h2 class="message <?php echo (count($task_list) > 0) ? "unshow" : ""; ?>">Nenhuma tarefa adicionada</h2>
    
    <div class="arrow-down <?php echo count($task_list) > 5 ? "" : "unshow"; ?>">
        <img src="./public/img/downArrow.svg">
    </div>

    <div class="form-sign">
        <img src="./public/img/arrows.svg">
        <h3>Formulário</h3>
    </div>
</div>
