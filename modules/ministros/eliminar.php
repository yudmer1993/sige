<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id = $_GET['id'] ?? 0;
if($id == 0){
    header("Location:listar.php");
    exit;
}

$stmt = $conn->prepare("DELETE FROM ministros WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location:listar.php");
exit;
?>