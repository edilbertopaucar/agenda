<?php
session_start();
session_destroy();
header("Location: login.php"); // Redirige al login después de cerrar sesión
exit;
?>
