<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    echo json_encode(["success" => false, "message" => "No llegaron datos"]);
    exit;
}

$nombre      = $input["nombre"] ?? "";
$marca       = $input["marca"] ?? "";
$categoria   = $input["categoria"] ?? "";
$precio      = floatval($input["precio"] ?? 0);
$cantidad    = intval($input["cantidad"] ?? 0);
$tipo        = strtolower($input["tipo_movimiento"] ?? ""); // normalizamos
$descripcion = $input["descripcion"] ?? "";

// Validar tipo de movimiento
if ($tipo !== "entrada" && $tipo !== "salida") {
    echo json_encode(["success" => false, "message" => "Tipo de movimiento inválido"]);
    exit;
}

require_once __DIR__ . '/conexion.php'; // usa $conn

// Buscar producto
$stmt = $conn->prepare("SELECT id, stock FROM productos WHERE nombre=?");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nuevoStock = $row["stock"];

    if ($tipo === "entrada") {
        $nuevoStock += $cantidad;
    } elseif ($tipo === "salida") {
        if ($cantidad > $row["stock"]) {
            echo json_encode(["success" => false, "message" => "Stock insuficiente"]);
            exit;
        }
        $nuevoStock -= $cantidad;
    }

    // Actualizar producto
    $update = $conn->prepare("UPDATE productos SET stock=?, cantidad=?, actualizado_en=NOW() WHERE id=?");
    $update->bind_param("iii", $nuevoStock, $cantidad, $row["id"]);
    $update->execute();

    // Registrar movimiento
    $log = $conn->prepare("INSERT INTO movimientos (id_producto, tipo, cantidad, fecha) VALUES (?, ?, ?, NOW())");
    $log->bind_param("isi", $row["id"], $tipo, $cantidad);
    if (!$log->execute()) {
        echo json_encode(["success" => false, "message" => "Error al registrar movimiento: " . $log->error]);
        exit;
    }

    echo json_encode(["success" => true, "message" => "Movimiento registrado correctamente"]);

} else {
    if ($tipo === "entrada") {
        // Insertar producto nuevo
        $insert = $conn->prepare("INSERT INTO productos 
            (nombre, marca, categoria, descripcion, precio, stock, cantidad, creado_en, actualizado_en) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $insert->bind_param("ssssdii", $nombre, $marca, $categoria, $descripcion, $precio, $cantidad, $cantidad);
        $insert->execute();

        $id_producto = $insert->insert_id;

        // Registrar movimiento
        $log = $conn->prepare("INSERT INTO movimientos (id_producto, tipo, cantidad, fecha) VALUES (?, ?, ?, NOW())");
        $log->bind_param("isi", $id_producto, $tipo, $cantidad);
        if (!$log->execute()) {
            echo json_encode(["success" => false, "message" => "Error al registrar movimiento: " . $log->error]);
            exit;
        }

        echo json_encode(["success" => true, "message" => "Producto registrado con entrada"]);
    } else {
        echo json_encode(["success" => false, "message" => "No se puede registrar salida de un producto inexistente"]);
    }
}

$conn->close();
?>
