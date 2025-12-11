<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/conexion.php';

// Total de productos
$sqlTotal = "SELECT COUNT(*) AS total_productos FROM productos";
$resTotal = $conn->query($sqlTotal);
$totalProductos = $resTotal->fetch_assoc()["total_productos"] ?? 0;

// Stock total
$sqlStock = "SELECT SUM(stock) AS stock_total FROM productos";
$resStock = $conn->query($sqlStock);
$stockTotal = $resStock->fetch_assoc()["stock_total"] ?? 0;

// Producto con mayor stock
$sqlMayor = "SELECT nombre, stock FROM productos ORDER BY stock DESC LIMIT 1";
$resMayor = $conn->query($sqlMayor);
$productoMayor = $resMayor->fetch_assoc();

echo json_encode([
  "success" => true,
  "data" => [
    "total_productos" => $totalProductos,
    "stock_total" => $stockTotal,
    "producto_mayor" => $productoMayor
  ]
]);

$conn->close();
?>
