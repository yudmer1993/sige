<?php
include("../../config/database.php");

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM ministros WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$ministro = $result->fetch_assoc();
?>

<form method="POST" action="actualizar.php" class="form-grid">
    <input type="hidden" name="id" value="<?php echo $ministro['id']; ?>">

    <div class="form-group">
        <label>Usuario</label>
        <select name="usuario_id" required>
            <?php
            $usuarios = $conn->query("SELECT id, nombres, apellidos FROM usuarios ORDER BY nombres");
            while($u = $usuarios->fetch_assoc()){
                $sel = ($u['id'] == $ministro['usuario_id']) ? "selected" : "";
                echo "<option value='".$u['id']."' $sel>".htmlspecialchars($u['nombres']." ".$u['apellidos'])."</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Tipo Ministro</label>
        <select name="tipo_ministro">
            <?php
            $tipos = ['obrero','pastor','misionero','apostol','profeta','lider'];
            foreach($tipos as $t){
                $sel = ($t == $ministro['tipo_ministro']) ? "selected" : "";
                echo "<option value='$t' $sel>".ucfirst($t)."</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Iglesia</label>
        <select name="iglesia_dirige">
            <option value="">Ninguna</option>
            <?php
            $iglesias = $conn->query("SELECT id, nombre FROM iglesias ORDER BY nombre");
            while($i = $iglesias->fetch_assoc()){
                $sel = ($i['id'] == $ministro['iglesia_dirige']) ? "selected" : "";
                echo "<option value='".$i['id']."' $sel>".htmlspecialchars($i['nombre'])."</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Fecha Ordenación</label>
        <input type="date" name="fecha_ordenacion" value="<?php echo htmlspecialchars($ministro['fecha_ordenacion']); ?>">
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($ministro['telefono']); ?>">
    </div>

    <div class="form-group">
        <label>País Misión</label>
        <input type="text" name="pais_mision" value="<?php echo htmlspecialchars($ministro['pais_mision']); ?>">
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="estado_ministerial">
            <option value="activo" <?php if($ministro['estado_ministerial']=="activo") echo "selected"; ?>>Activo</option>
            <option value="inactivo" <?php if($ministro['estado_ministerial']=="inactivo") echo "selected"; ?>>Inactivo</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-cancel" onclick="cerrarModalEditar()">Cancelar</button>
        <button type="submit" class="btn btn-gold">Actualizar</button>
    </div>
</form>