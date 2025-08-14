<?php
require 'conexion_be.php';

$piso_id = $_GET['piso_id'] ?? null;
$fase = $_GET['fase'] ?? null;

if ($piso_id && $fase) {
    $stmt = $conexion->prepare("SELECT id, numero_habitacion FROM habitaciones WHERE piso_id = ? AND fase = ?");
    $stmt->bind_param("is", $piso_id, $fase);
    $stmt->execute();
    $result = $stmt->get_result();

    $habitaciones = [];
    while ($row = $result->fetch_assoc()) {
        $habitaciones[] = $row;
    }

    // Ordenar por número extraído del nombre
    usort($habitaciones, function($a, $b) {
        preg_match('/(\\d+)/', $a['numero_habitacion'], $numA);
        preg_match('/(\\d+)/', $b['numero_habitacion'], $numB);
        return intval($numA[1]) <=> intval($numB[1]);
    });

    // Generar opciones HTML
    echo "<option value=''>Selecciona una habitación</option>";
    foreach ($habitaciones as $hab) {
        echo "<option value='{$hab['id']}'>{$hab['numero_habitacion']}</option>";
    }
}
?>
