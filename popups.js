document.querySelector("#t_add").addEventListener("click", function () {
    document.querySelector("[taskadd]").showModal();
});
document.querySelector("#t_link").addEventListener("click", function () {
    document.querySelector("[tasklink]").showModal();
});

var closeButtons = Array.from(document.querySelectorAll(".close_button"));



for (var x of closeButtons) {
    var dialog = x.closest('dialog');
    if (dialog) {
        var attributes = Array.from(dialog.attributes);
        var idname = attributes[0].name;
        x.addEventListener("click", closeModal(idname));
    } else {
        console.log("Nessun nodo dialog trovato contenente .close_button.");
    }
}

function closeModal(id){
    document.getElementById("["+id+"]").close();
}
