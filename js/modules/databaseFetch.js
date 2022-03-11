import editTask from "./editTask.js";
import duplicateTask from "./duplicateTask.js";
import handleTaskList from "./handleTaskList.js";

export default function databaseFetch(e, type) {
    const btn = e.currentTarget;
    const task = e.path[2];
    const id = task.id;

    let url;
    switch (type) {
        case "conclude":
            url = location.origin + `/TaskList/conclude.php?id=${id}`;
            break;
        case "delete":
            url = location.origin + `/TaskList/delete.php?id=${id}`;
            break;
        case "duplicate":
            url = location.origin + `/TaskList/duplicate.php?id=${id}`;
            break;
        case "edit":
            url = location.origin + `/TaskList/edit.php?id=${id}`;
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
                        return res.json();
                    case "duplicate":
                    case "edit":
                        return res.json();
                }
            }
        })
        .then( json => {
            console.log(json)
            switch (type) {
                case "duplicate": 
                    duplicateTask(task, json);
                    break;
                case "edit":
                    editTask(task, json);
                    break;
                case "delete":
                    handleTaskList(json);
                    break;
            }
        })
    }
}