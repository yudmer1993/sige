<?php
include("../../includes/auth.php");
include("../../config/database.php");

$id        = $_POST['id'] ?? 0;
$usuario   = trim($_POST['usuario'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = $_POST['password'] ?? '';
$nombres   = trim($_POST['nombres'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$telefono  = trim($_POST['telefono'] ?? '');
$rol       = trim($_POST['rol'] ?? '');
$estado    = trim($_POST['estado'] ?? '');

if (!is_numeric($id) || $id <= 0) {
    die("ID inválido.");
}

$stmtFoto = $conn->prepare("SELECT foto FROM usuarios WHERE id = ?");
$stmtFoto->bind_param("i", $id);
$stmtFoto->execute();
$resultFoto = $stmtFoto->get_result();
$usuario_actual = $resultFoto->fetch_assoc();
$stmtFoto->close();

if (!$usuario_actual) {
    die("Usuario no encontrado.");
}

$foto = $usuario_actual['foto'];

if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
    $nombre_foto = time() . "_" . basename($_FILES['foto']['name']);
    $ruta = "../../uploads/" . $nombre_foto;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
        if (!empty($foto) && file_exists("../../uploads/" . $foto)) {
            @unlink("../../uploads/" . $foto);
        }
        $foto = $nombre_foto;
    }
}

if (!empty($password)) {
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE usuarios 
                            SET usuario=?, email=?, password=?, nombres=?, apellidos=?, telefono=?, rol=?, estado=?, foto=? 
                            WHERE id=?");
    $stmt->bind_param("sssssssssi", $usuario, $email, $pass_hash, $nombres, $apellidos, $telefono, $rol, $estado, $foto, $id);
} else {
    $stmt = $conn->prepare("UPDATE usuarios 
                            SET usuario=?, email=?, nombres=?, apellidos=?, telefono=?, rol=?, estado=?, foto=? 
                            WHERE id=?");
    $stmt->bind_param("ssssssssi", $usuario, $email, $nombres, $apellidos, $telefono, $rol, $estado, $foto, $id);
}

if ($stmt->execute()) {
    $stmt->close();
    header("Location:listar.php");
    exit;
} else {
    $stmt->close();
    die("Error al actualizar el usuario.");
}