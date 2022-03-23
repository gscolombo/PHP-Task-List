import handleFileList from "./modules/utils/handleFileList.js";
import showDetails from "./modules/utils/showTaskDetails.js";
import mobileScroll from "./modules/mobileScroll.js";
import databaseFetch from "./modules/db/databaseFetch.js";

handleFileList(document);

if (screen.width < 1200) {
    mobileScroll();
}

document.querySelector("button.save").addEventListener("click", e => databaseFetch(e, "save"));
document.querySelector("button.eraseAll").addEventListener("click", e => databaseFetch(e, "delete"));

const tasks = Array.from(document.querySelectorAll("div.task"));
tasks.forEach( task => {
    const detailsBtn = task.querySelector(".options button.show-details");
    const duplicateBtn = task.querySelector(".options button.duplicate");
    const deleteBtn = task.querySelector(".options button.delete");
    const concludeBtn = task.querySelector(".options button.conclude");
    const editBtn = task.querySelector(".options button.edit");

    detailsBtn.addEventListener("click", showDetails);
    duplicateBtn.addEventListener("click", e => databaseFetch(e, "duplicate"));
    deleteBtn.addEventListener("click", e => databaseFetch(e, "delete"));
    concludeBtn.addEventListener("click", e => databaseFetch(e, "conclude"));
    editBtn.addEventListener("click", e => databaseFetch(e, "edit"));
})

