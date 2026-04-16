<?php
include("../../config/database.php");
?>

<form method="POST" action="guardar.php" class="form-grid">
    <div class="form-group">
        <label>Usuario</label>
        <select name="usuario_id" required>
            <option value="">Seleccione un usuario</option>
            <?php
            $usuarios = $conn->query("SELECT id, nombres, apellidos FROM usuarios ORDER BY nombres");
            while($u = $usuarios->fetch_assoc()){
                echo "<option value='".$u['id']."'>".htmlspecialchars($u['nombres']." ".$u['apellidos'])."</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Tipo Ministro</label>
        <select name="tipo_ministro" required>
            <option value="obrero">Obrero</option>
            <option value="pastor">Pastor</option>
            <option value="misionero">Misionero</option>
            <option value="apostol">Apóstol</option>
            <option value="profeta">Profeta</option>
            <option value="lider">Líder</option>
        </select>
    </div>

    <div class="form-group">
        <label>Iglesia</label>
        <select name="iglesia_dirige">
            <option value="">Ninguna</option>
            <?php
            $iglesias = $conn->query("SELECT id, nombre FROM iglesias ORDER BY nombre");
            while($i = $iglesias->fetch_assoc()){
                echo "<option value='".$i['id']."'>".htmlspecialchars($i['nombre'])."</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Fecha Ordenación</label>
        <input type="date" name="fecha_ordenacion">
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono" placeholder="Ingrese teléfono">
    </div>

    <div class="form-group">
        <label>País Misión</label>
        <input type="text" name="pais_mision" placeholder="Ingrese país de misión">
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="estado_ministerial" required>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-cancel" onclick="cerrarModalCrear()">Cancelar</button>
        <button type="submit" class="btn btn-gold">Guardar</button>
    </div>
</form>