import handleFileList from "./modules/handleFileList.js";
import showDetails from "./modules/showTaskDetails.js";
import mobileScroll from "./modules/mobileScroll.js";
import databaseFetch from "./modules/databaseFetch.js";

handleFileList();

if (screen.width < 1200) {
    mobileScroll();
}
const tasks = Array.from(document.querySelectorAll("div.task"));
tasks.forEach( task => {
    const detailsBtn = task.querySelector(".options button.details-btn");
    const duplicateBtn = task.querySelector(".options button.duplicate");
    const deleteBtn = task.querySelector(".options button.delete");
    const concludeBtn = task.querySelector(".options button.conclude");

    detailsBtn.addEventListener("click", showDetails);
    duplicateBtn.addEventListener("click", e => databaseFetch(e, "duplicate"));
    deleteBtn.addEventListener("click", e => databaseFetch(e, "delete"));
    concludeBtn.addEventListener("click", e => databaseFetch(e, "conclude"));
})
