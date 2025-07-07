<?php
    //Inicia la sesion activa y la destruye
    session_start();
    session_destroy();
    header("location: ../index.php");
?>