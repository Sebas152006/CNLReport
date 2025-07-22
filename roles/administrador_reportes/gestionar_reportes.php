<?php
session_start();
require '../../php/conexion_be.php';

if (!isset($_SESSION['id'])) {
    die("Error: Usuario no autenticado.");
}

$pdo = new PDO("mysql:host=localhost;dbname=cnl_report", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$porPagina = 8;
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina - 1) * $porPagina;

$filtros = [];
$parametros = [];

if (!empty($_GET['id'])) {
    $filtros[] = "id = ?";
    $parametros[] = $_GET['id'];
}
if (!empty($_GET['piso'])) {
    $filtros[] = "piso LIKE ?";
    $parametros[] = "%" . $_GET['piso'] . "%";
}
if (!empty($_GET['habitacion'])) {
    $filtros[] = "habitacion LIKE ?";
    $parametros[] = "%" . $_GET['habitacion'] . "%";
}
if (!empty($_GET['tipo_dano'])) {
    $filtros[] = "tipo_dano LIKE ?";
    $parametros[] = "%" . $_GET['tipo_dano'] . "%";
}
if (!empty($_GET['estado'])) {
    $filtros[] = "estado = ?";
    $parametros[] = $_GET['estado'];
}

$where = $filtros ? "WHERE " . implode(" AND ", $filtros) : "";

$sql = "SELECT reportes.*, usuarios.primer_nombre AS nombre_responde 
        FROM reportes 
        LEFT JOIN usuarios ON reportes.respondido_por = usuarios.id 
        $where 
        ORDER BY reportes.id DESC 
        LIMIT $inicio, $porPagina";

$stmt = $pdo->prepare($sql);
$stmt->execute($parametros);
$reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total para paginación
$sqlTotal = "SELECT COUNT(*) FROM reportes $where";
$stmtTotal = $pdo->prepare($sqlTotal);
$stmtTotal->execute($parametros);
$totalRegistros = $stmtTotal->fetchColumn();
$totalPaginas = ceil($totalRegistros / $porPagina);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestionar Reportes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <link rel="stylesheet" href="../../css/gestion_reportes.css">
    <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
    <script>
        const titulos = ["CNLReport", "Gestionar Reportes"];
        let index = 0;

        setInterval(() => {
            document.title = titulos[index];
            index = (index + 1) % titulos.length;
        }, 3000);
    </script>
</head>

<body>
    <!-- Importa el menu lateral -->
    <?php include '../../menu_lateral/menu2.php'; ?>
    <h1>Gestionar Reportes</h1>

    <form method="GET" style="margin-bottom: 20px;">
        <input type="text" name="id" placeholder="ID" value="<?= $_GET['id'] ?? '' ?>">
        <input type="text" name="piso" placeholder="Piso" value="<?= $_GET['piso'] ?? '' ?>">
        <input type="text" name="habitacion" placeholder="Habitación" value="<?= $_GET['habitacion'] ?? '' ?>">
        <input type="text" name="tipo_dano" placeholder="Tipo de Daño" value="<?= $_GET['tipo_dano'] ?? '' ?>">
        <select name="estado">
            <option value="">-- Estado --</option>
            <option value="Ingresada" <?= ($_GET['estado'] ?? '') === 'Ingresada' ? 'selected' : '' ?>>Ingresada</option>
            <option value="En Proceso" <?= ($_GET['estado'] ?? '') === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
            <option value="Finalizada" <?= ($_GET['estado'] ?? '') === 'Finalizada' ? 'selected' : '' ?>>Finalizada</option>
        </select>
        <button type="submit">Filtrar</button>
    </form>

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

            <!-- Modal flotante -->
            <div class="modal" id="modal-<?= $reporte['id'] ?>">
                <div class="modal-contenido">
                    <span class="cerrar" onclick="cerrarModal(<?= $reporte['id'] ?>)">&times;</span>
                    <h2>Detalles del Reporte #<?= $reporte['id'] ?></h2>

                    <p><strong>Piso:</strong> <?= htmlspecialchars($reporte['piso']) ?></p>
                    <p><strong>Habitación:</strong> <?= htmlspecialchars($reporte['habitacion']) ?></p>
                    <p><strong>Estado:</strong> <?= htmlspecialchars($reporte['estado']) ?></p>
                    <p><strong>Reporte:</strong><br><?= nl2br(htmlspecialchars($reporte['reporte'])) ?></p>


                    <?php if (!empty($reporte['nombre_responde'])): ?>
    <p><strong>Respondido por:</strong> <?= htmlspecialchars($reporte['nombre_responde']) ?></p>
<?php endif; ?>

                    <?php if (in_array($reporte['estado'], ['En Proceso', 'Finalizada'])): ?>
                        <p><strong>Respuesta de Sistemas:</strong><br><?= $reporte['respuesta'] ?? 'Pendiente...' ?></p>
                    <?php endif; ?>

                    <p><strong>Fecha de Creación:</strong> <?= date('d/m/Y h:i a', strtotime($reporte['fecha_creacion'])) ?></p>

                    <p><strong>Fecha de Respuesta:</strong> 
                    <?= $reporte['fecha_respuesta'] ? date('d/m/Y h:i a', strtotime($reporte['fecha_respuesta'])) : '00:00:00 a.m' ?>
                    </p>

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
                    
    <?php if ($reporte['estado'] !== 'Finalizada'): ?>
        <form action="php/responder_reporte.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="reporte_id" value="<?= $reporte['id'] ?>">

            <h3>Responder Solicitud</h3>

            <label for="respuesta">Respuesta:</label><br>
            <textarea name="respuesta" rows="4" required><?= htmlspecialchars($reporte['respuesta'] ?? '') ?></textarea><br><br>

            <h4>Imágenes</h4>
            <label>Antes:</label><br>
            <?php if ($reporte['imagen_antes']): ?>
                <img src="../php/ver_imagen.php?id=<?= $reporte['id'] ?>&tipo=antes" style="max-width:150px;"><br>
            <?php endif; ?>
            <input type="file" name="imagen_antes" accept="image/*"><br><br>

            <label>Después:</label><br>
            <?php if ($reporte['imagen_despues']): ?>
                <img src="../php/ver_imagen.php?id=<?= $reporte['id'] ?>&tipo=despues" style="max-width:150px;"><br>
            <?php endif; ?>
            <input type="file" name="imagen_despues" accept="image/*"><br><br>

            <label for="estado">Estado del reporte:</label><br>
            <select name="estado" required>
                <option value="Ingresada" <?= $reporte['estado'] === 'Ingresada' ? 'selected' : '' ?>>Ingresada</option>
                <option value="En Proceso" <?= $reporte['estado'] === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
                <option value="Finalizada" <?= $reporte['estado'] === 'Finalizada' ? 'selected' : '' ?>>Finalizada</option>
            </select><br><br>

            <button type="submit">Guardar Cambios</button>
        </form>
        <?php endif; ?> 
                </div>
            </div>
        <?php endforeach; ?>
        </tbody>
    </table>

<div class="paginacion">
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>" 
           class="<?= $i == $pagina ? 'pagina-actual' : '' ?>">
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

    // Cerrar modal al hacer clic fuera del contenido
    window.onclick = function(event) {
        document.querySelectorAll('.modal').forEach(function(modal) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    }
</script>

</body>
</html>
