import databaseFetch from "./databaseFetch.js";
import showDetails from "../utils/showTaskDetails.js";
import handleTaskList from "../utils/handleTaskList.js";
import setLoadingBox from "../utils/setLoadingBox.js";

export default async function duplicateTask(url, task) {
    const loadingBox = setLoadingBox("Duplicando tarefa...");

    const res = await fetch(url);
    const data = await res.json();

    const clone = task.cloneNode(true);
    clone.setAttribute("id", data.task_id);
    if (data.attach_ids.length > 0) {
        clone.querySelectorAll(".attachments ul .file").forEach((attach, i) => {
            attach.setAttribute("id", data.attach_ids[i]);
        })
    }

    const options = Array.from(clone.querySelectorAll(".options button"));
    options.forEach( option => {
        option.addEventListener("click", e => {
            switch (option.classList[0]) {
                case "conclude":
                    databaseFetch(e, "conclude");
                    break;
                case "edit":
                    databaseFetch(e, "edit");
                    break;
                case "delete":
                    databaseFetch(e, "delete");
                    break;
                case "duplicate":
                    databaseFetch(e, "duplicate");
                    break;
                case "show-details":
                    showDetails(clone);
                    break;
            }
        })
    });
    
    loadingBox.remove();
    task.parentElement.appendChild(clone);
    handleTaskList(data);
}