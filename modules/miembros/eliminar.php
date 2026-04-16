<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id = $_GET['id'] ?? 0;
if($id == 0){
    header("Location: listar.php");
    exit;
}

$stmt = $conn->prepare("SELECT foto FROM miembros WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$miembro = $result->fetch_assoc();
$stmt->close();

if($miembro && $miembro['foto'] != "" && file_exists("../../uploads/".$miembro['foto'])){
    unlink("../../uploads/".$miembro['foto']);
}

$stmt = $conn->prepare("DELETE FROM miembros WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: listar.php");
exit;
?>