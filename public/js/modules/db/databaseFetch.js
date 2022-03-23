import saveTask from "./saveTask.js";
import editTask from "./editTask.js";
import deleteTask from "./deleteTask.js";
import duplicateTask from "./duplicateTask.js";
import concludeTask from "./concludeTask.js";

function routing(route) {
    return location.href + `?route=${route}`;
}

export default function databaseFetch(e, type) {
    const btn = e.currentTarget;
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
    
    // route.then(json => {
    //     const route = json.route;

        
    // })

    // if (url !== "") {
    //     fetch(url)
    //     .then(res => {
    //         if (res.status === 200) {
    //             switch (type) {
    //                 case "conclude" :
    //                     task.querySelector(".task-header img").classList.remove("unshow");
    //                     btn.classList.add("disabled");
    //                     btn.innerText = "Concluída";
    //                     break;
    //                 case "delete" :
    //                     task.remove();
    //                     return res.json();
    //                 case "duplicate":
    //                 case "edit":
    //                     return res.json();
    //             }
    //         }
    //     })
    //     .then( json => {
    //         switch (type) {
    //             case "duplicate": 
    //                 duplicateTask(task, json);
    //                 break;
    //             case "edit":
    //                 editTask(task, json);
    //                 break;
    //             case "delete":
    //                 handleTaskList(json);
    //                 break;
    //         }
    //     })
    // }
}