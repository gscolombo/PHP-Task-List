function setEditForm() {
    const inputs = document.querySelectorAll("form input, form textarea");
    const form = document.createElement("form");
    const legend = document.createElement("legend");
    const closeBtn = document.createElement("btn");
    const img = document.createElement("img");
    const fieldset = document.createElement("fieldset");
    const priorityDiv = document.createElement("div");

    legend.classList.add("form-title");
    legend.innerText = "Edição de tarefa";

    closeBtn.classList.add("close-button");
    img.src = "./img/removeBtnWhite.svg";
    closeBtn.appendChild(img);

    fieldset.classList.add("deadline-and-priority");
    priorityDiv.classList.add("priority-box"); 
    
    form.appendChild(legend);
    form.appendChild(closeBtn);
    form.classList.add("edit-form");
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");

    inputs.forEach( input => {
        const clone = input.cloneNode();
        clone.id += "-edit";
        if (clone.name === "priority") {
            const label = document.createElement("label");
            label.setAttribute("for", clone.id);
            switch (input.id) {
                case "low-priority":
                    label.innerText = "Baixa";
                    break;
                case "medium-priority":
                    label.innerText = "Média";
                    break;
                case "high-priority":
                    label.innerText = "Alta";
                    break;
            }
            priorityDiv.appendChild(clone);
            priorityDiv.appendChild(label);
        } else {
            const div = document.createElement("div");
            const label = document.createElement("label");
            if (clone.type === "submit") {
                clone.value = "Atualizar";
                form.appendChild(clone);
            } else if (clone.name === "concluded") {
                div.classList.add("concluded-box");
                label.innerText = "Concluir tarefa";
                label.setAttribute("for", clone.id);
                div.appendChild(clone);
                div.appendChild(label);
                form.appendChild(div);
            } else if (clone.name === "reminder") {
                div.classList.add("reminder-box");
                label.innerText = "Incluir lembrete";
                label.setAttribute("for", clone.id);
                div.appendChild(clone);
                div.appendChild(label);
                form.appendChild(div);
            } else if (clone.id === "attachment-edit") {
                clone.name = "attachment-edit[]";

                const attachmentsContainer = document.createElement("div");
                const attachmentLabel = document.createElement("label");
                const fileListTitle = document.createElement("h2");
                const fileList = document.createElement("ul");
                
                attachmentsContainer.classList.add("attachments");
                attachmentLabel.setAttribute("for", clone.id);
                attachmentLabel.classList.add("attachment-label");
                attachmentLabel.innerText = "Carregar arquivos";

                fileListTitle.classList.add("file-list-title");
                fileListTitle.innerText = "Anexos";
                fileList.classList.add("file-list", "custom-scrollbar");

                attachmentsContainer.appendChild(attachmentLabel);
                attachmentsContainer.appendChild(clone);
                attachmentsContainer.appendChild(fileListTitle);
                attachmentsContainer.appendChild(fileList);
                
                form.appendChild(attachmentsContainer);
            } else {
                form.appendChild(clone);
            } 
        }
    });
    form.insertBefore(priorityDiv, form.querySelector(".attachments"));
    return form;
}

export default function showDetails(task, type = "view") {
    const blurRect = document.createElement("div");
    blurRect.classList.add("blur-rect");
    
    if (type === "view") {
        const taskClone = task.cloneNode(true);
        const btnClone = taskClone.querySelector("button.details-btn");
    
        taskClone.classList.add("show-details");
        taskClone.querySelector(".details").classList.remove("unshow");
        btnClone.innerText = "Voltar";
    
        btnClone.addEventListener("click", () => {
            taskClone.classList.replace("show-details", "unshow-details");
            setTimeout(() => {
                blurRect.removeChild(taskClone);
                blurRect.remove();
            }, 250)  
        });

        blurRect.append(taskClone);
        document.body.insertBefore(blurRect, document.querySelector("script"));
    } else {
        blurRect.append(setEditForm());
        return blurRect;
    }
}