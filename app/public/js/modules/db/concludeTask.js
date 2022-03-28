export default async function concludeTask(url, task) {
    task.querySelector(".options .conclude").innerText = "Aguarde...";

    fetch(url)
    .then( res => {
        if (res.ok) {
            task.querySelector(".task-header img").classList.remove("unshow");
            task.querySelector(".options .conclude").classList.add("disabled");
            task.querySelector(".options .conclude").innerText = "Concluída";
        }
    })
    
}