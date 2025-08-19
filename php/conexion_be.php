<?php
// Configuración de conexión segura
define('DB_HOST', 'localhost');
define('DB_USER', 'cnl_admin');
define('DB_PASS', 'k*T]SQUwIx!bTU_*'); // Nueva contraseña segura
define('DB_NAME', 'cnl_report');

// Conexión con manejo de errores y excepciones
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . htmlspecialchars($conexion->connect_error));
}

// Ajustar el conjunto de caracteres para evitar problemas de codificación y ataques
$conexion->set_charset("utf8mb4");

// Opcional: Definir configuración de seguridad adicional
mysqli_options($conexion, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, true);
?>
