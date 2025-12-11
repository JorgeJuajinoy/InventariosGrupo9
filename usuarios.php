<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/conexion.php';

$sql = "SELECT id, nombre, correo, rol FROM usuarios ORDER BY nombre ASC";
$result = $conn->query($sql);

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode(["success" => true, "data" => $usuarios]);

$conn->close();
?>
