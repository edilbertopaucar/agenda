<?php
session_start();
require_once('../agendavirtual/conexion.php');
require_once('../agendavirtual/clases/contactos.php'); 
require_once('../agendavirtual/clases/usuarios.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    echo "Por favor, inicia sesión para agregar contactos.";
    exit;
}

// Verificar si la conexión a la base de datos es exitosa
if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir y validar los datos del formulario
    $usuario_nombre = mysqli_real_escape_string($conexion, $_SESSION['usuario']); // Nombre de usuario desde la sesión
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);

    // Crear un objeto Contactos y registrar el nuevo contacto
    $contacto = new Contactos($conexion, $usuario_nombre, $nombre, $apellido, $telefono, $email);
    $contacto->registrarContacto(); // Llamada al método para registrar el contacto

    // Redirigir a la página principal después de agregar el contacto
    header("Location: index.php");
    exit;

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Contacto</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Agregar Nuevo Contacto</h1>
        <form action="nuevo_contacto.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Agregar Contacto</button>
        </form>
        <p class="text-center mt-3"><a href="index.php">Volver a la Agenda</a></p>
    </div>
</body>
</html>
