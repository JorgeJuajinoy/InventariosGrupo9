<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
require_once __DIR__ . '/conexion.php'; // usa $conn

$umbral = isset($_GET['umbral']) ? intval($_GET['umbral']) : 5;

$sql = "SELECT id, nombre, marca, categoria, stock
        FROM productos
        WHERE stock < ?
        ORDER BY stock ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $umbral);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode(["success" => true, "data" => $productos]);

$conn->close();
?>
