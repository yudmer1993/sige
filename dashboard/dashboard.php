<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: /sige/auth/login.php");
    exit();
}

require_once __DIR__ . "/../config/database.php";

// OBTENER USUARIO
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario=? LIMIT 1");
$stmt->bind_param("s", $_SESSION['usuario']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// métricas
$usuarios  = $conn->query("SELECT COUNT(*) total FROM usuarios")->fetch_assoc()['total'];
$miembros  = $conn->query("SELECT COUNT(*) total FROM miembros")->fetch_assoc()['total'];
$ministros = $conn->query("SELECT COUNT(*) total FROM ministros")->fetch_assoc()['total'];
$iglesias  = $conn->query("SELECT COUNT(*) total FROM iglesias")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard SIGE</title>

<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>SIGE</h2>

    <a href="../modules/usuarios/listar.php">👤 Usuarios</a>
    <a href="../modules/miembros/listar.php">👥 Miembros</a>
    <a href="../modules/ministros/listar.php">⛪ Ministros</a>
    <a href="../modules/iglesias/listar.php">🏛 Iglesias</a>
    <a href="../modules/junta/listar.php">📋 Junta</a>
</div>

<!-- MAIN -->
<div class="main">

    <!-- HEADER -->
    <div class="header">

        <div class="user-info">
            <img src="/sige/<?= !empty($user['foto']) ? $user['foto'] : 'assets/img/user.png' ?>" class="avatar">
            <div>
                <b><?= $_SESSION['nombre']; ?></b><br>
                <small><?= $_SESSION['rol']; ?></small>
            </div>
        </div>

        <a href="../auth/logout.php" class="logout">Cerrar sesión</a>
    </div>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h4>👤 Usuarios</h4>
            <h2><?= $usuarios ?></h2>
            <p>Usuarios registrados en el sistema</p>
        </div>

        <div class="card">
            <h4>👥 Miembros</h4>
            <h2><?= $miembros ?></h2>
            <p>Personas activas en la iglesia</p>
        </div>

        <div class="card">
            <h4>⛪ Ministros</h4>
            <h2><?= $ministros ?></h2>
            <p>Líderes y servidores</p>
        </div>

        <div class="card">
            <h4>🏛 Iglesias</h4>
            <h2><?= $iglesias ?></h2>
            <p>Sedes registradas</p>
        </div>

    </div>

    <!-- BIENVENIDA -->
    <div class="welcome">
        <h2>📊 Panel de Control</h2>
        <p>Gestiona usuarios, miembros, iglesias y más desde este panel.</p>
    </div>

    <!-- CONTENIDO -->
    <iframe id="frame"></iframe>

</div>

<script src="../assets/js/dashboard.js"></script>

</body>
</html>