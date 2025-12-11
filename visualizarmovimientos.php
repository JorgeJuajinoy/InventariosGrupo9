<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/conexion.php'; // usa $conn

$sql = "SELECT m.id, p.nombre, m.tipo, m.cantidad, m.fecha
        FROM movimientos m
        JOIN productos p ON m.id_producto = p.id
        ORDER BY m.fecha DESC
        LIMIT 20";

$result = $conn->query($sql);

$movimientos = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $movimientos[] = $row;
    }
    echo json_encode(["success" => true, "data" => $movimientos]);
} else {
    echo json_encode(["success" => false, "message" => "Error en la consulta: " . $conn->error]);
}

$conn->close();
?>
