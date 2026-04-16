<?php
include("../../config/database.php");

$id = $_POST["id"];

$nombre = $_POST["nombre"];
$pais = $_POST["pais"];
$ciudad = $_POST["ciudad"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$email = $_POST["email"];
$fecha_fundacion = $_POST["fecha_fundacion"];

$sql = "UPDATE iglesias SET
    nombre = '$nombre',
    pais = '$pais',
    ciudad = '$ciudad',
    direccion = '$direccion',
    telefono = '$telefono',
    email = '$email',
    fecha_fundacion = '$fecha_fundacion'
WHERE id = $id";

$conn->query($sql);

header("Location: listar.php");
exit;
?>