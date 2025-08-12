<?php
require '../../php/verificar_sesion.php';
verificarAcceso([2]); // Permitir acceso a rol 2

require '../../php/conexion_be.php';

if (!isset($_SESSION['id'])) {
    die("Usuario no autenticado.");
}

$usuario_id = $_SESSION['id'];

$pdo = new PDO("mysql:host=localhost;dbname=cnl_report", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener datos del usuario
$sql = "SELECT primer_nombre, segundo_nombre, primer_apellido, segundo_apellido FROM usuarios WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Cambiar contraseña
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $actual = $_POST['actual'] ?? '';
    $nueva = $_POST['nueva'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    $sqlPass = "SELECT contrasenia FROM usuarios WHERE id = ?";
    $stmtPass = $pdo->prepare($sqlPass);
    $stmtPass->execute([$usuario_id]);
    $hashGuardado = $stmtPass->fetchColumn();

    if (!password_verify($actual, $hashGuardado)) {
        echo "<script>alert('La contraseña actual no es válida');</script>";
    } elseif ($nueva !== $confirmar) {
        echo "<script>alert('Las contraseñas nuevas no coinciden');</script>";
    } else {
        $nuevoHash = password_hash($nueva, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE usuarios SET contrasenia = ? WHERE id = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$nuevoHash, $usuario_id]);
        echo "<script>alert('Contraseña actualizada con éxito');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="../../css/contrasenia.css">
  <link rel="stylesheet" href="../../css/estilos2.css">
  <title>Mi Cuenta</title>
    <link rel="icon" href="../../images/CNLReport_pequena.png" type="image/png">
    <script>
        const titulos = ["CNLReport", "Mi Cuenta"];
        let index = 0;

        setInterval(() => {
            document.title = titulos[index];
            index = (index + 1) % titulos.length;
        }, 3000);
    </script>
</head>
<body>
   <?php include '../../menu_lateral/menu.php'; ?>

<div class="perfil-wrapper">
  <h2>Información del Usuario</h2>
  <form class="datos-usuario">
    <label>Nombre Completo:</label>
    <input type="text" value="<?= $usuario['primer_nombre'] ?> <?= $usuario['segundo_nombre'] ?> <?= $usuario['primer_apellido'] ?> <?= $usuario['segundo_apellido'] ?>" readonly>
  </form>

  <h3>Cambiar Contraseña</h3>
  <form method="POST" class="cambio-clave">
    <label>Contraseña actual:</label>
    <input type="password" name="actual" required>

    <label>Nueva contraseña:</label>
    <input type="password" name="nueva" required>

    <label>Confirmar nueva contraseña:</label>
    <input type="password" name="confirmar" required>

    <button type="submit">ACTUALIZAR CONTRASEÑA</button>
  </form>
</div>
</body>
</html>
