<?php
require '../../php/conexion_be.php';

// Consulta total
$sqlTotal = "SELECT COUNT(*) AS total FROM reportes";
$total = $conexion->query($sqlTotal)->fetch_assoc()['total'];

// Consulta por estados
$estados = ['Ingresada', 'En Proceso', 'Finalizada'];
$conteo = [];

foreach ($estados as $estado) {
    $sql = "SELECT COUNT(*) AS cantidad FROM reportes WHERE estado = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $estado);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();
    $conteo[$estado] = $resultado['cantidad'] ?? 0;
    $stmt->close();
}

// Consulta top 3 tipos de daño
$sqlTopDanos = "SELECT tipo_dano, COUNT(*) AS cantidad 
                FROM reportes 
                GROUP BY tipo_dano 
                ORDER BY cantidad DESC 
                LIMIT 3";

$topDanos = $conexion->query($sqlTopDanos);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Estadísticas de Reportes</title>
  <link rel="stylesheet" href="prueba.css" />
  <link rel="stylesheet" href="../../css/estilos2.css" />
</head>
<body>
  <?php include '../../menu_lateral/menu2.php'; ?>

  <<div class="contenedor-estadisticas">
  <h2>Estadísticas Globales de Reportes</h2>
  <div class="grid-metricas">
    <div class="card"><h3>Total de Reportes</h3><p><?= $total ?></p></div>
    <div class="card"><h3>Ingresados</h3><p><?= $conteo['Ingresada'] ?></p></div>
    <div class="card"><h3>En Proceso</h3><p><?= $conteo['En Proceso'] ?></p></div>
    <div class="card"><h3>Finalizados</h3><p><?= $conteo['Finalizada'] ?></p></div>
  </div>

<h2>Top 3 Tipos de Daño Más Reportados</h2>
<div class="grid-top3">
  <?php while ($dano = $topDanos->fetch_assoc()): ?>
    <div class="card card-dano">
      <h3><?= htmlspecialchars($dano['tipo_dano']) ?></h3>
      <p><?= $dano['cantidad'] ?> reportes</p>
    </div>
  <?php endwhile; ?>
</div>



</body>
</html>
