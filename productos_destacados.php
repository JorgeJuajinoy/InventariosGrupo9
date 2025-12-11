<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// tu conexión y consulta aquí...

header("Content-Type: application/json");
include("conexion.php"); // tu archivo de conexión a MySQL

$sql = "SELECT id, nombre, marca, precio, categoria, cantidad FROM productos LIMIT 10";
$result = $conn->query($sql);

$productos = [];
while($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode($productos);
$conn->close();
?>
