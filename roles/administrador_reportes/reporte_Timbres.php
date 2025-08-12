<?php
    require '../../php/verificar_sesion.php';
    verificarAcceso([1]); // Permitir acceso a rol 1 y 2
    require '../../php/conexion_be.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/reporte.css">
    <link rel="stylesheet" href="../../css/estilos.css">
    <title>Reporte de Timbres</title>
    <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
    <script>
        const titulos = ["CNLReport", "Reporte de Timbres"];
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

    <!-- Formulario de reporte de timbres -->
    <div class="formulario_fondo">
        <form action="../../php/guardar_reporte.php" method="POST">
            <h1>Reporte de Timbres</h1>
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

            <div id="detalle_otro" style="display: none;">
                <p>Especificar otro tipo de daño</p>
                <textarea class="otro" id="otro_dano" placeholder="Describe el daño aquí..."></textarea>
            </div>

            
            <!-- Área de texto para el reporte -->
            <p>Reporte</p>
            <textarea name="reporte" id="inputReporte"></textarea>
            <script src="js/generar_reporte.js"></script>

            <!-- Botón para enviar el reporte -->
            <button type="submit">ENVIAR REPORTE</button>
        </form>
    </div>
    <script>
        const selectDano = document.getElementById("select_dano");
        const detalleOtro = document.getElementById("detalle_otro");

        selectDano.addEventListener("change", function () {
            if (this.value === "Otro") {
            detalleOtro.style.display = "block";
            } else {
            detalleOtro.style.display = "none";
            }
        });
    </script>
</body>
</html>