export default function showDetails(e) {
    const task = e.currentTarget.parentElement.parentElement;
    const blurRect = document.createElement("div");
    blurRect.classList.add("blur-rect");

    const isDBTask = task instanceof Element;
    const taskClone = task.cloneNode(true);
    const options = taskClone.querySelectorAll(".options button");

    taskClone.classList.add("show-details");
    taskClone.querySelector(".details").classList.remove("unshow");
    
    options.forEach((button, i) => {
        switch(i) {
            case 0:
            case 1:
            case 2:
            case 3:
                button.remove();
                break;
            case 4:
                const img = document.createElement("img");
                img.src = "./public/img/removeBtnWhite.svg";
                button.innerText = "";
                button.appendChild(img);
                button.addEventListener("click", () => {
                    taskClone.classList.replace("show-details", "unshow-details");
                    setTimeout(() => {
                        blurRect.removeChild(taskClone);
                        blurRect.remove();
                    }, 250)  
                });
                break;
        }
    })

    blurRect.append(taskClone);
    document.body.insertBefore(blurRect, document.querySelector("script"));
}