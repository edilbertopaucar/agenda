<?php
session_start();
require_once('../agendavirtual/conexion.php'); // Conexión a la base de datos
require_once('../agendavirtual/clases/contactos.php');
require_once('../agendavirtual/clases/usuarios.php'); // Incluir la clase Contactos si es necesario

// Verificar si el usuario está autenticado
if (!isset($_SESSION['autenticado'])) {
    header("Location: login.php");
    exit;
}

// Verificar si se ha recibido un ID de contacto a editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del contacto desde la base de datos
    $query = "SELECT * FROM contactos WHERE id = $id";
    $result = mysqli_query($conexion, $query);
    $contacto = mysqli_fetch_assoc($result);

    if (!$contacto) {
        // Si el contacto no existe, redirigir con un mensaje de error
        header("Location: index.php?mensaje=Contacto no encontrado");
        exit;
    }
} else {
    // Si no se ha proporcionado un ID válido, redirigir
    header("Location: index.php?mensaje=ID de contacto no válido");
    exit;
}

// Si el formulario ha sido enviado, actualizar el contacto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Actualizar los datos del contacto en la base de datos
    $query_update = "UPDATE contactos SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', email = '$email' WHERE id = $id";
    $result_update = mysqli_query($conexion, $query_update);

    if ($result_update) {
        // Redirigir con mensaje de éxito
        header("Location: index.php?mensaje=Contacto actualizado correctamente");
    } else {
        // Redirigir con mensaje de error
        header("Location: index.php?mensaje=Error al actualizar el contacto");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Contacto</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Editar Contacto</h1>
        
        <!-- Formulario para editar el contacto -->
        <form action="editar_contacto.php?id=<?php echo $contacto['id']; ?>" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($contacto['nombre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($contacto['apellido']); ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($contacto['telefono']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="email" value="<?php echo htmlspecialchars($contacto['email']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Actualizar Contacto</button>
        </form>
        <p class="text-center mt-3"><a href="index.php">Volver a la Agenda</a></p>
    </div>
</body>
</html>
