<?php
require 'conexion_be.php';

$piso_numero = intval($_GET['piso_id'] ?? 0);
$fase = $_GET['fase'] ?? '';

if (!$piso_numero || !$fase) {
    echo "<option value=''>Selecciona piso y fase</option>";
    exit;
}

// Obtener el ID real del piso
$query_piso = "SELECT id FROM pisos WHERE numero = ?";
$stmt_piso = $conexion->prepare($query_piso);
$stmt_piso->bind_param("i", $piso_numero);
$stmt_piso->execute();
$resultado_piso = $stmt_piso->get_result();
$fila_piso = $resultado_piso->fetch_assoc();

if (!$fila_piso) {
    echo "<option value=''>Piso no encontrado</option>";
    exit;
}

$piso_id = $fila_piso['id'];

// Consultar habitaciones filtradas por piso y fase
$query_habitaciones = "SELECT numero_habitacion FROM habitaciones WHERE piso_id = ? AND fase = ? ORDER BY numero_habitacion ASC";
$stmt_habitaciones = $conexion->prepare($query_habitaciones);
$stmt_habitaciones->bind_param("is", $piso_id, $fase);
$stmt_habitaciones->execute();
$resultado_habitaciones = $stmt_habitaciones->get_result();

if ($resultado_habitaciones->num_rows === 0) {
    echo "<option value=''>No hay habitaciones disponibles</option>";
} else {
    echo '<option value="">Selecciona una habitación</option>';
    while ($fila = $resultado_habitaciones->fetch_assoc()) {
        echo '<option value="' . $fila['numero_habitacion'] . '">' . $fila['numero_habitacion'] . '</option>';
    }
}
?>
