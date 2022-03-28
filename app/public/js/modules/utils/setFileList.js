async function removeFromDB(e, attach) {
    const taskAssoc = document.querySelector(`.task[id="${attach.task_id}"]`);
    const file = taskAssoc.querySelector(`.file[id="${attach.id}"]`);
    const fileList = taskAssoc.querySelector(".attachments .file-list");
    const route = location.href + `?route=delete&attachment=true&id=${attach.id}`;

    const blurRect = document.createElement("div");
    const confirmBox = document.createElement("div");
    const message = document.createElement("span");
    const confirmBtn = document.createElement("button");
    const cancelBtn = document.createElement("button");

    blurRect.classList.add("blur-rect");
    confirmBox.classList.add("confirm-box");
    message.innerText = "Tem certeza que quer deletar o anexo? \n Essa ação não poderá ser desfeita."

    confirmBtn.classList.add("confirm");
    cancelBtn.classList.add("cancel");
    confirmBtn.setAttribute("type", "button");
    cancelBtn.setAttribute("type", "button");
    confirmBtn.innerText = "Sim";
    cancelBtn.innerText = "Não";

    confirmBox.appendChild(message);
    confirmBox.appendChild(confirmBtn);
    confirmBox.appendChild(cancelBtn);

    blurRect.appendChild(confirmBox);
    document.body.insertBefore(blurRect, document.querySelector("script"));

    confirmBtn.addEventListener("click", async () => {
        const list = e.srcElement.parentElement.parentElement;
        try {
            message.innerText = "Apagando anexo...";
            confirmBtn.remove();
            cancelBtn.remove();

            const res = await fetch(route);
            const status = res.status;
            if (status !== 200) {
                const json = await res.json();
                throw json; 
            } else {
                e.srcElement.parentElement.remove();
                blurRect.remove();
                file.remove();
                if (fileList.children.length === 0) {
                    fileList.parentElement.remove();
                }
                if (list.children.length === 0) {
                    const p = document.createElement("p");
                    p.innerText = "Nenhum arquivo encontrado/adicionado";
                    list.appendChild(p);
                }
            }
        } catch (error) {
            alert("Erro na deleção de anexo! :(");
            console.error(error.message);
        }
    })

    cancelBtn.addEventListener("click", () => blurRect.remove());
}

function removeFromInput(input, deletedFile, list) {
    let newList = new DataTransfer();
    for (const file of input.files) {
        if (file !== deletedFile) {
            newList.items.add(file);
        }
    }

    input.files = newList.files;
    updateInputFiles(input, list);
}

function updateInputFiles(input, list, files) {
    if (input.files.length > 0) {
        Array.from(list.children).forEach(el => {
            if (el instanceof HTMLParagraphElement) {
                el.remove();
            }
        });

        for (const file of input.files) {
            files.items.add(file);

            const li = document.createElement("li");
            const p = document.createElement("p");
            const img = document.createElement("img");

            li.classList.add("file", "new");
            p.innerText = file.name.substr(-file.name.length, file.name.length - 4);
            img.src = "./public/img/removeBtn.svg";
            img.addEventListener("click", () => {
                removeFromInput(input, file, list);
            });

            li.appendChild(p);
            li.appendChild(img);

            list.appendChild(li);
        }

        return files;
    } else {
        if (list.children.length > 0) {
            Array.from(list.children).forEach(el => {
                if (el.classList.contains("new")) {
                    el.remove();
                    updateInputFiles(input, list);
                }
            });
        } else {
            const p = document.createElement("p");
            p.innerText = "Nenhum arquivo encontrado/adicionado";
            list.appendChild(p);
        }
    }
}

export default function setFileList(attachments, form) {
    const list = form.querySelector("ul.file-list");
    const input = form.querySelector(".attachments input");
    Array.from(list.children).forEach( child => child.remove());

    if (attachments.length > 0) {
        attachments.forEach( attach => {
            const li = document.createElement("li");
            const p = document.createElement("p");
            const img = document.createElement("img");

            li.classList.add("file", "in-db");
            if (attachments.length > 3) {
                li.classList.add("custom-scrollbar");
            }
            li.setAttribute("id", attach.id);

            p.innerText = attach.name;
            img.src = "./public/img/removeBtn.svg";

            img.addEventListener("click", e => {
                removeFromDB(e, attach);
            });

            li.appendChild(p);
            li.appendChild(img);
            
            list.appendChild(li);
        })
    } else {
        const p = document.createElement("p");
        p.innerText = "Nenhum arquivo encontrado/adicionado";
        list.appendChild(p);
    }

    const fileList = new DataTransfer();
    input.addEventListener("change", () => {
        updateInputFiles(input, list, fileList);
        input.files = fileList.files;
    });
    
}