<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include("conexion.php"); // tu archivo de conexión

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir datos del formulario
    $nombre           = $_POST["nombre"] ?? "";
    $apellidos        = $_POST["apellidos"] ?? "";
    $correo           = $_POST["correo"] ?? "";
    $contrasena       = $_POST["contrasena"] ?? ""; // ⚠️ texto plano
    $rol              = $_POST["rol"] ?? "Cliente";
    $estado           = $_POST["estado"] ?? "activo";
    $telefono         = $_POST["telefono"] ?? "";
    $direccion        = $_POST["direccion"] ?? "";
    $fecha_nacimiento = $_POST["fecha_nacimiento"] ?? "";
    $genero           = $_POST["genero"] ?? "";

    // Capturar IP y navegador
    $ip_registro = $_SERVER['REMOTE_ADDR'] ?? '';
    $navegador   = $_SERVER['HTTP_USER_AGENT'] ?? '';

    // Insertar en la tabla usuarios
    $sql = "INSERT INTO usuarios 
        (nombre, apellidos, correo, contrasena, rol, estado, telefono, direccion, fecha_nacimiento, genero, ip_registro, navegador, creado_en, actualizado_en) 
        VALUES 
        ('$nombre', '$apellidos', '$correo', '$contrasena', '$rol', '$estado', '$telefono', '$direccion', '$fecha_nacimiento', '$genero', '$ip_registro', '$navegador', NOW(), NOW())";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["exito" => true, "mensaje" => "Usuario creado exitosamente"]);
    } else {
        echo json_encode(["exito" => false, "mensaje" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["exito" => false, "mensaje" => "Método no permitido"]);
}
?>



