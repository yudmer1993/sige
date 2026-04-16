<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id = $_GET['id'] ?? 0;

if (!$id || !is_numeric($id)) {
    header("Location: listar.php");
    exit;
}

$sql = "DELETE FROM junta_nacional WHERE id = '$id'";

if ($conn->query($sql)) {
    header("Location: listar.php?ok=3");
    exit;
} else {
    echo "Error al eliminar: " . $conn->error;
}
?>