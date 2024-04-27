document.querySelector("#t_add").addEventListener("click", function() {
    document.querySelector(".popups").classList.add("active");
    document.querySelector("[taskadd]").classList.add("active");
});

document.querySelector("#t_link").addEventListener("click", function() {
    document.querySelector(".popups").classList.add("active");
    document.querySelector("[linktasks]").classList.add("active");
});

document.querySelector(".popups .close_button").addEventListener("click", function() {
    document.querySelector(".popups").classList.remove("active");
    document.querySelector("[taskadd]").classList.remove("active");
    document.querySelector("[linktasks]").classList.remove("active");
});
