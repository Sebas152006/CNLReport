<?php
session_start();
require '../../php/conexion_be.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/reporte.css">
    <link rel="stylesheet" href="../../css/estilos.css">
    <title>CNLReport</title>
</head>

<body>
    <!-- Importa el menu lateral -->
    <?php include '../../menu_lateral/menu.php'; ?>

    <!-- Formulario de reporte de timbres -->
    <div class="formulario_fondo">
        <form action="../../php/guardar_reporte.php" method="POST">
            <h2>Reporte de Timbres</h2>
            <!-- Extrae el nombre del usuario que realizo el reporte por medio del ID -->
            <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">

            <div class="grupo1">
                <!-- Muestra los pisos disponibles -->
                <div class="campo">
                    <p>Piso</p>
                    <select name="piso" id="select_piso" required>
                        <option value="">Selecciona un piso</option>
                        <?php
                            require '../../php/conexion_be.php';
                            $query_pisos = "SELECT * FROM pisos";
                            $resultado_pisos = $conexion->query($query_pisos);
                            while ($fila = $resultado_pisos->fetch_assoc()) {
                                echo '<option value="' . $fila['numero'] . '">' . $fila['numero'] . '</option>';
                            }
                        ?>
                    </select>
                </div>

                <!-- Muestra las habitaciones disponibles por piso -->
                <div class="campo">
                <p>Habitación</p>
                <select name="habitacion" id="select_habitacion" required>
                    <option value="">Selecciona una habitación</option>
                    <script src="js/habitaciones.js"></script>
                </select>
                </div>
            </div>
            
            <!-- Muestra los tipos de daños disponibles -->
            <p>Tipo de Daño</p>
            <select name="tipo_dano" id="select_dano" required>
                <option value="Timbre Arrancado">Timbre Arrancado</option>
                <option value="Daño Físico">Daño Físico</option>
                <option value="Timbre No Funciona">Timbre No Funciona</option>
                <option value="Pulsador Dañado">Pulsador Dañado</option>
                <option value="Falta Pulsador">Falta Pulsador</option>
                <option value="Otro">Otro</option>
            </select>
            
            <!-- Área de texto para el reporte -->
            <p>Reporte</p>
            <textarea name="reporte" id="inputReporte"></textarea>
            <script src="js/generar_reporte.js"></script>

            <!-- Botón para enviar el reporte -->
            <button type="submit">ENVIAR REPORTE</button>
        </form>
    </div>
</body>
</html>