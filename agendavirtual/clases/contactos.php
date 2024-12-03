<?php
require_once('../agendavirtual/conexion.php');
require_once('../agendavirtual/clases/usuarios.php');

class Contactos {
    private $conexion;
    private $usuario_nombre; // Campo usuario_nombre después de conexión
    private $nombre;
    private $apellido;
    private $telefono;
    private $email;

    // Constructor
    public function __construct($conexion, $usuario_nombre = null, $nombre = null, $apellido = null, $telefono = null, $email = null) {
        $this->conexion = $conexion;
        $this->usuario_nombre = $usuario_nombre; // Asignación del campo usuario_nombre
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->email = $email;
    }

    // Método para registrar un contacto
    public function registrarContacto() {
        // Preparamos la consulta SQL para insertar el nuevo contacto
        $sql = "INSERT INTO contactos (usuario_nombre, nombre, apellido, telefono, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            echo "Error al preparar la consulta: " . mysqli_error($this->conexion);
            return;
        }

        // Vinculamos los parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "sssss", $this->usuario_nombre, $this->nombre, $this->apellido, $this->telefono, $this->email);

        // Ejecutamos la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo "Contacto agregado correctamente.";
            // Redirigir a la página de la agenda después de agregar el contacto
            header("Location: index.php");
            exit;
        } else {
            echo "Error al agregar el contacto: " . mysqli_error($this->conexion);
        }

        // Cerramos la sentencia preparada
        mysqli_stmt_close($stmt);
    }

    // Método para mostrar contactos
    public static function mostrarContactos($conexion) {
        $sql = "SELECT * FROM contactos";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "ID: " . $fila["id"] . 
                     " - Usuario Nombre: " . $fila["usuario_nombre"] . 
                     " - Nombre: " . $fila["nombre"] . 
                     " - Apellido: " . $fila["apellido"] . 
                     " - Teléfono: " . $fila["telefono"] . 
                     " - Email: " . $fila["email"] . "<br>";
            }
        } else {
            echo "No hay resultados.";
        }

        mysqli_stmt_close($stmt);
    }

    // Método para actualizar un contacto
    public function actualizarContactos($id) {
        $sql = "UPDATE contactos SET usuario_nombre = ?, nombre = ?, apellido = ?, telefono = ?, email = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            echo "Error al preparar la consulta: " . mysqli_error($this->conexion);
            return;
        }

        mysqli_stmt_bind_param($stmt, "sssssi", $this->usuario_nombre, $this->nombre, $this->apellido, $this->telefono, $this->email, $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Contacto actualizado correctamente.";
        } else {
            echo "Error al actualizar el contacto: " . mysqli_error($this->conexion);
        }

        mysqli_stmt_close($stmt);
    }

    // Método para eliminar un contacto
    public function eliminarContactos($id) {
        $sql = "DELETE FROM contactos WHERE id = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            echo "Error al preparar la consulta: " . mysqli_error($this->conexion);
            return;
        }

        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            echo "Contacto eliminado correctamente.";
        } else {
            echo "Error al eliminar el contacto: " . mysqli_error($this->conexion);
        }

        mysqli_stmt_close($stmt);
    }
}
?>
