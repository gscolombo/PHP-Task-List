export default function setEditedTask(data) {
    const task = document.querySelector(`.task[id="${data.id}"]`);
    task.querySelector(".task-title").innerText = data.name;
    task.querySelector(".description").innerText = data.description;
    task.querySelector(".deadline").innerText = data.deadline !== "" ? "Prazo: " + data.deadline : "";
    if (data.concluded) {
        task.querySelector("img").classList.remove("unshow");
        task.querySelector("button.conclude").innerText = "Concluída";
        task.querySelector("button.conclude").classList.add("disabled");
    } else {
        task.querySelector("img").classList.add("unshow");
        task.querySelector("button.conclude").innerText = "Concluir";
        task.querySelector("button.conclude").classList.remove("disabled");
    }

    switch (data.priority) {
        case 1:
            task.classList.add("lp");
            task.classList.remove("mp");
            task.classList.remove("hp");
            break;
        case 2:
            task.classList.remove("lp");
            task.classList.add("mp");
            task.classList.remove("hp");
            break;
        case 3:
            task.classList.remove("lp");
            task.classList.remove("mp");
            task.classList.add("hp");
            break;
    }

    if (data.attachments.length > 0) {
        let ul;
        if (task.querySelector(".attachments") === null) {
            const div = document.createElement("div");
            const h2 = document.createElement("h2");
            ul = document.createElement("ul");
            
            div.classList.add("attachments");
            h2.classList.add("file-list-title");
            h2.innerText = "Anexos";
            ul.classList.add("file-list");

            div.appendChild(h2);
            div.appendChild(ul);

            task.querySelector(".details").appendChild(div);
        } else {
            ul = task.querySelector(".attachments ul");
        }

        data.attachments.forEach(attach => {
            const li = document.createElement("li");
            const p = document.createElement("p");
            const a = document.createElement("a");
            const img = document.createElement("img");
    
            li.classList.add("file");
            li.setAttribute("id", attach.id);
            p.innerText = attach.name;
            a.href = attach.file;
            img.src = "./public/img/downloadBtn.svg";
            img.classList.add("download");
    
            a.appendChild(img);
            li.appendChild(p);
            li.appendChild(a);
    
            ul.appendChild(li);
        })
    }
}