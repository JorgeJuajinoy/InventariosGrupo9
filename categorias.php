<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include("conexion.php");

// Manejo de error si la conexión falla (aunque conexion.php debería manejarlo)
if ($conn->connect_error) {
    echo json_encode(["exito" => false, "mensaje" => "Error de conexión: " . $conn->connect_error]);
    exit();
}

// Extraer categorías únicas
$sql = "SELECT DISTINCT categoria FROM productos ORDER BY categoria ASC";
$result = $conn->query($sql);

$categorias = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row["categoria"];
    }
    echo json_encode(["exito" => true, "data" => $categorias]);
} else {
    echo json_encode(["exito" => false, "mensaje" => "Error al consultar categorías: " . $conn->error]);
}

$conn->close();
?>

