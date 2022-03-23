import setEditedTask from "../utils/setEditedTask.js";
import setFileList from "../utils/setFileList.js";
import setLoadingBox from "../utils/setLoadingBox.js";

export default async function editTask(url) {
    const loadingBox = setLoadingBox("Carregando dados da tarefa...");

    const res = await fetch(url);
    const task = await res.json();

    loadingBox.remove();

    const blurRect = document.createElement("div");
    const form = document.querySelector("form").cloneNode(true);
    const closeBtn = document.createElement("button");
    const closeSign = document.createElement("img");

    const labels = Array.from(form.querySelectorAll("label")).filter(el => ! el.classList.contains("priority"));
    const inputs = Array.from(form.querySelectorAll("input"));
    inputs.push(form.querySelector("textarea[name='description']"));

    const submitBnt = form.querySelector("button.save");

    blurRect.classList.add("blur-rect");
    form.classList.replace("save", "edit");
    form.querySelector(".list-sign").remove();

    closeBtn.setAttribute("type", "button");
    closeBtn.classList.add("close-button");
    closeBtn.addEventListener("click", () => {
        form.classList.add("hide");
        setTimeout(() => {
            blurRect.remove();
        }, 250);
    });
    closeSign.src = "./public/img/removeBtnWhite.svg";
    closeBtn.appendChild(closeSign);

    form.prepend(closeBtn);

    inputs.forEach((input, i) => {
        input.id += "-edit";
        if (labels[i] !== undefined) {
            labels[i].setAttribute("for", input.id);
        }
        switch (input.name) {
            case "id":
                input.value = task.id;
                break;
            case "name":
                input.value = task.name;
                break;
            case "description":
                input.value = task.description;
                break;
            case "deadline":
                input.value = task.deadline;
                break;
            case "priority":
                if (input.id === "low-priority-edit" && task.priority === 1) {
                    input.checked = true;
                } else if (input.id === "medium-priority-edit" && task.priority === 2) {
                    input.checked = true;
                } else if (input.id === "high-priority-edit" && task.priority === 3) {
                    input.checked = true;
                }
                break;
            case "concluded":
                if (task.concluded) {
                    input.checked = true;
                }
                break;
            case "attachment[]":
                setFileList(task.attachments, form);
        }
    })

    blurRect.append(form);
    document.body.insertBefore(blurRect, document.querySelector("script"));

    submitBnt.addEventListener("click", e => {
        e.preventDefault();
        const postData = new FormData(form);
        const url = location.href + `?route=edit`;
        const params = {
            method: 'POST',
            header: {
                'Content-Type': 'multipart/form-data',
            },
            body: postData,
        }

        const loadingBox = setLoadingBox("Salvando mudanças...");

        fetch(url, params)
        .then(res => {
            if (res.status !== 400) {
                loadingBox.remove();
                form.classList.add("hide");
                setTimeout(() => {
                    blurRect.remove();
                }, 250);
                return res.json();
            } else {
                return res.json();
            } 
        })
        .then(json => {
            if (json.status === "success") {
                setEditedTask(json.data);
            } else {
                const errors = json.errors;
                for (const key in errors) {
                    const span = document.createElement("span");
                    span.innerText = errors[key];
                    inputs.forEach(input => {
                        if (input.name === key) {
                            form.insertBefore(span, input);
                        }
                    })
                }
            }
        })
    })
}