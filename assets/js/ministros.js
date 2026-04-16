function abrirModalCrear() {
    const modal = document.getElementById("modalCrear");
    const contenido = document.getElementById("contenidoCrear");

    fetch("crear.php")
        .then(response => response.text())
        .then(data => {
            contenido.innerHTML = data;
            modal.style.display = "block";
        })
        .catch(error => {
            contenido.innerHTML = "<p>Error al cargar el formulario.</p>";
            modal.style.display = "block";
            console.error(error);
        });
}

function cerrarModalCrear() {
    document.getElementById("modalCrear").style.display = "none";
    document.getElementById("contenidoCrear").innerHTML = "";
}

function editarMinistro(id) {
    const modal = document.getElementById("modalEditar");
    const contenido = document.getElementById("contenidoEditar");

    fetch("editar.php?id=" + id)
        .then(response => response.text())
        .then(data => {
            contenido.innerHTML = data;
            modal.style.display = "block";
        })
        .catch(error => {
            contenido.innerHTML = "<p>Error al cargar el formulario de edición.</p>";
            modal.style.display = "block";
            console.error(error);
        });
}

function cerrarModalEditar() {
    document.getElementById("modalEditar").style.display = "none";
    document.getElementById("contenidoEditar").innerHTML = "";
}

window.onclick = function(event) {
    const modalCrear = document.getElementById("modalCrear");
    const modalEditar = document.getElementById("modalEditar");

    if (event.target === modalCrear) {
        cerrarModalCrear();
    }

    if (event.target === modalEditar) {
        cerrarModalEditar();
    }
};