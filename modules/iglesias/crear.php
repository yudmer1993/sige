<form method="POST" action="guardar.php" class="form-grid">
    <div class="form-group">
        <label>Nombre Iglesia</label>
        <input type="text" name="nombre" placeholder="Nombre Iglesia" required>
    </div>

    <div class="form-group">
        <label>País</label>
        <input type="text" name="pais" placeholder="País">
    </div>

    <div class="form-group">
        <label>Ciudad</label>
        <input type="text" name="ciudad" placeholder="Ciudad">
    </div>

    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="direccion" placeholder="Dirección">
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono" placeholder="Teléfono">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="Email">
    </div>

    <div class="form-group">
        <label>Fecha Fundación</label>
        <input type="date" name="fecha_fundacion">
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-gold">Guardar</button>
    </div>
</form>