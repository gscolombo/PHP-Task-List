import editTask from "./editTask.js";
import duplicateTask from "./duplicateTask.js";

export default function databaseFetch(e, type) {
    const btn = e.currentTarget;
    const task = e.path[2];
    const id = task.id;

    let url;
    switch (type) {
        case "conclude":
            url = window.location.origin + `/TaskList/conclude.php?id=${id}`;
            break;
        case "delete":
            url = window.location.origin + `/TaskList/delete.php?id=${id}`;
            break;
        case "duplicate":
            url = window.location.origin + `/TaskList/duplicate.php?id=${id}`;
            break;
        case "edit":
            url = window.location.origin + `/TaskList/edit.php?id=${id}`;
            break;
    }

    if (url !== "") {
        fetch(url)
        .then(res => {
            if (res.status === 200) {
                switch (type) {
                    case "conclude" :
                        task.querySelector(".task-header img").classList.remove("unshow");
                        btn.classList.add("disabled");
                        btn.innerText = "Concluída";
                        break;
                    case "delete" :
                        task.remove();
                        break;
                    case "duplicate":
                    case "edit":
                        return res.json();
                }
            }
        })
        .then( json => {
            if (type === "duplicate") {
                duplicateTask(task, json);
            } else if (type === "edit") {
                editTask(task, json);
            }
        })
    }
}