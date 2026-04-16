<?php
include("../../includes/auth.php");
include("../../config/database.php");

$sql = "SELECT id, usuario, email, nombres, apellidos, telefono, rol, estado, foto 
        FROM usuarios 
        ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../../assets/css/usuarios.css">
</head>
<body>

<div class="contenedor-principal">
    <div class="encabezado">
        <h2>Gestión de Usuarios</h2>
        <button class="btn-nuevo" onclick="abrirModal()">+ Nuevo Usuario</button>
    </div>

    <div class="tabla-container">
        <table class="tabla-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= (int)$row['id'] ?></td>
                            <td><?= htmlspecialchars($row['usuario']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['nombres']) ?></td>
                            <td><?= htmlspecialchars($row['apellidos']) ?></td>
                            <td><?= htmlspecialchars($row['telefono']) ?></td>
                            <td>
                                <span class="badge badge-rol">
                                    <?= ucfirst(htmlspecialchars($row['rol'])) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    <?= $row['estado'] === 'activo' ? 'badge-activo' : '' ?>
                                    <?= $row['estado'] === 'inactivo' ? 'badge-inactivo' : '' ?>
                                    <?= $row['estado'] === 'bloqueado' ? 'badge-bloqueado' : '' ?>">
                                    <?= ucfirst(htmlspecialchars($row['estado'])) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($row['foto'])): ?>
                                    <img src="../../uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto usuario" class="foto-tabla">
                                <?php else: ?>
                                    <span class="texto-suave">Sin foto</span>
                                <?php endif; ?>
                            </td>
                            <td class="acciones">
                                <a href="#" class="btn-editar" onclick="abrirEditar(<?= (int)$row['id'] ?>); return false;">Editar</a>
                                <a href="eliminar.php?id=<?= (int)$row['id'] ?>" 
                                   class="btn-eliminar"
                                   onclick="return confirm('¿Eliminar usuario?')">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="sin-registros">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="contenedor-volver">
        <a href="../../dashboard/dashboard.php" class="btn-volver">Volver</a>
    </div>
</div>

<!-- MODAL NUEVO USUARIO -->
<div id="modalUsuario" class="modal">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarModal()">×</span>

        <h2>Registrar Usuario</h2>

        <form method="POST" action="guardar.php" enctype="multipart/form-data">
            <label>Usuario</label>
            <input type="text" name="usuario" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <label>Nombres</label>
            <input type="text" name="nombres" required>

            <label>Apellidos</label>
            <input type="text" name="apellidos" required>

            <label>Teléfono</label>
            <input type="text" name="telefono">

            <label>Rol</label>
            <select name="rol" required>
                <option value="admin">Admin</option>
                <option value="junta">Junta</option>
                <option value="ministro">Ministro</option>
                <option value="creyente">Creyente</option>
            </select>

            <label>Estado</label>
            <select name="estado" required>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <option value="bloqueado">Bloqueado</option>
            </select>

            <label>Foto</label>
            <input type="file" name="foto" accept="image/*">

            <button type="submit">Guardar Usuario</button>
        </form>
    </div>
</div>

<!-- MODAL EDITAR -->
<div id="modalEditar" class="modal">
    <div class="modal-contenido">
        <span class="cerrar" onclick="cerrarEditar()">×</span>
        <h2>Editar Usuario</h2>
        <div id="contenidoEditar"></div>
    </div>
</div>

<script src="../../assets/js/usuarios.js"></script>
</body>
</html>