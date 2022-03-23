import handleTaskList from "../utils/handleTaskList.js";
import setLoadingBox from "../utils/setLoadingBox.js";

export default async function deleteTask(url, task = null) {
    let loadingBox;
    if (task) {
        loadingBox = setLoadingBox("Apagando tarefa...");
    } else {
        loadingBox = setLoadingBox("Apagando tarefas...");
    }

    const res = await fetch(url);

    loadingBox.remove();
    if (task) {
        const json = await res.json();
        task.remove();
        handleTaskList(json);
    } else {
        Array.from(document.querySelector(".list-container .list").children).forEach( el => el.remove());
        handleTaskList({rows: 0});
    }
}