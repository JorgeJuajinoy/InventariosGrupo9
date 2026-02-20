<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include("conexion.php");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$sql = "SELECT id, nombre, marca, precio, categoria, cantidad FROM productos LIMIT 10";
$result = $conn->query($sql);

$productos = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

echo json_encode($productos);
$conn->close();
?>

