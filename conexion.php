<?php
// ⚠️ IMPORTANTE: REEMPLAZA ESTOS VALORES CON LOS DE INFINITYFREE ⚠️

$servername = "sql202.infinityfree.com"; // MySQL Hostname (Búscalo en 'MySQL Details')
$username   = "if0_40354658";            // MySQL Username
$password   = "LastBrujo12345";           // Tu contraseña de vPanel (¡NO es la de acceso al área de cliente!)
$dbname     = "if0_40354658_inventarios_grupo9"; // Nombre de la Base de Datos (ej. if0_xxxxx_nombre)

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    // Es buena práctica no mostrar el error detallado en producción, pero útil para depurar ahora.
    echo json_encode([
        "exito" => false, 
        "mensaje" => "Fallo de conexión a la BD: " . $conn->connect_error
    ]);
    exit;
}

// Establecer charset a UTF-8 para evitar problemas con tildes/ñ
$conn->set_charset("utf8");
?>