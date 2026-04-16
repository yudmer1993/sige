<?php
include("../../includes/auth.php");
include("../../config/database.php");

$sql = "SELECT * FROM iglesias ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Iglesias</title>
    <link rel="stylesheet" href="../../assets/css/iglesias.css">
</head>
<body>

<div class="page-wrapper">
    <div class="container">
        <div class="header-panel">
            <div>
                <h1>Listado de Iglesias</h1>
                <p class="subtitle">Gestión y administración de iglesias registradas</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-gold" onclick="abrirModalCrear()">+ Nueva Iglesia</button>
                <a href="../../dashboard/dashboard.php" class="btn btn-silver">Volver al Dashboard</a>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>País</th>
                            <th>Ciudad</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0) { ?>
                            <?php while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["pais"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["ciudad"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["telefono"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                    <td>
                                        <span class="badge-status">
                                            <?php echo htmlspecialchars($row["estado"]); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button
                                            class="btn btn-edit"
                                            onclick="abrirModalEditar(
                                                '<?php echo $row['id']; ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['nombre'])); ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['pais'])); ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['ciudad'])); ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['direccion'])); ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['telefono'])); ?>',
                                                '<?php echo htmlspecialchars(addslashes($row['email'])); ?>',
                                                '<?php echo $row['fecha_fundacion']; ?>'
                                            )"
                                        >
                                            Editar
                                        </button>

                                        <a
                                            href="eliminar.php?id=<?php echo $row["id"]; ?>"
                                            class="btn btn-delete"
                                            onclick="return confirm('¿Está seguro de eliminar esta iglesia?');"
                                        >
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="empty-message">No hay iglesias registradas.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR -->
<div class="modal" id="modalCrear">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Registrar Iglesia</h2>
            <span class="close" onclick="cerrarModalCrear()">&times;</span>
        </div>

        <form method="POST" action="guardar.php" class="form-grid">
            <div class="form-group">
                <label>Nombre Iglesia</label>
                <input type="text" name="nombre" placeholder="Ingrese nombre de la iglesia" required>
            </div>

            <div class="form-group">
                <label>País</label>
                <input type="text" name="pais" placeholder="Ingrese país">
            </div>

            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" name="ciudad" placeholder="Ingrese ciudad">
            </div>

            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" placeholder="Ingrese dirección">
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" placeholder="Ingrese teléfono">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Ingrese email">
            </div>

            <div class="form-group">
                <label>Fecha Fundación</label>
                <input type="date" name="fecha_fundacion">
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="cerrarModalCrear()">Cancelar</button>
                <button type="submit" class="btn btn-gold">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR -->
<div class="modal" id="modalEditar">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Iglesia</h2>
            <span class="close" onclick="cerrarModalEditar()">&times;</span>
        </div>

        <form method="POST" action="actualizar.php" class="form-grid">
            <input type="hidden" name="id" id="edit_id">

            <div class="form-group">
                <label>Nombre Iglesia</label>
                <input type="text" name="nombre" id="edit_nombre" required>
            </div>

            <div class="form-group">
                <label>País</label>
                <input type="text" name="pais" id="edit_pais">
            </div>

            <div class="form-group">
                <label>Ciudad</label>
                <input type="text" name="ciudad" id="edit_ciudad">
            </div>

            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" id="edit_direccion">
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" id="edit_telefono">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="edit_email">
            </div>

            <div class="form-group">
                <label>Fecha Fundación</label>
                <input type="date" name="fecha_fundacion" id="edit_fecha_fundacion">
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-cancel" onclick="cerrarModalEditar()">Cancelar</button>
                <button type="submit" class="btn btn-gold">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script src="../../assets/js/iglesias.js"></script>
</body>
</html>