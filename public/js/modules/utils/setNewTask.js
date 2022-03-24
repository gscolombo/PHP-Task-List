import databaseFetch from "../db/databaseFetch.js";
import showDetails from "./showTaskDetails.js";

export default function setNewTask(task) {
    const div = document.createElement("div");
    const header = document.createElement("div");
    const title = document.createElement("h2");
    const img = document.createElement("img");
    const details = document.createElement("div");
    const deadline = document.createElement("p");
    const description = document.createElement("p");
    const options = document.createElement("div");
    const attachments = document.createElement("div");
    const listTitle = document.createElement("h2");
    const list = document.createElement("ul");
    
    let buttons = [];
    for(let i = 0; i < 5; i++) {
        const button = document.createElement("button");
        button.setAttribute("type", "button");

        switch(i) {
            case 0:
                button.classList.add("conclude");
                button.innerText = "Concluir";
                button.addEventListener("click", e => databaseFetch(e, "conclude"));
                break;
            case 1:
                button.classList.add("edit");
                button.innerText = "Editar";
                button.addEventListener("click", e => databaseFetch(e, "edit"));
                break;
            case 2:
                button.classList.add("delete");
                button.innerText = "Remover";
                button.addEventListener("click", e => databaseFetch(e, "delete"));
                break;
            case 3:
                button.classList.add("duplicate");
                button.innerText = "Duplicar";
                button.addEventListener("click", e => databaseFetch(e, "duplicate"));
                break;
            case 4:
                button.classList.add("show-details");
                button.innerText = "Ver detalhes";
                button.addEventListener("click", () => {
                    showDetails(div);
                });
                break;
        }

        buttons.push(button);
    }
    
    div.setAttribute("id", task.id);
    div.classList.add("task");
    switch (task.priority) {
        case 1:
            div.classList.add("lp");
            break;
        case 2:
            div.classList.add("mp");
            break;
        case 3:
            div.classList.add("hp");
            break;
    }

    header.classList.add("task-header");
    title.classList.add("task-title");
    title.innerText = task.name;
    img.classList.add("unshow");
    img.src = "./public/img/conclusionSym.svg";
    header.appendChild(title);
    header.appendChild(img);

    details.classList.add("details", "unshow");
    deadline.classList.add("deadline");
    if (task.deadline !== "") deadline.innerText = "Prazo: " + task.deadline;
    description.classList.add("description");
    description.innerText = task.description;
    details.appendChild(deadline);
    details.appendChild(description);

    options.classList.add("options");
    buttons.forEach(btn => options.appendChild(btn));

    attachments.classList.add("attachments");
    listTitle.classList.add("file-list-title");
    listTitle.innerText = "Anexos";
    list.classList.add("file-list")

    if (task.attachments.length > 0) {
        task.attachments.forEach(attach => {
            const li = document.createElement("li");
            const p = document.createElement("p");
            const a = document.createElement("a");
            const img = document.createElement("img");
            
            li.setAttribute("id", attach.id);
            li.classList.add("file");
    
            p.innerText = attach.name;
            a.href = "../attachments/" + attach.file;
            img.src = "./public/img/downloadBtn.svg";
    
            a.appendChild(img);
            li.appendChild(p);
            li.appendChild(a);
    
            list.appendChild(li);
        })
    
        attachments.appendChild(listTitle);
        attachments.appendChild(list);
    
        details.appendChild(attachments);
    }
    
    div.appendChild(header);
    div.appendChild(details);
    div.appendChild(options);

    return div;
}