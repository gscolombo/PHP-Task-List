export default function resetForm(form) {
    Array.from(form.querySelectorAll("input")).forEach(input => {
        input.innerText = "";
        if (input.type === "checkbox" || input.type === "radio") {
            input.checked = false;
            if (input.id === "low-priority") {
                input.checked = true;
                input.value = 1;
            }
        } else {
            input.value = "";
        }
    });

    form.querySelector("textarea").value = "";
    form.querySelector("textarea").innerText = "";
    
    const fileList = form.querySelector(".attachments .file-list");
    const p = document.createElement("p");
    p.innerText = "Nenhum arquivo adicionado";
    Array.from(fileList.children).forEach(file => file.remove());
    fileList.appendChild(p);
}