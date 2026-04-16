<?php
include("../../includes/auth.php");
include("../../config/database.php");

$usuario   = trim($_POST['usuario'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$nombres   = trim($_POST['nombres'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$telefono  = trim($_POST['telefono'] ?? '');
$rol       = trim($_POST['rol'] ?? '');
$estado    = trim($_POST['estado'] ?? '');

if ($usuario === '' || $email === '' || $password === '' || $nombres === '' || $apellidos === '') {
    die("Todos los campos obligatorios deben estar completos.");
}

$passHash = password_hash($password, PASSWORD_DEFAULT);

$foto = "";
if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
    $nombre_foto = time() . "_" . basename($_FILES['foto']['name']);
    $ruta = "../../uploads/" . $nombre_foto;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
        $foto = $nombre_foto;
    }
}

$stmt = $conn->prepare("INSERT INTO usuarios (usuario, email, password, nombres, apellidos, telefono, rol, estado, foto)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $usuario, $email, $passHash, $nombres, $apellidos, $telefono, $rol, $estado, $foto);

if ($stmt->execute()) {
    $stmt->close();
    header("Location:listar.php");
    exit;
} else {
    $stmt->close();
    die("Error al guardar el usuario.");
}