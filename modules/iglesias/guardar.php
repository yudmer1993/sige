<?php
include("../../config/database.php");

$nombre = $_POST["nombre"];
$pais = $_POST["pais"];
$ciudad = $_POST["ciudad"];
$direccion = $_POST["direccion"];
$telefono = $_POST["telefono"];
$email = $_POST["email"];
$fecha_fundacion = $_POST["fecha_fundacion"];

$sql = "INSERT INTO iglesias 
(nombre, pais, ciudad, direccion, telefono, email, fecha_fundacion) 
VALUES 
('$nombre', '$pais', '$ciudad', '$direccion', '$telefono', '$email', '$fecha_fundacion')";

$conn->query($sql);

header("Location: listar.php");
exit;
?>