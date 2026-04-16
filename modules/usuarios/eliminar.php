<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id = $_GET['id'] ?? 0;

if (!is_numeric($id) || $id <= 0) {
    header("Location:listar.php");
    exit;
}

$stmtFoto = $conn->prepare("SELECT foto FROM usuarios WHERE id = ?");
$stmtFoto->bind_param("i", $id);
$stmtFoto->execute();
$resultFoto = $stmtFoto->get_result();
$usuario_actual = $resultFoto->fetch_assoc();
$stmtFoto->close();

if ($usuario_actual && !empty($usuario_actual['foto'])) {
    $rutaFoto = "../../uploads/" . $usuario_actual['foto'];
    if (file_exists($rutaFoto)) {
        @unlink($rutaFoto);
    }
}

$stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location:listar.php");
exit;