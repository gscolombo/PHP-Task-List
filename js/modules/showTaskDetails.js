export default function showDetails(e) {
    const blurRect = document.createElement("div");
    blurRect.classList.add("blur-rect");

    const btn = e.currentTarget;
    const task = btn.parentElement.parentElement.cloneNode(true);
    const btnClone = task.querySelector("button.details-btn");

    task.classList.add("show-details");
    task.querySelector(".details").classList.remove("unshow");
    btnClone.innerText = "Voltar";
    
    blurRect.append(task);
    document.body.insertBefore(blurRect, document.querySelector("script"));

    btnClone.addEventListener("click", () => {
        task.classList.remove("show-details");
        task.classList.add("unshow-details");
        setTimeout(() => {
            blurRect.removeChild(task);
            blurRect.remove();
        }, 250)  
    })
}