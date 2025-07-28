<div class="menu" id="menu">
    <button class="menu-toggle" id="menu-toggle">☰</button>
    <?php $current_page = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual?>

    <nav class="menu-items">
        <!--Inicio-->
        <a href="seleccion.php" class="<?php echo ($current_page == 'seleccion.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Inicio.png" alt="INICIO"><span>Inicio</span>
        </a>
        <!--Estadisticas Generales-->
        <a href="estadisticas_Generales.php" class="<?php echo ($current_page == 'estadisticas_Generales.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Reportes.png" alt="ESTADISTICAS GENERALES"><span>Estadisticas Generales</span>
        </a>
        <!--EStadisticas Por Habitacion-->
        <a href="estadistica_Habitacion.php" class="<?php echo ($current_page == 'estadistica_Habitacion.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Consulta_Reportes.png" alt="ESTADISTICAS POR HABITACION"><span>Estadisticas Por Habitación</span>
        </a>
        <!--Estadisticas Por Piso-->
        <a href="estadistica_Piso.php" class="<?php echo ($current_page == 'estadistica_Piso.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Gestionar_Reportes.png" alt="ESTADISTICAS POR PISO"><span>Estadisticas Por Piso</span>
        </a>
        <!--Estadisticas Top-->
        <a href="estadistica_Top.php" class="<?php echo ($current_page == 'estadistica_Top.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Gestionar_Perfil.png" alt="ESTADISTICAS TOP"><span>Estadisticas Top</span>
        </a>
        <!--Mi Cuenta-->
        <a href="contrasenia.php" class="<?php echo ($current_page == 'contrasenia.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Perfil.png" alt="MI CUENTA"><span>Mi Cuenta</span>
        </a>
        <!--Cerrar Sesión-->
        <a href="../../php/cerrar_Sesion.php" class="<?php echo ($current_page == 'php/cerrar_Sesion.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Cerrar_Sesion.png" alt="CERRAR SESION"><span>Cerrar sesión</span>
        </a>
    </nav>
</div>

<!--Script para deshabilitar el funcionamiento de desplegar el menu-->
<script src="../../menu_lateral/menu.js"></script>