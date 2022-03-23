import saveTask from "./saveTask.js";
import editTask from "./editTask.js";
import deleteTask from "./deleteTask.js";
import duplicateTask from "./duplicateTask.js";
import concludeTask from "./concludeTask.js";

export default function databaseFetch(e, type) {
    const task = e.path[2];
    const id = task.id;

    const route = location.href + `?route=${type}`;
    switch (type) {
        case "save": 
            saveTask(route);
            break;
        case "edit":
            editTask(route + `&id=${id}`);
            break;
        case "delete":
            if (id !== "") {
                deleteTask(route + `&id=${id}`, task);
            } else {
                deleteTask(route + "&deleteAll=true");
            }
            break;
        case "duplicate":
            duplicateTask(route + `&id=${id}`, task);
            break;
        case "conclude":
            concludeTask(route + `&id=${id}`, task);
            break;
    }
}