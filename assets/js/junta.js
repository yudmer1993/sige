document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formJunta");
    const buscador = document.getElementById("buscadorTabla");
    const tabla = document.getElementById("tablaJunta");

    if (form) {
        form.addEventListener("submit", function (e) {
            const usuario = document.getElementById("usuario_id");
            const cargo = document.getElementById("cargo_id");
            const inicio = document.getElementById("periodo_inicio");
            const fin = document.getElementById("periodo_fin");

            if (!usuario.value || !cargo.value || !inicio.value || !fin.value) {
                e.preventDefault();
                alert("Complete todos los campos obligatorios.");
                return;
            }

            if (fin.value < inicio.value) {
                e.preventDefault();
                alert("La fecha de fin no puede ser menor que la fecha de inicio.");
                fin.focus();
            }
        });
    }

    const botonesEliminar = document.querySelectorAll(".btn-eliminar");
    botonesEliminar.forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            const confirmar = confirm("¿Seguro que deseas eliminar este registro?");
            if (!confirmar) {
                e.preventDefault();
            }
        });
    });

    if (buscador && tabla) {
        buscador.addEventListener("keyup", function () {
            const texto = buscador.value.toLowerCase();
            const filas = tabla.querySelectorAll("tbody tr");

            filas.forEach(function (fila) {
                const contenido = fila.textContent.toLowerCase();
                fila.style.display = contenido.includes(texto) ? "" : "none";
            });
        });
    }
});