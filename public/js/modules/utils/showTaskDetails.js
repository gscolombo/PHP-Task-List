export default function showDetails(task) {
    const blurRect = document.createElement("div");
    blurRect.classList.add("blur-rect");

    const taskClone = task.cloneNode(true);
    taskClone.classList.add("show-details");
    taskClone.querySelector(".details").classList.remove("unshow");
    taskClone.querySelector(".options").remove();

    const header = taskClone.querySelector(".task-header");

    const img = document.createElement("img");

    img.src = "./public/img/removeBtnWhite.svg";
    img.addEventListener("click", () => {
        taskClone.classList.replace("show-details", "unshow-details");
        setTimeout(() => {
            blurRect.removeChild(taskClone);
            blurRect.remove();
        }, 250)  
    });
    header.appendChild(img);

    const images = Array.from(taskClone.querySelectorAll("img")).filter(img => !img.classList.contains("download"));
    const imgBox = document.createElement("div");
    imgBox.classList.add("symbols");
    images.forEach(img => imgBox.appendChild(img));
    header.appendChild(imgBox);

    blurRect.append(taskClone);
    document.body.insertBefore(blurRect, document.querySelector("script"));
}