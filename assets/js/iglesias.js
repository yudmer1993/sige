function abrirModalCrear() {
    document.getElementById('modalCrear').style.display = 'block';
}

function cerrarModalCrear() {
    document.getElementById('modalCrear').style.display = 'none';
}

function abrirModalEditar(id, nombre, pais, ciudad, direccion, telefono, email, fecha_fundacion) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_pais').value = pais;
    document.getElementById('edit_ciudad').value = ciudad;
    document.getElementById('edit_direccion').value = direccion;
    document.getElementById('edit_telefono').value = telefono;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_fecha_fundacion').value = fecha_fundacion;

    document.getElementById('modalEditar').style.display = 'block';
}

function cerrarModalEditar() {
    document.getElementById('modalEditar').style.display = 'none';
}

window.onclick = function(event) {
    let modalCrear = document.getElementById('modalCrear');
    let modalEditar = document.getElementById('modalEditar');

    if (event.target === modalCrear) {
        cerrarModalCrear();
    }

    if (event.target === modalEditar) {
        cerrarModalEditar();
    }
}