<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// ✅ CONEXIÓN SEGURA (RUTA ABSOLUTA)
require_once $_SERVER['DOCUMENT_ROOT'] . "/sige/config/database.php";

// ✅ SI YA ESTÁ LOGUEADO
if(isset($_SESSION['usuario'])){
    header("Location: ../dashboard/dashboard.php");
    exit();
}

$error_msg = "";

// ✅ PROCESO LOGIN
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    if($usuario == "" || $password == ""){
        $error_msg = "Complete todos los campos";
    } else {

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario=? AND estado='activo' LIMIT 1");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result && $result->num_rows > 0) {

            $user = $result->fetch_assoc();

            // ✅ VERIFICAR PASSWORD ENCRIPTADO
            if(password_verify($password, $user["password"])) {

                // 🔐 CREAR SESIÓN
                $_SESSION["usuario"] = $user["usuario"];
                $_SESSION["rol"]     = $user["rol"];
                $_SESSION["nombre"]  = $user["nombres"];
                $_SESSION["id"]      = $user["id"];

                // 🚀 REDIRECCIÓN
                header("Location: ../dashboard/dashboard.php");
                exit();

            } else {
                $error_msg = "❌ Contraseña incorrecta";
            }

        } else {
            $error_msg = "❌ Usuario no existe o está inactivo";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login - SIGE</title>

<link rel="stylesheet" href="/sige/assets/css/login.css">
</head>

<body>

<div class="login-container">

    <h2>🔐 SIGE - Ingreso</h2>

    <?php if($error_msg != ""): ?>
        <div class="error"><?= $error_msg ?></div>
    <?php endif; ?>

    <form method="POST">

        <input type="text" name="usuario" placeholder="Usuario" required>

        <input type="password" name="password" placeholder="Contraseña" required>

        <button type="submit">Ingresar</button>

    </form>

    <div class="footer">
        © <?= date('Y') ?> Sistema SIGE
    </div>

</div>

<script src="/sige/assets/js/login.js"></script>

</body>
</html>