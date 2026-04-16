<?php
include("../../includes/auth.php");
include("../../config/database.php");

$modo_edicion = false;
$registro = [
    'id' => '',
    'usuario_id' => '',
    'cargo_id' => '',
    'periodo_inicio' => '',
    'periodo_fin' => '',
    'activo' => '1'
];

if (isset($_GET['editar']) && is_numeric($_GET['editar'])) {
    $editar_id = (int) $_GET['editar'];
    $sql_edit = "SELECT * FROM junta_nacional WHERE id = $editar_id";
    $res_edit = $conn->query($sql_edit);
    if ($res_edit && $res_edit->num_rows > 0) {
        $registro = $res_edit->fetch_assoc();
        $modo_edicion = true;
    }
}

$usuarios = $conn->query("SELECT id, nombres, apellidos FROM usuarios ORDER BY nombres ASC, apellidos ASC");
$cargos = $conn->query("SELECT id, nombre FROM cargos ORDER BY nombre ASC");

$sql = "
SELECT j.*, 
       u.nombres, 
       u.apellidos, 
       u.foto AS foto_usuario, 
       c.nombre AS cargo_nombre
FROM junta_nacional j
LEFT JOIN usuarios u ON j.usuario_id = u.id
LEFT JOIN cargos c ON j.cargo_id = c.id
ORDER BY j.id DESC
";
$result = $conn->query($sql);

$mensaje = '';
if (isset($_GET['ok'])) {
    if ($_GET['ok'] == '1') $mensaje = 'Registro guardado correctamente.';
    if ($_GET['ok'] == '2') $mensaje = 'Registro actualizado correctamente.';
    if ($_GET['ok'] == '3') $mensaje = 'Registro eliminado correctamente.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junta Nacional</title>
    <link rel="stylesheet" href="../../assets/css/junta.css">
</head>
<body>
    <div class="junta-wrapper">
        <div class="junta-shell">
            
            <div class="topbar">
                <div>
                    <h1>Junta Nacional</h1>
                    <p>Gestión de miembros, cargos y periodos</p>
                </div>
                <a href="../../dashboard/dashboard.php" class="btn btn-secondary">Volver al panel</a>
            </div>

            <?php if (!empty($mensaje)): ?>
                <div class="alert success"><?php echo $mensaje; ?></div>
            <?php endif; ?>

            <div class="content-grid">
                <div class="panel form-panel">
                    <div class="panel-header">
                        <h2><?php echo $modo_edicion ? 'Editar Miembro' : 'Registrar Miembro'; ?></h2>
                        <p><?php echo $modo_edicion ? 'Actualiza la información del integrante' : 'Completa los datos del nuevo integrante'; ?></p>
                    </div>

                    <form id="formJunta" method="POST" action="<?php echo $modo_edicion ? 'actualizar.php' : 'guardar.php'; ?>" class="junta-form">
                        <?php if ($modo_edicion): ?>
                            <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="usuario_id">Usuario</label>
                            <select name="usuario_id" id="usuario_id" required>
                                <option value="">Seleccionar usuario</option>
                                <?php if($usuarios): ?>
                                    <?php while($u = $usuarios->fetch_assoc()): ?>
                                        <option value="<?php echo $u['id']; ?>" <?php echo ($registro['usuario_id'] == $u['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($u['nombres'] . ' ' . $u['apellidos']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cargo_id">Cargo</label>
                            <select name="cargo_id" id="cargo_id" required>
                                <option value="">Seleccionar cargo</option>
                                <?php if($cargos): ?>
                                    <?php while($c = $cargos->fetch_assoc()): ?>
                                        <option value="<?php echo $c['id']; ?>" <?php echo ($registro['cargo_id'] == $c['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars(ucfirst($c['nombre'])); ?>
                                        </option>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="periodo_inicio">Periodo inicio</label>
                                <input type="date" name="periodo_inicio" id="periodo_inicio" value="<?php echo htmlspecialchars($registro['periodo_inicio']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="periodo_fin">Periodo fin</label>
                                <input type="date" name="periodo_fin" id="periodo_fin" value="<?php echo htmlspecialchars($registro['periodo_fin']); ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="activo">Estado</label>
                            <select name="activo" id="activo">
                                <option value="1" <?php echo ($registro['activo'] == 1) ? 'selected' : ''; ?>>Activo</option>
                                <option value="0" <?php echo ($registro['activo'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                        </div>

                        <div class="form-actions">
                            <?php if ($modo_edicion): ?>
                                <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            <?php else: ?>
                                <button type="reset" class="btn btn-secondary">Limpiar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <div class="panel table-panel">
                    <div class="panel-header panel-header-flex">
                        <div>
                            <h2>Listado de Miembros</h2>
                            <p>Consulta y administra los registros de la junta</p>
                        </div>
                        <div class="table-tools">
                            <input type="text" id="buscadorTabla" class="table-search" placeholder="Buscar usuario, cargo o estado...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="junta-table" id="tablaJunta">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Cargo</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Estado</th>
                                    <th>Foto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($result && $result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td data-label="Usuario">
                                                <?php echo !empty($row['nombres']) ? htmlspecialchars($row['nombres'].' '.$row['apellidos']) : 'Usuario no encontrado'; ?>
                                            </td>
                                            <td data-label="Cargo"><?php echo htmlspecialchars($row['cargo_nombre'] ?? 'Sin cargo'); ?></td>
                                            <td data-label="Inicio"><?php echo htmlspecialchars($row['periodo_inicio']); ?></td>
                                            <td data-label="Fin"><?php echo htmlspecialchars($row['periodo_fin']); ?></td>
                                            <td data-label="Estado">
                                                <span class="badge <?php echo $row['activo'] ? 'badge-active' : 'badge-inactive'; ?>">
                                                    <?php echo $row['activo'] ? 'Activo' : 'Inactivo'; ?>
                                                </span>
                                            </td>
                                            <td data-label="Foto">
                                                <?php if(!empty($row['foto_usuario'])): ?>
                                                    <img src="../../uploads/<?php echo htmlspecialchars($row['foto_usuario']); ?>" class="user-photo" alt="Foto de usuario">
                                                <?php else: ?>
                                                    <span class="no-photo">Sin foto</span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Acciones">
                                                <div class="action-buttons">
                                                    <a href="listar.php?editar=<?php echo $row['id']; ?>" class="btn-action edit">Editar</a>
                                                    <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn-action delete btn-eliminar">Eliminar</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="empty-table">No hay miembros registrados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../../assets/js/junta.js"></script>
</body>
</html>