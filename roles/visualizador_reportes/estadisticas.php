<?php
require '../../php/conexion_be.php';

$inicio = $_GET['fecha_inicio'] ?? '2000-01-01';
$fin = $_GET['fecha_fin'] ?? date('Y-m-d');

// Reportes por habitación
$sqlHab = "SELECT habitacion, COUNT(*) AS total 
           FROM reportes 
           WHERE fecha BETWEEN '$inicio' AND '$fin'
           GROUP BY habitacion 
           ORDER BY total DESC";
$resHab = $conexion->query($sqlHab);

// Reportes por piso
$sqlPiso = "SELECT piso, COUNT(*) AS total 
            FROM reportes 
            WHERE fecha BETWEEN '$inicio' AND '$fin'
            GROUP BY piso 
            ORDER BY piso ASC";
$resPiso = $conexion->query($sqlPiso);

// Top 3 habitaciones
$sqlTop = "SELECT habitacion, COUNT(*) AS total 
           FROM reportes 
           WHERE fecha BETWEEN '$inicio' AND '$fin'
           GROUP BY habitacion 
           ORDER BY total DESC 
           LIMIT 3";
$topHab = $conexion->query($sqlTop);



?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gráficas de Diagnóstico</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/diagnostico.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include '../../menu_lateral/menu3.php'; ?>

  <div class="contenedor-estadisticas">
    <form method="GET" class="form-fechas">
        <label for="fecha_inicio">Fecha Inicio:</label>
        <input type="date" name="fecha_inicio" id="fecha_inicio" required>
  
        <label for="fecha_fin">Fecha Fin:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" required>
  
        <button type="submit">Filtrar 📅</button>
    </form>

    <h2>📊 Gráfica: Reportes por Habitación</h2>
    <canvas id="graficoHabitaciones"></canvas>

    <h2>🏢 Gráfica: Reportes por Piso</h2>
    <canvas id="graficoPisos"></canvas>

    <h2>🏆 Top 3 Habitaciones Más Reportadas</h2>
    <canvas id="graficoTop3"></canvas>
  </div>

  <script>
    // Habitaciones
    const etiquetasHab = [<?php while ($row = $resHab->fetch_assoc()) echo "'".$row['habitacion']."',"; ?>];
    const datosHab = [<?php $resHab->data_seek(0); while ($row = $resHab->fetch_assoc()) echo $row['total'].','; ?>];

    new Chart(document.getElementById('graficoHabitaciones').getContext('2d'), {
      type: 'bar',
      data: {
        labels: etiquetasHab,
        datasets: [{
          label: 'Cantidad de reportes',
          data: datosHab,
          backgroundColor: '#6c5ce7'
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });

    // Pisos
    const etiquetasPiso = [<?php while ($row = $resPiso->fetch_assoc()) echo "'Piso ".$row['piso']."',"; ?>];
    const datosPiso = [<?php $resPiso->data_seek(0); while ($row = $resPiso->fetch_assoc()) echo $row['total'].','; ?>];

    new Chart(document.getElementById('graficoPisos').getContext('2d'), {
      type: 'bar',
      data: {
        labels: etiquetasPiso,
        datasets: [{
          label: 'Reportes por piso',
          data: datosPiso,
          backgroundColor: '#00cec9'
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });

    // Top 3
    const etiquetasTop = [<?php while ($row = $topHab->fetch_assoc()) echo "'".$row['habitacion']."',"; ?>];
    const datosTop = [<?php $topHab->data_seek(0); while ($row = $topHab->fetch_assoc()) echo $row['total'].','; ?>];

    new Chart(document.getElementById('graficoTop3').getContext('2d'), {
      type: 'bar',
      data: {
        labels: etiquetasTop,
        datasets: [{
          label: 'Top 3 habitaciones',
          data: datosTop,
          backgroundColor: '#fd79a8'
        }]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
</body>
</html>
