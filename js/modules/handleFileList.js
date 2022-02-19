export default function handleFileList() {    
    const input = document.querySelector("input[type='file']");
    const fileList = document.querySelector(".file-list");
    
    input.addEventListener("change", updateList);
    
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
        let files = input.files;
        const fileElements = Array.from(fileList.children); 
    
        if (fileElements.length > 0) {
            fileElements.forEach( child => {
                child.remove();
            })
        }
    
        if (files.length > 0) {
            for (const file of files) {
                const li = document.createElement("li");
                li.classList.add("file");
                li.innerText = file.name;
    
                const img = document.createElement("img");
                img.src = "./img/removeBtn.svg";
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
