<?php
include("../../config/database.php");

$usuario_id = $_POST['usuario_id'];
$tipo_ministro = $_POST['tipo_ministro'];
$iglesia_dirige = $_POST['iglesia_dirige'] ?: NULL;
$fecha_ordenacion = $_POST['fecha_ordenacion'];
$telefono = $_POST['telefono'];
$pais_mision = $_POST['pais_mision'];
$estado_ministerial = $_POST['estado_ministerial'];

$stmt = $conn->prepare("INSERT INTO ministros(usuario_id,tipo_ministro,iglesia_dirige,fecha_ordenacion,telefono,pais_mision,estado_ministerial) VALUES(?,?,?,?,?,?,?)");
$stmt->bind_param("isissss", $usuario_id, $tipo_ministro, $iglesia_dirige, $fecha_ordenacion, $telefono, $pais_mision, $estado_ministerial);
$stmt->execute();
$stmt->close();

header("Location: listar.php");
exit;
?>