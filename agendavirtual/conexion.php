<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'bd';

// Conexión a la base de datos usando MySQLi
$conexion = mysqli_connect($host, $username, $password, $database);

// Verificar la conexión
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>


