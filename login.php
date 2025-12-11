<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'conexion.php';

// Depuración: ver qué llega
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ver qué llega desde React
// ⚠️ Activa esto solo para probar, luego elimínalo
// var_dump($_POST);
// exit;

$correo = $_POST['correo'] ?? '';
$clave  = $_POST['clave'] ?? '';

if (!$correo || !$clave) {
    echo json_encode(["exito" => false, "mensaje" => "Correo y contraseña requeridos"]);
    exit;
}

$sql = "SELECT * FROM usuarios WHERE correo = ? AND estado = 'activo'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["exito" => false, "mensaje" => "Usuario no encontrado o inactivo"]);
    exit;
}

$user = $result->fetch_assoc();

// ⚠️ Actualmente las contraseñas están en texto plano en tu BD.
// Lo ideal es migrar a password_hash() y password_verify().
// Por ahora comparamos directamente:
if ($clave !== $user['contrasena']) {
    echo json_encode(["exito" => false, "mensaje" => "Contraseña incorrecta"]);
    exit;
}

// Actualizar último login
$update = $conn->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?");
$update->bind_param("i", $user['id']);
$update->execute();

echo json_encode([
    "exito" => true,
    "mensaje" => "Login exitoso",
    "usuario" => [
        "id"        => $user['id'],
        "nombre"    => $user['nombre'],
        "apellidos" => $user['apellidos'],
        "correo"    => $user['correo'],
        "rol"       => $user['rol'],
        "estado"    => $user['estado']
    ]
]);
?>
