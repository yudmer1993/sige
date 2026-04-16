<?php
include("../../includes/auth.php");
include("../../config/database.php");

$sql = "SELECT * FROM miembros ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miembros</title>
    <link rel="stylesheet" href="../../assets/css/miembros.css">
</head>
<body>

<div class="page-wrapper">
    <div class="container">
        <div class="header-panel">
            <div>
                <h1>Gestión de Miembros</h1>
                <p class="subtitle">Administración y control de miembros registrados</p>
            </div>

            <div class="header-actions">
                <button class="btn btn-gold" onclick="abrirModalCrear()">+ Nuevo Miembro</button>
                <a href="../../dashboard/dashboard.php" class="btn btn-silver">Volver al Dashboard</a>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Ciudad</th>
                            <th>Ministerio</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?php if(!empty($row['foto'])): ?>
                                            <img src="../../uploads/<?php echo htmlspecialchars($row['foto']); ?>" class="avatar" alt="Foto miembro">
                                        <?php else: ?>
                                            <span class="no-photo">Sin foto</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo htmlspecialchars($row['nombres']." ".$row['apellidos']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dni']); ?></td>
                                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ciudad']); ?></td>
                                    <td>
                                        <span class="badge-type">
                                            <?php echo !empty($row['ministerio']) ? htmlspecialchars($row['ministerio']) : 'Sin ministerio'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status <?php echo $row['estado_miembro'] == 'activo' ? 'activo' : 'inactivo'; ?>">
                                            <?php echo ucfirst(htmlspecialchars($row['estado_miembro'])); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-edit" onclick="abrirEditar(<?php echo $row['id']; ?>)">Editar</button>

                                        <a href="eliminar.php?id=<?php echo $row['id']; ?>"
                                           class="btn btn-delete"
                                           onclick="return confirm('¿Seguro que deseas eliminar este miembro?');">
                                           Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="empty-message">No hay miembros registrados</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR -->
<div id="modalMiembro" class="modal">
    <div class="modal-content">
        <div id="contenidoCrear"></div>
    </div>
</div>

<!-- MODAL EDITAR -->
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <div id="contenidoEditar"></div>
    </div>
</div>

<script src="../../assets/js/miembros.js"></script>
</body>
</html>