import showDetails from "./showTaskDetails.js";

function setFileList(file, list, input = Element){
    const img = document.createElement("img");
    const p = document.createElement("p");
    const li = document.createElement("li");

    p.innerText = file.name;
    img.src = "./img/removeBtn.svg";
    li.classList.add("file");
    if (file.size === undefined) li.classList.add("in-db");

    li.appendChild(p);
    li.appendChild(img);

    img.addEventListener("click", e => {
        const li = e.currentTarget.parentElement;
        if (li.classList.contains("in-db")) {
            const url = location.origin + `/TaskList/delete.php?attachment=true&id=${file.id}`;
            fetch(url)
            .then(res => {
                if (res.status !== 400) {
                    document.querySelector(`.file[id="${file.id}"]`).remove();
                    li.remove();
                }
            })
        } else {
            let newFileList = new DataTransfer();
            for (const item of input.files) {
                if (item.name !== file.name) {
                    newFileList.items.add(item);
                }
            }
            input.files = newFileList.files;
            li.remove();
        } 
    });

    list.appendChild(li);
}

function handleFileLoading(e, list){
    const input = e.currentTarget;
    const files = input.files;
    for (const file of files) {
        setFileList(file, list, input);
    }
}

function closeForm(form, div) {
    form.classList.add("hide");
    setTimeout(() =>  div.remove(), 250);
}

function resetFileList(ul, files){
    if (files.length > 0) {
        files.forEach( file => {
            const li = document.createElement("li");
            const p = document.createElement("p");
            const a = document.createElement("a");
            const img = document.createElement("img");
    
            li.classList.add("file");
            li.id = file.id;
            
            p.innerText = file.name;
            a.href = file.file;
            img.src = "./img/downloadBtn.svg";
            img.alt = "Botão de download";
    
            a.appendChild(img);
            li.appendChild(p);
            li.appendChild(a);
    
            ul.appendChild(li);
        })
    }
}

function setEditedTask(data, files = []) {
    const task = document.querySelector(`.task[id="${data.id}"]`);
    task.querySelector(".task-title").innerText = data.name;
    task.querySelector(".description").innerText = data.description;
    
    if (data.deadline !== "" && data.deadline !== "0000-00-00") {
        const dateParts = data.deadline.split("-");
        const date = "Prazo: " + dateParts[2] + "/" + dateParts[1] + "/" + dateParts[0];
        task.querySelector(".deadline").innerText = date;
    }

    const token = task.classList[1];
    switch(data.priority) {
        case "1":
            task.classList.replace(token, "lp");
            break;
        case "2":
            task.classList.replace(token, "mp");
            break;
        case "3":
            task.classList.replace(token, "hp");
            break;
    }

    const btn = task.querySelector(".options .conclude");
    if (data.concluded) {
        btn.classList.add("disabled");
        btn.innerText = "Concluída";
        task.querySelector(".task-header img").classList.remove("unshow");
    } else {
        btn.classList.remove("disabled");
        btn.innerText = "Concluir";
        task.querySelector(".task-header img").classList.add("unshow");
    }

    let ul;
    if (task.querySelector(".attachments .file-list") === null) {
        const div = document.createElement("div");
        const h2 = document.createElement("h2");
        ul = document.createElement("ul");

        div.classList.add("attachments");
        h2.classList.add("file-list-title");
        h2.innerText = "Anexos";
        ul.classList.add("file-list");

        div.appendChild(h2);
        div.appendChild(ul);

        resetFileList(ul, files);
        document.querySelector(".container .details").appendChild(div);
    } else {
        ul = task.querySelector(".attachments .file-list");
        resetFileList(ul, files);
    }
}

function checkFileList(changes) {
    if (changes.length > 0) {
        const list = changes[0].target;
        const p = list.querySelector("p");

        if (changes[0].addedNodes.length > 0 && changes[0].previousSibling === p) {
            changes[0].previousSibling.remove();
        } else if (list.childNodes.length === 0) {
            const p = document.createElement("p");
            p.innerText = "Nenhum arquivo adicionado";
            changes[0].target.appendChild(p);
        }
    }
    
}

export default function editTask(task, data) {
    const div = showDetails(task, "edit");
    const form = div.querySelector("form");
    const inputs = Array.from(form.querySelectorAll("input")).filter(el => el.id !== "attachment-edit");
    const textarea = form.querySelector("textarea");
    const priorityFields = form.querySelectorAll(".priority-box input");
    const attInput = form.querySelector(".attachments input");
    const fileList = form.querySelector(".attachments .file-list");
    const closeBtn = form.querySelector(".close-button");
    const submitBnt = form.querySelector(".submit-button");

    for (const value in data) {
        inputs.forEach( input => {
            if (input.id === value + "-edit") {
                input.value = data[value];
                input.checked = Number.parseInt(data[value]);
            }
        })

        if (value === "description") {0
            textarea.innerText = data[value];
        } else if (value === "priority") {
            priorityFields.forEach( field => {
                if (data[value] == field.value) {
                    field.checked = true;
                }
            })
        }
    }

    if (data.attachments !== undefined && data.attachments.length > 0) {
        data.attachments.forEach( file => {
            setFileList(file, fileList);
        })
    } else {
        const p = document.createElement("p");
        p.innerText = "Nenhum arquivo encontrado";
        fileList.appendChild(p);
    }

    attInput.addEventListener("input", e => {
        handleFileLoading(e, fileList);
    });

    closeBtn.addEventListener("click", () => {
        closeForm(form, div);
        observer.disconnect();
    });

    const observer = new MutationObserver(checkFileList);
    observer.observe(fileList, {childList: true});
    let mutations = observer.takeRecords();

    if (mutations) checkFileList(mutations);

    submitBnt.addEventListener("click", e => {
        e.preventDefault();
        const postData = new FormData(form);
        const url = location.origin + "/TaskList/edit.php";
        const params = {
            method: 'POST',
            header: {
                'Content-Type': 'multipart/form-data',
            },
            body: postData,
        }
        fetch(url, params)
        .then(res => {
            if (res.status !== 400) {
                closeForm(form, div);
                return res.json();
            } else {
                return res.json();
            } 
        })
        .then(json => {
            if (json.status === "success") {
                if (json.files !== undefined && json.files.length > 0) {
                    setEditedTask(json.post, json.files);
                } else {
                    setEditedTask(json.post);
                }
            } else {
                const errors = json.errors;
                for (const key in errors) {
                    const span = document.createElement("span");
                    span.innerText = errors[key];
                    inputs.forEach(input => {
                        if (input.id === key) {
                            form.insertBefore(span, input);
                        }
                    })
                }
            }
            
        })
    })

    document.body.insertBefore(div, document.querySelector("script"));
}