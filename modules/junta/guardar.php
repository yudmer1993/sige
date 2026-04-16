<?php
include("../../config/database.php");

$usuario_id = $_POST['usuario_id'] ?? '';
$cargo_id = $_POST['cargo_id'] ?? '';
$periodo_inicio = $_POST['periodo_inicio'] ?? '';
$periodo_fin = $_POST['periodo_fin'] ?? '';
$activo = $_POST['activo'] ?? '1';

if (empty($usuario_id) || empty($cargo_id) || empty($periodo_inicio) || empty($periodo_fin)) {
    die("Faltan datos obligatorios.");
}

$sql = "INSERT INTO junta_nacional (usuario_id, cargo_id, periodo_inicio, periodo_fin, activo)
        VALUES ('$usuario_id', '$cargo_id', '$periodo_inicio', '$periodo_fin', '$activo')";

if ($conn->query($sql)) {
    header("Location: listar.php?ok=1");
    exit;
} else {
    echo "Error al guardar: " . $conn->error;
}
?>