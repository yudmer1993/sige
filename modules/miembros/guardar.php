<?php
include("../../config/database.php");

$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$dni = $_POST["dni"];
$fecha_nacimiento = $_POST["fecha_nacimiento"];
$genero = $_POST["genero"];
$estado_civil = $_POST["estado_civil"];
$telefono = $_POST["telefono"];
$email = $_POST["email"];
$direccion = $_POST["direccion"];
$pais = $_POST["pais"];
$ciudad = $_POST["ciudad"];
$ministerio = $_POST["ministerio"];
$estado_miembro = $_POST["estado_miembro"];

$foto = "";
if($_FILES["foto"]["name"] != ""){
    $allowed = ["jpg","jpeg","png","gif"];
    $ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

    if(in_array($ext, $allowed)){
        $nombre_foto = time()."_".$_FILES["foto"]["name"];
        $ruta = "../../uploads/".$nombre_foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $ruta);
        $foto = $nombre_foto;
    }
}

$stmt = $conn->prepare("INSERT INTO miembros(
    nombres, apellidos, dni, fecha_nacimiento, genero, estado_civil,
    telefono, email, direccion, pais, ciudad, ministerio, foto, estado_miembro
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$stmt->bind_param("ssssssssssssss",
    $nombres, $apellidos, $dni, $fecha_nacimiento, $genero, $estado_civil,
    $telefono, $email, $direccion, $pais, $ciudad, $ministerio, $foto, $estado_miembro
);

$stmt->execute();
$stmt->close();

header("Location: listar.php");
exit;
?>