<?php
// Iniciar sesión
session_start();

// Configuración de la base de datos
$host = "mysql"; 
$usuario = "root"; 
$password = "root"; 
$base_datos = "AplicadorEncuestas"; 
$puerto = 3306;

// Conexión a MySQL
$conn = new mysqli($host, $usuario, $password, $base_datos, $puerto);

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Procesar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar el usuario
    $query = "SELECT id, contrasena FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $id_usuario = $fila['id'];
        $hash_almacenado = $fila['contrasena'];

        // Verificar la contraseña ingresada con el hash almacenado
        if (password_verify($contrasena, $hash_almacenado)) {
            // Guardar usuario en la sesión
            $_SESSION['usuario'] = $usuario;
            $_SESSION['id_usuario'] = $id_usuario;

            // Redirige a la página de encuestas
            header("Location: encuestas.php");
            exit;
        } else {
            // Contraseña incorrecta
            header("Location: index.php?error=1"); // Redirige con mensaje de error
            exit;
        }
    } else {
        // Usuario no encontrado
        header("Location: index.php?error=2"); // Redirige con mensaje de error
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
