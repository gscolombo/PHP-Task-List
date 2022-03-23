export default function setLoadingBox(message) {
    const blurRect = document.createElement("div");
    const messageContainer = document.createElement("div");
    const loadingMessage = document.createElement("span");
    blurRect.classList.add("blur-rect");
    messageContainer.classList.add("loading-message");
    loadingMessage.innerText = message;

    messageContainer.appendChild(loadingMessage);
    blurRect.appendChild(messageContainer);
    document.body.insertBefore(blurRect, document.querySelector("script"));

    return blurRect;
}