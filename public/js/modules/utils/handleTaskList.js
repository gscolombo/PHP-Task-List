export default function handleTaskList(json) {
    if (json.rows === 0) {
        document.querySelector(".list-container .wrapper").classList.add("unshow");
        document.querySelector(".list-container .eraseAll").classList.add("unshow");
        document.querySelector(".list-container .arrow-down").classList.add("unshow");
        document.querySelector(".list-container h2.message").classList.remove("unshow");
    } else if (json.rows > 5) {
        document.querySelector(".list-container .arrow-down").classList.remove("unshow");
    } else {
        document.querySelector(".list-container .arrow-down").classList.add("unshow");
    }
}