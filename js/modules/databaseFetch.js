import showDetails from "./showTaskDetails.js";

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
                        return res.json();
                }
            }
        })
        .then( json => {
            if (type === "duplicate") {
                const clone = task.cloneNode(true);
                clone.setAttribute("id", json.id);
    
                const options = Array.from(clone.querySelectorAll(".options button"));
                options.forEach( (option, i) => {
                    option.addEventListener("click", e => {
                        switch (i) {
                            case 0:
                                databaseFetch(e, "conclude");
                                break;
                            case 1:
                                databaseFetch(e, "delete");
                                break;
                            case 2:
                                databaseFetch(e, "duplicate");
                                break;
                            case 3:
                                showDetails(e);
                                break;
                        }
                    })
                });
                task.parentElement.appendChild(clone);
            }
        })
    }
}