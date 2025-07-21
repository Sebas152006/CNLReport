<?php
require '../../../php/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero_piso'])) {
  $numero = intval($_POST['numero_piso']);

  $query = "INSERT INTO pisos (numero) VALUES (?)";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("i", $numero);

  if ($stmt->execute()) {
    echo "<script>alert('Piso registrado correctamente'); window.location.href='../gestionar_pisos.php';</script>";
  } else {
    echo "<script>alert('Error al registrar piso'); window.history.back();</script>";
  }
}
?>
