<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "if0_40354658_inventarios_grupo9"; // nombre exacto de tu BD

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Conexión fallida: " . $conn->connect_error
    ]);
    exit;
}
?>

