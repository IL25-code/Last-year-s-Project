var dialogID = null;

document.querySelector("#t_add").addEventListener("click", ()=>{
    document.getElementById("taskadd").showModal();
    dialogID = "taskadd";
});
document.querySelector("#t_link").addEventListener("click", ()=>{
    document.getElementById("tasklink").showModal();
    dialogID = "tasklink";
});
document.querySelector("#t_remove").addEventListener("click", ()=>{
    document.getElementById("taskremove").showModal();
    dialogID = "taskremove";
});
document.querySelector("#t_unlink").addEventListener("click", ()=>{
    document.getElementById("taskunlink").showModal();
    dialogID = "taskunlink";
});


for(var x of document.querySelectorAll(".close_button")){
    x.addEventListener("click", ()=>{
        document.getElementById(dialogID).close();
    })
}
