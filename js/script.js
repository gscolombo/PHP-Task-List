import handleFileList from "./modules/handleFileList.js";
import showDetails from "./modules/showTaskDetails.js";
import mobileScroll from "./modules/mobileScroll.js";

handleFileList();
showDetails();

if (screen.width <= 400) {
    mobileScroll();
}