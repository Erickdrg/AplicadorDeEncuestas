<?php
// Inicia la sesión para identificar al usuario
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=3");
    exit;
}

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Aplicador de Encuestas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link active">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php
        // Mostrar la lista de encuestas
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['id'])) {
            $query = "SELECT id, titulo, descripcion FROM encuestas";
            $resultado = $conn->query($query);
            echo "<h1 class='text-center mb-4'>Encuestas Disponibles</h1>";

            if ($resultado->num_rows > 0) {
                echo "<div class='row'>";
                while ($encuesta = $resultado->fetch_assoc()) {
                    echo "<div class='col-md-4 mb-3'>";
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($encuesta['titulo']) . "</h5>";
                    echo "<p class='card-text'>" . htmlspecialchars($encuesta['descripcion']) . "</p>";
                    echo "<a href='?id=" . $encuesta['id'] . "' class='btn btn-primary'>Responder</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p class='text-center'>No hay encuestas disponibles en este momento.</p>";
            }
        }

        // Mostrar preguntas de la encuesta seleccionada
        if (isset($_GET['id'])) {
            $id_encuesta = (int)$_GET['id'];
            $query = "SELECT id, texto_pregunta, tipo_pregunta FROM preguntas WHERE id_encuesta = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_encuesta);
            $stmt->execute();
            $resultado = $stmt->get_result();

            echo "<h1 class='text-center mb-4'>Responde la Encuesta</h1>";
            echo "<form method='POST' action='' class='p-4 border rounded bg-light'>";
            echo "<input type='hidden' name='id_encuesta' value='{$id_encuesta}'>";

            while ($pregunta = $resultado->fetch_assoc()) {
                echo "<div class='mb-3'>";
                echo "<label class='form-label'>" . htmlspecialchars($pregunta['texto_pregunta']) . "</label>";

                if ($pregunta['tipo_pregunta'] === 'opcion') {
                    $id_pregunta = $pregunta['id'];
                    $query_opciones = "SELECT id, texto_opcion FROM opciones WHERE id_pregunta = ?";
                    $stmt_opciones = $conn->prepare($query_opciones);
                    $stmt_opciones->bind_param("i", $id_pregunta);
                    $stmt_opciones->execute();
                    $opciones = $stmt_opciones->get_result();

                    while ($opcion = $opciones->fetch_assoc()) {
                        echo "<div class='form-check'>";
                        echo "<input class='form-check-input' type='radio' name='respuesta[{$id_pregunta}]' value='" . htmlspecialchars($opcion['texto_opcion']) . "'>";
                        echo "<label class='form-check-label'>" . htmlspecialchars($opcion['texto_opcion']) . "</label>";
                        echo "</div>";
                    }
                } else {
                    echo "<textarea class='form-control' name='respuesta[{$pregunta['id']}]' rows='3'></textarea>";
                }

                echo "</div>";
            }

            echo "<button type='submit' class='btn btn-success'>Enviar Respuestas</button>";
            echo "</form>";
        }

        // Guardar respuestas en la base de datos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_encuesta = (int)$_POST['id_encuesta'];
            $usuario = $_SESSION['usuario'];

            // Obtener ID del usuario actual
            $query_usuario = "SELECT id FROM usuarios WHERE usuario = ?";
            $stmt_usuario = $conn->prepare($query_usuario);
            $stmt_usuario->bind_param("s", $usuario);
            $stmt_usuario->execute();
            $resultado_usuario = $stmt_usuario->get_result();
            $fila_usuario = $resultado_usuario->fetch_assoc();
            $id_usuario = $fila_usuario['id'];

            foreach ($_POST['respuesta'] as $id_pregunta => $respuesta) {
                $query_respuesta = "INSERT INTO respuestas (id_pregunta, id_usuario, respuesta) VALUES (?, ?, ?)";
                $stmt_respuesta = $conn->prepare($query_respuesta);
                $stmt_respuesta->bind_param("iis", $id_pregunta, $id_usuario, $respuesta);
                $stmt_respuesta->execute();
            }

            echo "<div class='alert alert-success mt-4'>¡Gracias por responder la encuesta!</div>";
            echo "<a href='encuestas.php' class='btn btn-primary mt-2'>Volver a las Encuestas</a>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
