<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id = $_GET['id'] ?? 0;
if($id == 0){
    header("Location:listar.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM miembros WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$miembro = $result->fetch_assoc();
$stmt->close();

if(!$miembro){
    header("Location:listar.php");
    exit;
}
?>

<form id="formEditarMiembro" method="POST" action="actualizar.php" enctype="multipart/form-data" class="form-grid">
    <div class="form-header-full">
        <h2>Editar Miembro</h2>
        <span class="close" onclick="cerrarEditar()">&times;</span>
    </div>

    <input type="hidden" name="id" value="<?php echo $miembro['id']; ?>">

    <div class="form-group">
        <label>Nombres</label>
        <input type="text" name="nombres" value="<?php echo htmlspecialchars($miembro['nombres']); ?>" required>
    </div>

    <div class="form-group">
        <label>Apellidos</label>
        <input type="text" name="apellidos" value="<?php echo htmlspecialchars($miembro['apellidos']); ?>" required>
    </div>

    <div class="form-group">
        <label>DNI</label>
        <input type="text" name="dni" value="<?php echo htmlspecialchars($miembro['dni']); ?>">
    </div>

    <div class="form-group">
        <label>Fecha Nacimiento</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo htmlspecialchars($miembro['fecha_nacimiento']); ?>">
    </div>

    <div class="form-group">
        <label>Género</label>
        <select name="genero">
            <option value="masculino" <?php if($miembro['genero']=="masculino") echo "selected"; ?>>Masculino</option>
            <option value="femenino" <?php if($miembro['genero']=="femenino") echo "selected"; ?>>Femenino</option>
        </select>
    </div>

    <div class="form-group">
        <label>Estado Civil</label>
        <select name="estado_civil">
            <option value="soltero" <?php if($miembro['estado_civil']=="soltero") echo "selected"; ?>>Soltero</option>
            <option value="casado" <?php if($miembro['estado_civil']=="casado") echo "selected"; ?>>Casado</option>
            <option value="viudo" <?php if($miembro['estado_civil']=="viudo") echo "selected"; ?>>Viudo</option>
            <option value="divorciado" <?php if($miembro['estado_civil']=="divorciado") echo "selected"; ?>>Divorciado</option>
        </select>
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($miembro['telefono']); ?>">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($miembro['email']); ?>">
    </div>

    <div class="form-group">
        <label>País</label>
        <input type="text" name="pais" value="<?php echo htmlspecialchars($miembro['pais']); ?>">
    </div>

    <div class="form-group">
        <label>Ciudad</label>
        <input type="text" name="ciudad" value="<?php echo htmlspecialchars($miembro['ciudad']); ?>">
    </div>

    <div class="form-group">
        <label>Dirección</label>
        <input type="text" name="direccion" value="<?php echo htmlspecialchars($miembro['direccion']); ?>">
    </div>

    <div class="form-group">
        <label>Ministerio</label>
        <input type="text" name="ministerio" value="<?php echo htmlspecialchars($miembro['ministerio']); ?>">
    </div>

    <div class="form-group full-width">
        <label>Foto Actual</label>
        <?php if($miembro['foto'] != ""): ?>
            <div class="preview-photo-wrap">
                <img src="../../uploads/<?php echo htmlspecialchars($miembro['foto']); ?>" class="preview-photo" alt="Foto actual">
            </div>
        <?php else: ?>
            <span class="no-photo">Sin foto actual</span>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Cambiar Foto</label>
        <input type="file" name="foto" accept=".jpg,.jpeg,.png,.gif">
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="estado_miembro">
            <option value="activo" <?php if($miembro['estado_miembro']=="activo") echo "selected"; ?>>Activo</option>
            <option value="inactivo" <?php if($miembro['estado_miembro']=="inactivo") echo "selected"; ?>>Inactivo</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-cancel" onclick="cerrarEditar()">Cancelar</button>
        <button type="submit" class="btn btn-gold">Actualizar</button>
    </div>
</form>