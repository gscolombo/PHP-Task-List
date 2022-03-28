import handleTaskList from "../utils/handleTaskList.js";
import resetForm from "../utils/resetForm.js";
import setLoadingBox from "../utils/setLoadingBox.js";
import setNewTask from "../utils/setNewTask.js";

export default function saveTask(url) {
    const form = document.querySelector("form.save");
    const list = document.querySelector(".list");

    const post = new FormData(form);
    const params = {
        method: 'POST',
        header: {
            'Content-Type': 'multipart/form-data',
        },
        body: post,
    }

    const loadingBox = setLoadingBox("Salvando tarefa...");

    fetch(url, params)
    .then(res => {
        loadingBox.remove();
        return res.json();
    })
    .then(json => {
        list.appendChild(setNewTask(json.task, json.url));
        document.querySelector(".list-container .wrapper").classList.remove("unshow");
        document.querySelector(".list-container .eraseAll").classList.remove("unshow");
        document.querySelector(".list-container h2.message").classList.add("unshow");
        resetForm(form);
        handleTaskList(json);
    });
}