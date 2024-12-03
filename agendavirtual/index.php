<?php
session_start();
require_once('../agendavirtual/conexion.php'); // Conexión a la base de datos
require_once('../agendavirtual/clases/contactos.php');
require_once('../agendavirtual/clases/usuarios.php'); 

// Verificar si el usuario está autenticado
if (!isset($_SESSION['autenticado'])) {
    header("Location: login.php");
    exit;
}

// Eliminar un contacto si se ha recibido el ID del contacto
if (isset($_GET['eliminar_id'])) {
    $id = $_GET['eliminar_id'];

    // Validar que el ID sea un número
    if (is_numeric($id)) {
        // Ejecutar la consulta SQL para eliminar el contacto
        $query = "DELETE FROM contactos WHERE id = $id";
        $result = mysqli_query($conexion, $query);

        // Verificar si la eliminación fue exitosa y redirigir con mensaje
        if ($result) {
            header("Location: index.php?mensaje=Contacto eliminado correctamente");
        } else {
            header("Location: index.php?mensaje=Error al eliminar el contacto");
        }
    } else {
        header("Location: index.php?mensaje=ID de contacto no válido");
    }
    exit;
}

// Obtener los contactos de la base de datos
$query = "SELECT * FROM contactos ORDER BY nombre ASC";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Iconos -->
    <title>Agenda Virtual</title>
</head>
<body class="bg-light">

    <!-- Header con barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Agenda Virtual</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <!-- Mensaje si se pasó un parámetro mensaje en la URL -->
    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-info text-center" role="alert">
            <?php echo htmlspecialchars($_GET['mensaje']); ?>
        </div>
    <?php endif; ?>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="text-primary">Contactos</h2>
            <a href="nuevo_contacto.php" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Agregar Contacto
            </a>
        </div>

        <!-- Mensaje si no hay contactos -->
        <?php if (mysqli_num_rows($result) == 0): ?>
            <div class="alert alert-info text-center" role="alert">
                No hay contactos registrados. ¡Agrega uno nuevo!
            </div>
        <?php endif; ?>

        <!-- Tabla de contactos -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th> 
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($contacto = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $contacto['id']; ?></td>
                            <td><?php echo htmlspecialchars($contacto['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($contacto['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($contacto['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($contacto['email']); ?></td>
                            <td>
                                <a href="editar_contacto.php?id=<?php echo $contacto['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="index.php?eliminar_id=<?php echo $contacto['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este contacto?');">
                                    <i class="fas fa-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
