import handleFileList from "./modules/handleFileList.js";
import showDetails from "./modules/showTaskDetails.js";
import mobileScroll from "./modules/mobileScroll.js";
import concludeTask from "./modules/setConcludedState.js";

handleFileList();
showDetails();
concludeTask();

if (screen.width < 1200) {
    mobileScroll();
}