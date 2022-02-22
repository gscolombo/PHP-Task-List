import handleFileList from "./modules/handleFileList.js";
import showDetails from "./modules/showTaskDetails.js";
import mobileScroll from "./modules/mobileScroll.js";
import databaseFetch from "./modules/databaseFetch.js";

handleFileList();

if (screen.width < 1200) {
    mobileScroll();
}

const concludeButtons = document.querySelectorAll("button.conclude");
concludeButtons.forEach( btn => {
    btn.addEventListener("click", e => {
        databaseFetch(e, "conclude");
    });
})

const deleteButtons = document.querySelectorAll("button.delete");
deleteButtons.forEach(btn => {
    btn.addEventListener("click", e => {
        databaseFetch(e, "delete");
    })
})

const tasks = Array.from(document.querySelectorAll("div.task"));
tasks.forEach( task => {
    const btn = task.querySelector(".options button.details-btn");
    btn.addEventListener("click", showDetails);
})