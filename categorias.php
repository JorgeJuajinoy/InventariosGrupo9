<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include("conexion.php");

// Extraer categorías únicas
$sql = "SELECT DISTINCT categoria FROM productos ORDER BY categoria ASC";
$result = $conn->query($sql);

$categorias = [];
while ($row = $result->fetch_assoc()) {
    $categorias[] = $row["categoria"];
}

echo json_encode(["exito" => true, "data" => $categorias]);
?>

