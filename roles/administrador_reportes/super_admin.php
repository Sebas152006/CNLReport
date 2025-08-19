<?php
session_start();
require '../../php/conexion_be.php';

if (!isset($_SESSION['id']) || $_SESSION['rol'] != '1') {
    die("Acceso denegado.");
}

$resultado = $conexion->query("SELECT id, reporte FROM reportes ORDER BY fecha_creacion DESC");

$porPagina = 9;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $porPagina;

$total = $conexion->query("SELECT COUNT(*) as total FROM reportes")->fetch_assoc()['total'];
$paginasTotales = ceil($total / $porPagina);

$resultado = $conexion->query("SELECT id, reporte FROM reportes ORDER BY fecha_creacion DESC LIMIT $inicio, $porPagina");


$bloque = 10;
$bloqueActual = ceil($pagina / $bloque);
$inicioBloque = ($bloqueActual - 1) * $bloque + 1;
$finBloque = min($inicioBloque + $bloque - 1, $paginasTotales);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Super Admin - Gestión de Imágenes</title>
    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="stylesheet" href="../../css/super_admin.css">

</head>
<body>
    <?php include '../../menu_lateral/menu2.php'; ?>
    <h1>Panel Super Admin de Reportes</h1>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($reporte = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $reporte['id'] ?></td>
                    <td>
                        <button onclick="mostrarContexto(<?= $reporte['id'] ?>)">Mostrar más</button>
                        <button onclick="abrirFormulario(<?= $reporte['id'] ?>)">Subir imágenes</button>
                    </td>
                </tr>
                <tr id="contexto-<?= $reporte['id'] ?>" style="display:none;">
                    <td colspan="2">
                        <strong>Reporte:</strong> <?= $reporte['reporte'] ?>
                    </td>
                </tr>
                <tr id="formulario-<?= $reporte['id'] ?>" style="display:none;">
                    <td colspan="2">
                        <form method="POST" enctype="multipart/form-data" action="super_admin.php">
                            <input type="hidden" name="reporte_id" value="<?= $reporte['id'] ?>">
                            <label>Imagen Antes:</label>
                            <input type="file" name="imagen_antes" accept="image/*"><br>
                            <label>Imagen Después:</label>
                            <input type="file" name="imagen_despues" accept="image/*"><br>
                            <button type="submit">Actualizar Imágenes</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>


    </table>
<div class="paginacion">
    <?php if ($inicioBloque > 1): ?>
        <a href="?pagina=<?= $inicioBloque - 1 ?>">«</a>
    <?php endif; ?>

    <?php for ($i = $inicioBloque; $i <= $finBloque; $i++): ?>
        <a href="?pagina=<?= $i ?>" class="<?= $i == $pagina ? 'activo' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($finBloque < $paginasTotales): ?>
        <a href="?pagina=<?= $finBloque + 1 ?>">»</a>
    <?php endif; ?>
</div>



    <script>
        function mostrarContexto(id) {
            const fila = document.getElementById('contexto-' + id);
            fila.style.display = fila.style.display === 'none' ? 'table-row' : 'none';
        }

        function abrirFormulario(id) {
            const fila = document.getElementById('formulario-' + id);
            fila.style.display = fila.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
</body>
</html>
