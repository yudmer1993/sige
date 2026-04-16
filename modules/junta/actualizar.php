<?php
include("../../config/database.php");

$id = $_POST['id'] ?? '';
$usuario_id = $_POST['usuario_id'] ?? '';
$cargo_id = $_POST['cargo_id'] ?? '';
$periodo_inicio = $_POST['periodo_inicio'] ?? '';
$periodo_fin = $_POST['periodo_fin'] ?? '';
$activo = $_POST['activo'] ?? '1';

if (empty($id) || empty($usuario_id) || empty($cargo_id) || empty($periodo_inicio) || empty($periodo_fin)) {
    die("Faltan datos obligatorios.");
}

$sql = "UPDATE junta_nacional SET
        usuario_id = '$usuario_id',
        cargo_id = '$cargo_id',
        periodo_inicio = '$periodo_inicio',
        periodo_fin = '$periodo_fin',
        activo = '$activo'
        WHERE id = '$id'";

if ($conn->query($sql)) {
    header("Location: listar.php?ok=2");
    exit;
} else {
    echo "Error al actualizar: " . $conn->error;
}
?>