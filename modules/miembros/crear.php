<form id="formMiembro" method="POST" action="guardar.php" enctype="multipart/form-data" class="form-grid">
    <div class="form-header-full">
        <h2>Registrar Miembro</h2>
        <span class="close" onclick="cerrarModalCrear()">&times;</span>
    </div>

    <div class="form-group">
        <label>Nombres</label>
        <input type="text" name="nombres" required>
    </div>

    <div class="form-group">
        <label>Apellidos</label>
        <input type="text" name="apellidos" required>
    </div>

    <div class="form-group">
        <label>DNI</label>
        <input type="text" name="dni">
    </div>

    <div class="form-group">
        <label>Fecha Nacimiento</label>
        <input type="date" name="fecha_nacimiento">
    </div>

    <div class="form-group">
        <label>Género</label>
        <select name="genero">
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
        </select>
    </div>

    <div class="form-group">
        <label>Estado Civil</label>
        <select name="estado_civil">
            <option value="soltero">Soltero</option>
            <option value="casado">Casado</option>
            <option value="viudo">Viudo</option>
            <option value="divorciado">Divorciado</option>
        </select>
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <div class="form-group">
        <label>País</label>
        <input type="text" name="pais">
    </div>

    <div class="form-group">
        <label>Ciudad</label>
        <input type="text" name="ciudad">
    </div>

    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="direccion">
    </div>

    <div class="form-group">
        <label>Ministerio</label>
        <input type="text" name="ministerio">
    </div>

    <div class="form-group">
        <label>Foto</label>
        <input type="file" name="foto" accept=".jpg,.jpeg,.png,.gif">
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="estado_miembro">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-cancel" onclick="cerrarModalCrear()">Cancelar</button>
        <button type="submit" class="btn btn-gold">Guardar</button>
    </div>
</form>