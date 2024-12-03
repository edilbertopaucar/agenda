<?php

require_once('../agendavirtual/conexion.php');


class usuarios {
    public $nombre, $apellidos, $usuario, $email, $password;
    public $conexion;

    public function __construct($conexion, $nombre = null, $apellidos = null, $usuario = null, $email = null, $password = null) {
        $this->conexion = $conexion;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->usuario = $usuario;
        $this->email = $email;
        $this->password = $password;
    }

    public function registrarUsuario() {
        $sql = "INSERT INTO `bd_usuarios`(nombre, apellidos, usuario, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $this->nombre, $this->apellidos, $this->usuario, $this->email, $this->password);

        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al registrar el Usuario: " . mysqli_error($this->conexion);
        }

        mysqli_stmt_close($stmt);
    }

    // Método para mostrar usuarios
    public static function mostrarUsuarios($conexion) {
        $sql = "SELECT * FROM `bd_usuarios`";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $fila["id"] . " - Nombre: " . $fila["nombre"] . " - Apellido: " . $fila["apellidos"] . " - Usuario: " . $fila["usuario"] . " - Correo: " . $fila["email"] . " - Password: " . $fila["password"] . "<br>";
            }
        } else {
            echo "No hay resultados.";
        }

        mysqli_stmt_close($stmt);
    }

    // Método para actualizar un usuario
    public function actualizarUsuario($id) {
        $sql = "UPDATE `bd_usuarios` SET nombre = ?, apellidos = ?, usuario = ?, email = ?, password = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssssi", $this->nombre, $this->apellidos, $this->usuario, $this->email, $this->password, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario actualizado correctamente.";
        } else {
            echo "Error al actualizar el usuario: " . mysqli_error($this->conexion);
        }

        mysqli_stmt_close($stmt);
    }

    // Método para eliminar un usuario
    public function eliminarUsuario($id) {
        $sql = "DELETE FROM `bd_usuarios` WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Usuario eliminado correctamente.";
        } else {
            echo "Error al eliminar el usuario: " . mysqli_error($this->conexion);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

