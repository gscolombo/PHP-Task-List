export default function duplicateTask(task, data) {
    const clone = task.cloneNode(true);
    clone.setAttribute("id", data.id);

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