const body = document.querySelector("body")
const nav = document.querySelector("nav")
const modeToggle = document.querySelector(".dark-light")
const sidebarOpen = document.querySelector(".sidebarOpen")
const siderbarClose = document.querySelector(".siderbarClose")

getMode = localStorage.getItem("mode")
if (getMode && getMode === "dark-mode") {
    body.classList.add("dark")
    modeToggle.classList.add("active")
}

/* Toggle dark and light mode */
modeToggle.addEventListener("click", function () {
    modeToggle.classList.toggle("active")
    body.classList.toggle("dark")

    // js code to keep user selected mode even page refresh or file reopen
    if (!body.classList.contains("dark")) {
        localStorage.setItem("mode", "light-mode")
    } else {
        localStorage.setItem("mode", "dark-mode")
    }
})


/* Add sidebar */
sidebarOpen.addEventListener("click", function () {
    nav.classList.add("active")
})

/* Remove sidebar - user clicks the close button */
siderbarClose.addEventListener("click", function () {
    nav.classList.remove("active")
})

/* Remove sidebar - user clicks outside the sidebar*/
body.addEventListener("click", e => {
    const clickedElm = e.target;

    if (!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")) {
        nav.classList.remove("active");
    }
});

