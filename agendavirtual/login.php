<?php
session_start(); // Inicia o reanuda la sesión
require_once('../agendavirtual/conexion.php');
require_once('../agendavirtual/clases/usuarios.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password'];

    $query = "SELECT * FROM `bd_usuarios` WHERE usuario = '$usuario'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['autenticado'] = true; // Indica que el usuario está autenticado
            header("Location: index.php"); // Redirige al index
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "El usuario no existe.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
</head>
<body class="bg-primary d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4 shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h1 class="text-center mb-4 text-primary fw-bold">Iniciar Sesión</h1>
                        <!-- Mensaje de error -->
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <!-- Formulario -->
                        <form action="login.php" method="post" novalidate>
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingresa tu usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                            <p class="text-center mt-3 text-muted">
                                ¿No tienes una cuenta? <a href="register.php" class="text-decoration-none">Regístrate aquí</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
