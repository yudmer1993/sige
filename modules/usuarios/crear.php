<?php
include("../../includes/auth.php");
include("../../config/database.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../../assets/css/usuarios.css">
</head>
<body>

<div class="form-container">
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

    <br>
    <a class="btn-volver" href="listar.php">Volver</a>
</div>

</body>
</html>