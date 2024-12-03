<?php
require_once('../agendavirtual/conexion.php');
require_once('../agendavirtual/clases/usuarios.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Consulta SQL
    $query = "INSERT INTO `bd_usuarios`(`nombre`, `apellidos`, `usuario`, `email`, `password`) VALUES (?, ?, ?, ?, ?)";
    
    // Preparar la consulta
    $stmt = mysqli_prepare($conexion, $query);
    
    if ($stmt === false) {
        // Si la preparación falla, muestra el error de la consulta
        die('Error al preparar la consulta: ' . mysqli_error($conexion));
    }

    // Asociar los parámetros
    mysqli_stmt_bind_param($stmt, "sssss", $nombre, $apellidos, $usuario, $email, $password);

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Error al registrarse: " . mysqli_error($conexion);
    }

    // Cerrar la declaración
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrarse</title>
</head>
<body class="bg-primary d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-3 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h1 class="text-center mb-3 text-primary fw-bold">Crea tu cuenta</h1>
                        <!-- Mensaje de error -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <!-- Formulario -->
                        <form action="register.php" method="post" novalidate>
                            <div class="mb-2">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa tu nombre" required>
                            </div>
                            <div class="mb-2">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ingresa tu apellido" required>
                            </div>
                            <div class="mb-2">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Crea tu nombre de usuario" required>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Ingresa tu correo electrónico" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Crea tu contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                            <p class="text-center mt-2 text-muted">
                                ¿Ya tienes una cuenta? <a href="login.php" class="text-decoration-none">Inicia Sesión</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
