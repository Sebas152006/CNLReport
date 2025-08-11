<?php
session_start();

function verificarAcceso($roles_permitidos) {
    if (!isset($_SESSION['id']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
        header("Location: ../../index.php");
        exit();
    }
}
