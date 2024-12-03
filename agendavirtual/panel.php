<?php
session_start();
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
    header("Location: login.php"); // Redirige al login
    exit;
}
?>

<h1>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h1>
<p>Esta es una página protegida. Solo usuarios autenticados pueden verla.</p>
<a href="logout.php">Cerrar sesión</a>