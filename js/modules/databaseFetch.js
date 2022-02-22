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
                }
            }
        })
    }
}