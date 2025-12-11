<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/conexion.php';

$termino = isset($_GET['q']) ? trim($_GET['q']) : "";

if ($termino !== "") {
    $sql = "SELECT id, nombre, marca, categoria, descripcion, precio, stock 
            FROM productos 
            WHERE LOWER(nombre) LIKE LOWER(?) 
               OR LOWER(marca) LIKE LOWER(?) 
               OR LOWER(categoria) LIKE LOWER(?) 
               OR LOWER(descripcion) LIKE LOWER(?)";
    $stmt = $conn->prepare($sql);
    $like = "%" . $termino . "%";
    $stmt->bind_param("ssss", $like, $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT id, nombre, marca, categoria, descripcion, precio, stock 
            FROM productos";
    $result = $conn->query($sql);
}

$productos = [];
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
}

echo json_encode([
    "exito" => count($productos) > 0,
    "productos" => $productos
]);

$conn->close();
?>
