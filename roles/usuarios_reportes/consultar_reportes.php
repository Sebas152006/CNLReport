<?php
session_start();
require '../../php/conexion_be.php';

if (!isset($_SESSION['id'])) {
    die("Error: Usuario no autenticado.");
}

$usuario_id = $_SESSION['id'];

$pdo = new PDO("mysql:host=localhost;dbname=cnl_report", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$porPagina = 20;
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina - 1) * $porPagina;

$sql = "SELECT * FROM reportes WHERE usuario_id = ? ORDER BY id DESC LIMIT $inicio, $porPagina";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlTotal = "SELECT COUNT(*) FROM reportes WHERE usuario_id = ?";
$stmtTotal = $pdo->prepare($sqlTotal);
$stmtTotal->execute([$usuario_id]);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $porPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reportes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="stylesheet" href="../../css/consulta_reportes.css">
    <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
    <script>
        const titulos = ["CNLReport", "Mis Reportes"];
        let index = 0;

        setInterval(() => {
            document.title = titulos[index];
            index = (index + 1) % titulos.length;
        }, 3000);
    </script>
</head>
<body>
    
    <?php include '../../menu_lateral/menu.php'; ?>
    <h1>Mis Reportes</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Piso</th>
                <th>Habitación</th>
                <th>Tipo de Daño</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($reportes as $reporte): ?>
            <tr>
                <td><?= $reporte['id'] ?></td>
                <td><?= htmlspecialchars($reporte['piso']) ?></td>
                <td><?= htmlspecialchars($reporte['habitacion']) ?></td>
                <td><?= htmlspecialchars($reporte['tipo_dano']) ?></td>
                <td><?= htmlspecialchars($reporte['estado']) ?></td>
                <td>
                    <button class="btn-ver" onclick="abrirModal(<?= $reporte['id'] ?>)">Mostrar más</button>
                </td>
            </tr>

            <div class="modal" id="modal-<?= $reporte['id'] ?>">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModal(<?= $reporte['id'] ?>)">&times;</span>
    <h2>Detalles del Reporte #<?= $reporte['id'] ?></h2>

    <p><strong>Piso:</strong> <?= htmlspecialchars($reporte['piso']) ?></p>
    <p><strong>Habitación:</strong> <?= htmlspecialchars($reporte['habitacion']) ?></p>
    <p><strong>Estado:</strong> <?= htmlspecialchars($reporte['estado']) ?></p>
    <p><strong>Reporte:</strong><br><?= nl2br(htmlspecialchars($reporte['reporte'])) ?></p>
    <?php if ($reporte['respuesta']): ?>
        <p><strong>Respuesta de Sistemas:</strong><br><?= $reporte['respuesta'] ?? 'Pendiente...' ?></p>
    <?php endif; ?>

    <p><strong>Fecha de Creación:</strong> <?= date('d/m/Y h:i a', strtotime($reporte['fecha_creacion'])) ?></p>
    <p><strong>Fecha de Respuesta:</strong> <?= $reporte['fecha_respuesta'] ? date('d/m/Y h:i a', strtotime($reporte['fecha_respuesta'])) : '00:00:00 a.m' ?></p>

    <?php if ($reporte['imagen_antes'] || $reporte['imagen_despues']): ?>
      <div class="contenedor-imagenes">
        <?php if ($reporte['imagen_antes']): ?>
          <div>
            <p>Antes:</p>
            <img src="../php/ver_imagen.php?id=<?= $reporte['id'] ?>&tipo=antes" alt="Antes de la reparación">
          </div>
        <?php endif; ?>
        <?php if ($reporte['imagen_despues']): ?>
          <div>
            <p>Después:</p>
            <img src="../php/ver_imagen.php?id=<?= $reporte['id'] ?>&tipo=despues" alt="Después de la reparación">
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginacion">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?= $i ?>" class="<?= $i == $pagina ? 'pagina-actual' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>

    <script>
        function abrirModal(id) {
            document.getElementById('modal-' + id).style.display = 'block';
        }

        function cerrarModal(id) {
            document.getElementById('modal-' + id).style.display = 'none';
        }

        window.onclick = function(event) {
            document.querySelectorAll('.modal').forEach(function(modal) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        };
    </script>
</body>
</html>
