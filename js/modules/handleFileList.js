export default function handleFileList(element) {    
    const input = document.querySelector(".container input[type='file']");
    const fileList = document.querySelector(".container .file-list");

    input.addEventListener("input", updateList);
    
    function removeFile(list, file) {
        let newFileList = new DataTransfer();
        for (const item of list) {
            if (item.name !== file.name) {
                newFileList.items.add(item);
            }
        }
        input.files = newFileList.files;
        updateList();
    }
    
    function updateList() {
        const files = input.files;
        const fileElements = Array.from(fileList.children); 

        if (fileElements.length > 0) {
            fileElements.forEach( child => {
                child.remove();
            })
        }
    
        if (files.length > 0) {
            for (const file of files) {
                const li = document.createElement("li");
                const p = document.createElement("p");
                const img = document.createElement("img");

                li.classList.add("file");
                p.innerText = file.name;    
                img.src = "./img/removeBtn.svg";

                li.appendChild(p);
                li.appendChild(img);
                fileList.appendChild(li);
    
                img.addEventListener('click', () => {
                    removeFile(files, file);
                })
            }
        } else {
            const p = document.createElement("p");
            p.innerText = "Nenhum arquivo selecionado";
            fileList.appendChild(p);
        }
    }
    
    updateList();
}
