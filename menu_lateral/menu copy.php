<div class="menu" id="menu">
    <button class="menu-toggle" id="menu-toggle">☰</button>
    <?php $current_page = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual?>

    <nav class="menu-items">
        <!--Inicio-->
        <a href="seleccion.php" class="<?php echo ($current_page == 'seleccion.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Inicio.png" alt="INICIO"><span>Inicio</span>
        </a>
        <!--Reportar Timbre-->
        <a href="reporte_Timbres.php" class="<?php echo ($current_page == 'reporte_Timbres.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Reportes.png" alt="REPORTES"><span>Reportes</span>
        </a>
        <!--Mis Reportes-->
        <a href="consultar_reportes.php" class="<?php echo ($current_page == 'consultar_reportes.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Consulta_Reportes.png" alt="MIS REPORTES"><span>Mis Reportes</span>
        </a>
        <a href="../administrador_reportes/gestionar_reportes.php" class="<?php echo ($current_page == 'gestionar_reportes.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Gestionar_Reportes.png" alt="MIS REPORTES"><span>Mis Reportes</span>
        </a>
        <!--Cerrar Sesión-->
        <a href="../../php/cerrar_Sesion.php" class="<?php echo ($current_page == 'php/cerrar_Sesion.php') ? 'active' : ''; ?>">
            <img src="../../menu_lateral/images/Cerrar_Sesion.png" alt="CERRAR SESION"><span>Cerrar sesión</span>
        </a>
    </nav>
</div>

<!--Script para deshabilitar el funcionamiento de desplegar el menu-->
<script src="../../menu_lateral/menu.js"></script>