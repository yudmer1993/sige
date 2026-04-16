<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id = $_GET['id'] ?? 0;

if (!is_numeric($id) || $id <= 0) {
    exit("<p>ID inválido.</p>");
}

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    exit("<p>Usuario no encontrado.</p>");
}
?>

<form method="POST" action="actualizar.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">

    <label>Usuario</label>
    <input type="text" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

    <label>Contraseña (dejar vacío si no cambia)</label>
    <input type="password" name="password">

    <label>Nombres</label>
    <input type="text" name="nombres" value="<?= htmlspecialchars($usuario['nombres']) ?>" required>

    <label>Apellidos</label>
    <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos']) ?>" required>

    <label>Teléfono</label>
    <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>">

    <label>Rol</label>
    <select name="rol" required>
        <option value="admin" <?= $usuario['rol'] == "admin" ? "selected" : "" ?>>Admin</option>
        <option value="junta" <?= $usuario['rol'] == "junta" ? "selected" : "" ?>>Junta</option>
        <option value="ministro" <?= $usuario['rol'] == "ministro" ? "selected" : "" ?>>Ministro</option>
        <option value="creyente" <?= $usuario['rol'] == "creyente" ? "selected" : "" ?>>Creyente</option>
    </select>

    <label>Estado</label>
    <select name="estado" required>
        <option value="activo" <?= $usuario['estado'] == "activo" ? "selected" : "" ?>>Activo</option>
        <option value="inactivo" <?= $usuario['estado'] == "inactivo" ? "selected" : "" ?>>Inactivo</option>
        <option value="bloqueado" <?= $usuario['estado'] == "bloqueado" ? "selected" : "" ?>>Bloqueado</option>
    </select>

    <label>Foto actual</label>
    <?php if (!empty($usuario['foto'])): ?>
        <div class="foto-actual">
            <img src="../../uploads/<?= htmlspecialchars($usuario['foto']) ?>" width="70" alt="Foto actual">
        </div>
    <?php else: ?>
        <p class="texto-suave">Sin foto</p>
    <?php endif; ?>

    <label>Cambiar Foto</label>
    <input type="file" name="foto" accept="image/*">

    <button type="submit">Actualizar Usuario</button>
</form>