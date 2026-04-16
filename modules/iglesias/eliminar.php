<?php
include("../../config/database.php");

$id = $_GET["id"];

$sql = "DELETE FROM iglesias WHERE id = $id";
$conn->query($sql);

header("Location: listar.php");
exit;
?>