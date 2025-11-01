var modal = document.getElementById("modalConfirmacion");

var inputCodigoEliminar = document.getElementById("codigoEliminar");

function abrirModalEliminar(codigo) {
    inputCodigoEliminar.value = codigo;
    modal.style.display = "block";
}

function cerrarModalEliminar() {
    inputCodigoEliminar.value = "";
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        cerrarModalEliminar();
    }
}