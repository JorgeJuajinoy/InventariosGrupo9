<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include("conexion.php");

// Extraer marcas únicas
$sql = "SELECT DISTINCT marca FROM productos ORDER BY marca ASC";
$result = $conn->query($sql);

$marcas = [];
while ($row = $result->fetch_assoc()) {
    $marcas[] = $row["marca"];
}

echo json_encode(["exito" => true, "data" => $marcas]);
?>

