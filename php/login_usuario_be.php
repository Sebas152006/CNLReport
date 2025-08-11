<?php
session_start();
include 'conexion_be.php'; // Usa la nueva conexión segura

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_documento = $_POST['numero_documento'];
    $contrasenia = $_POST['contrasenia'];

    // Consulta segura con `prepare()`
    $sql = "SELECT id, primer_nombre, rol, contrasenia FROM usuarios WHERE numero_documento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $numero_documento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if (password_verify($contrasenia, $usuario['contrasenia'])) {
            // Refuerzo de seguridad: Regenerar ID de sesión
            session_regenerate_id(true);

            // Guardar los datos en la sesión para acceder desde otras páginas
            $_SESSION['id'] = $usuario['id']; 
            $_SESSION['nombre'] = $usuario['primer_nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // Configuración de redirección por rol
            $redirecciones = [
                1 => "../roles/administrador_reportes/seleccion.php",
                2 => "../roles/usuarios_reportes/seleccion.php",
                3 => "../roles/visualizador_reportes/seleccion.php",
            ];

            // Redirigir según el rol o mostrar error si el rol no existe
            header("Location: " . ($redirecciones[$usuario['rol']] ?? "error.php"));
            exit();
        }
    }

    // Mensaje de error más seguro
    echo '
    <script>
        alert("Credenciales incorrectas. Intente de nuevo.");
        window.location = "../index.php";
    </script>';
    exit();
}
?>
