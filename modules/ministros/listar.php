<?php
include("../../includes/auth.php");
include("../../config/database.php");

$sql = "SELECT m.*, 
               u.nombres, u.apellidos, u.foto AS foto_usuario,
               i.nombre AS iglesia_nombre
        FROM ministros m
        LEFT JOIN usuarios u ON m.usuario_id = u.id
        LEFT JOIN iglesias i ON m.iglesia_dirige = i.id
        ORDER BY m.id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ministros</title>
    <link rel="stylesheet" href="../../assets/css/ministros.css">
</head>
<body>

<div class="page-wrapper">
    <div class="container">
        <div class="header-panel">
            <div>
                <h1>Gestión de Ministros</h1>
                <p class="subtitle">Administración y control de ministros registrados</p>
            </div>

            <div class="header-actions">
                <button class="btn btn-gold" onclick="abrirModalCrear()">+ Nuevo Ministro</button>
                <a href="../../dashboard/dashboard.php" class="btn btn-silver">Volver al Dashboard</a>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Tipo</th>
                            <th>Iglesia</th>
                            <th>Fecha Ordenación</th>
                            <th>Teléfono</th>
                            <th>País Misión</th>
                            <th>Estado</th>
                            <th>Foto</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>

                                    <td><?php echo htmlspecialchars($row['nombres'] . " " . $row['apellidos']); ?></td>

                                    <td>
                                        <span class="badge-type">
                                            <?php echo ucfirst(htmlspecialchars($row['tipo_ministro'])); ?>
                                        </span>
                                    </td>

                                    <td><?php echo !empty($row['iglesia_nombre']) ? htmlspecialchars($row['iglesia_nombre']) : '-'; ?></td>

                                    <td><?php echo htmlspecialchars($row['fecha_ordenacion']); ?></td>

                                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>

                                    <td><?php echo htmlspecialchars($row['pais_mision']); ?></td>

                                    <td>
                                        <span class="badge-status <?php echo $row['estado_ministerial'] == 'activo' ? 'activo' : 'inactivo'; ?>">
                                            <?php echo ucfirst(htmlspecialchars($row['estado_ministerial'])); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php if(!empty($row['foto_usuario'])): ?>
                                            <img src="../../uploads/<?php echo htmlspecialchars($row['foto_usuario']); ?>" class="avatar" alt="Foto usuario">
                                        <?php else: ?>
                                            <span class="no-photo">Sin foto</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <button class="btn btn-edit" onclick="editarMinistro(<?php echo $row['id']; ?>)">Editar</button>

                                        <a class="btn btn-delete"
                                           href="eliminar.php?id=<?php echo $row['id']; ?>"
                                           onclick="return confirm('¿Eliminar ministro?')">
                                           Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="empty-message">No hay ministros registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR -->
<div id="modalCrear" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Registrar Ministro</h2>
            <span class="close" onclick="cerrarModalCrear()">×</span>
        </div>
        <div id="contenidoCrear"></div>
    </div>
</div>

<!-- MODAL EDITAR -->
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Ministro</h2>
            <span class="close" onclick="cerrarModalEditar()">×</span>
        </div>
        <div id="contenidoEditar"></div>
    </div>
</div>

<script src="../../assets/js/ministros.js"></script>
</body>
</html>