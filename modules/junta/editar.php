<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id = $_GET['id'] ?? 0;
if($id == 0){
    header("Location: listar.php");
    exit;
}

$junta = $conn->query("SELECT * FROM junta_nacional WHERE id=$id")->fetch_assoc();
if(!$junta){
    header("Location: listar.php");
    exit;
}

$usuarios = $conn->query("SELECT id, nombres, apellidos FROM usuarios ORDER BY nombres ASC");
$cargos = $conn->query("SELECT id, nombre FROM cargos ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Miembro de Junta</title>
    <link rel="stylesheet" href="../../assets/css/junta.css">
</head>
<body>
    <div class="junta-container">
        <div class="junta-card">
            <div class="junta-header">
                <h1>Editar Miembro de la Junta</h1>
                <p>Actualice la información del integrante</p>
            </div>

            <form method="POST" action="actualizar.php" class="junta-form" id="formJunta">
                <input type="hidden" name="id" value="<?php echo $junta['id']; ?>">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="usuario_id">Usuario</label>
                        <select name="usuario_id" id="usuario_id" required>
                            <option value="">Seleccionar Usuario</option>
                            <?php while($u = $usuarios->fetch_assoc()): ?>
                                <option value="<?php echo $u['id']; ?>" <?php echo ($u['id'] == $junta['usuario_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($u['nombres'].' '.$u['apellidos']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cargo_id">Cargo</label>
                        <select name="cargo_id" id="cargo_id" required>
                            <option value="">Seleccionar Cargo</option>
                            <?php while($c = $cargos->fetch_assoc()): ?>
                                <option value="<?php echo $c['id']; ?>" <?php echo ($c['id'] == $junta['cargo_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars(ucfirst($c['nombre'])); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="periodo_inicio">Periodo Inicio</label>
                        <input type="date" name="periodo_inicio" id="periodo_inicio" value="<?php echo $junta['periodo_inicio']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="periodo_fin">Periodo Fin</label>
                        <input type="date" name="periodo_fin" id="periodo_fin" value="<?php echo $junta['periodo_fin']; ?>" required>
                    </div>

                    <div class="form-group form-group-full">
                        <label for="activo">Estado</label>
                        <select name="activo" id="activo">
                            <option value="1" <?php echo ($junta['activo'] == 1) ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo ($junta['activo'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="listar.php" class="btn btn-secondary">Volver</a>
                    <button type="submit" class="btn btn-primary">Actualizar Registro</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../assets/js/junta.js"></script>
</body>
</html>