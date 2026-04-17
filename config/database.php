<?php

$host = "sql111.infinityfree.com";
$user = "if0_40485369";
$pass = "Erestodo001"; // cámbiala
$db   = "if0_40485369_iglesia";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>