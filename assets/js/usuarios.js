function abrirModal() {
    const modal = document.getElementById("modalUsuario");
    if (modal) {
        modal.style.display = "block";
        document.body.style.overflow = "hidden";
    }
}

function cerrarModal() {
    const modal = document.getElementById("modalUsuario");
    if (modal) {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
        limpiarFormularioNuevo();
    }
}

function abrirEditar(id) {
    const modal = document.getElementById("modalEditar");
    const contenido = document.getElementById("contenidoEditar");

    if (!modal || !contenido) return;

    modal.style.display = "block";
    document.body.style.overflow = "hidden";

    contenido.innerHTML = `
        <div style="text-align:center; padding:20px; color:#d4af37; font-weight:bold;">
            Cargando formulario...
        </div>
    `;

    fetch("editar.php?id=" + encodeURIComponent(id))
        .then(response => {
            if (!response.ok) {
                throw new Error("No se pudo cargar el formulario.");
            }
            return response.text();
        })
        .then(data => {
            contenido.innerHTML = data;
        })
        .catch(error => {
            contenido.innerHTML = `
                <div style="text-align:center; padding:20px; color:#ff6b6b; font-weight:bold;">
                    Error al cargar el formulario.
                </div>
            `;
            console.error(error);
        });
}

function cerrarEditar() {
    const modal = document.getElementById("modalEditar");
    const contenido = document.getElementById("contenidoEditar");

    if (modal) {
        modal.style.display = "none";
    }

    if (contenido) {
        contenido.innerHTML = "";
    }

    document.body.style.overflow = "auto";
}

function limpiarFormularioNuevo() {
    const modal = document.getElementById("modalUsuario");
    if (!modal) return;

    const form = modal.querySelector("form");
    if (form) {
        form.reset();
    }
}

window.addEventListener("click", function (event) {
    const modalUsuario = document.getElementById("modalUsuario");
    const modalEditar = document.getElementById("modalEditar");

    if (event.target === modalUsuario) {
        cerrarModal();
    }

    if (event.target === modalEditar) {
        cerrarEditar();
    }
});

window.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        cerrarModal();
        cerrarEditar();
    }
});