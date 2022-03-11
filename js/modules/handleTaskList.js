export default function handleFileList(json) {
    const container = document.querySelector(".list-container");
    const eraseAllBtn = document.querySelector(".eraseAll");
    const legend = document.querySelector(".legend");
    const sign = document.querySelector(".form-sign");

    const message = document.createElement("h2");
    message.classList.add("message");
    message.innerText = "Nenhuma tarefa adicionada";

    const rows = json.rows;
    if (rows === "0") {
        eraseAllBtn.remove();
        legend.remove();

        container.insertBefore(message, sign);
    }
}