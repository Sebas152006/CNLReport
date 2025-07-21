<?php
session_start();
require 'php/conexion_be.php';

// Rango de fechas
$desde = $_GET['desde'] ?? date('Y-01-01');
$hasta = $_GET['hasta'] ?? date('Y-m-d');

// Total global de reportes
$stmtTotal = $conexion->prepare("SELECT COUNT(*) FROM reportes WHERE fecha_creacion BETWEEN ? AND ?");
$stmtTotal->bind_param("ss", $desde, $hasta);
$stmtTotal->execute();
$total = $stmtTotal->get_result()->fetch_row()[0];

// Conteo por estado
$estados = ['Ingresada', 'En Proceso', 'Finalizada'];
$conteo_estados = [];
foreach ($estados as $estado) {
  $stmt = $conexion->prepare("SELECT COUNT(*) FROM reportes WHERE estado = ? AND fecha_creacion BETWEEN ? AND ?");
  $stmt->bind_param("sss", $estado, $desde, $hasta);
  $stmt->execute();
  $conteo_estados[$estado] = $stmt->get_result()->fetch_row()[0];
  $stmt->close();
}

// Promedio de tiempo solo para finalizados con fecha_respuesta
$stmtTiempo = $conexion->prepare(
  "SELECT AVG(TIMESTAMPDIFF(MINUTE, fecha_creacion, fecha_respuesta)) 
   FROM reportes 
   WHERE estado = 'Finalizada' AND fecha_respuesta IS NOT NULL AND fecha_creacion BETWEEN ? AND ?"
);
$stmtTiempo->bind_param("ss", $desde, $hasta);
$stmtTiempo->execute();
$promedio = round($stmtTiempo->get_result()->fetch_row()[0] ?? 0);

// Gráfica por tipo de daño
$sqlTipo = "SELECT tipo_dano, COUNT(*) AS cantidad FROM reportes WHERE fecha_creacion BETWEEN '$desde' AND '$hasta' GROUP BY tipo_dano";
$data_tipo = $conexion->query($sqlTipo)->fetch_all(MYSQLI_ASSOC);

// Gráfica por piso
$sqlPiso = "SELECT piso, COUNT(*) AS total FROM reportes WHERE fecha_creacion BETWEEN '$desde' AND '$hasta' GROUP BY piso";
$data_piso = $conexion->query($sqlPiso)->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard de Reportes</title>
  <link rel="stylesheet" href="prueba.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include '../../menu_lateral/menu2.php'; ?>

  <div class="dashboard-container">
    <h2>📊 Dashboard de Reportes</h2>

    <form method="GET" class="filtro-fechas">
      <label>Fecha inicial:</label>
      <input type="date" name="desde" value="<?= $desde ?>" />
      <label>Fecha final:</label>
      <input type="date" name="hasta" value="<?= $hasta ?>" />
      <button type="submit">Aplicar filtro</button>
    </form>

    <div class="dashboard-reportes">
      <div class="card"><h3>Total</h3><p><?= $total ?></p></div>
      <div class="card"><h3>Ingresados</h3><p><?= $conteo_estados['Ingresada'] ?></p></div>
      <div class="card"><h3>En Proceso</h3><p><?= $conteo_estados['En Proceso'] ?></p></div>
      <div class="card"><h3>Finalizados</h3><p><?= $conteo_estados['Finalizada'] ?></p></div>
      <div class="card"><h3>⏱ Promedio</h3><p><?= $promedio ?> min</p></div>
    </div>

    <div class="graficas">
      <canvas id="estadoChart"></canvas>
      <canvas id="tipoChart"></canvas>
      <canvas id="pisoChart"></canvas>
    </div>
  </div>

  <script>
    new Chart(document.getElementById('estadoChart'), {
      type: 'doughnut',
      data: {
        labels: ['Ingresada', 'En Proceso', 'Finalizada'],
        datasets: [{
          data: [<?= $conteo_estados['Ingresada'] ?>, <?= $conteo_estados['En Proceso'] ?>, <?= $conteo_estados['Finalizada'] ?>],
          backgroundColor: ['#FFC107', '#17A2B8', '#28A745']
        }]
      },
      options: {
        responsive: true,
        plugins: { title: { display: true, text: 'Estado de los Reportes' } }
      }
    });

    new Chart(document.getElementById('tipoChart'), {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_column($data_tipo, 'tipo_dano')) ?>,
        datasets: [{
          label: 'Cantidad',
          data: <?= json_encode(array_column($data_tipo, 'cantidad')) ?>,
          backgroundColor: '#007BFF'
        }]
      },
      options: {
        responsive: true,
        plugins: { title: { display: true, text: 'Tipo de Daño Reportado' } }
      }
    });

    new Chart(document.getElementById('pisoChart'), {
      type: 'bar',
      data: {
        labels: <?= json_encode(array_map(fn($p) => 'Piso ' . $p['piso'], $data_piso)) ?>,
        datasets: [{
          label: 'Reportes',
          data: <?= json_encode(array_column($data_piso, 'total')) ?>,
          backgroundColor: '#6C757D'
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        plugins: { title: { display: true, text: 'Reportes por Piso' } }
      }
    });
  </script>
</body>
</html>

