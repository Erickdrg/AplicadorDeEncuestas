<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?error=3");
    exit;
}

$host = "mysql"; 
$usuario = "root"; 
$password = "root"; 
$base_datos = "AplicadorEncuestas"; 
$puerto = 3306;

$conn = new mysqli($host, $usuario, $password, $base_datos, $puerto);

if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

$usuario = $_SESSION['usuario'];

$query_usuario = "SELECT id FROM usuarios WHERE usuario = ?";
$stmt_usuario = $conn->prepare($query_usuario);
$stmt_usuario->bind_param("s", $usuario);
$stmt_usuario->execute();
$resultado_usuario = $stmt_usuario->get_result();
$fila_usuario = $resultado_usuario->fetch_assoc();
$id_usuario = $fila_usuario['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    
    // Insertar la encuesta
    $query_insert_encuesta = "INSERT INTO encuestas (titulo, descripcion, id_usuario) VALUES (?, ?, ?)";
    $stmt_insert_encuesta = $conn->prepare($query_insert_encuesta);
    $stmt_insert_encuesta->bind_param("ssi", $titulo, $descripcion, $id_usuario);
    $stmt_insert_encuesta->execute();
    $id_encuesta = $stmt_insert_encuesta->insert_id;
    
    // Insertar preguntas
    if (isset($_POST['preguntas']) && is_array($_POST['preguntas'])) {
        foreach ($_POST['preguntas'] as $pregunta) {
            $texto_pregunta = $pregunta['texto'];
            $tipo_pregunta = $pregunta['tipo'];
            
            // Validar el tipo de pregunta
            if (!in_array($tipo_pregunta, ['texto', 'multiple', 'opcion'])) {
                $tipo_pregunta = 'texto'; // Valor predeterminado
            }
            
            // Insertar la pregunta
            $query_insert_pregunta = "INSERT INTO preguntas (id_encuesta, texto_pregunta, tipo_pregunta) VALUES (?, ?, ?)";
            $stmt_insert_pregunta = $conn->prepare($query_insert_pregunta);
            $stmt_insert_pregunta->bind_param("iss", $id_encuesta, $texto_pregunta, $tipo_pregunta);
            $stmt_insert_pregunta->execute();
            $id_pregunta = $stmt_insert_pregunta->insert_id;
            
            // Insertar opciones si el tipo es 'opcion'
            if ($tipo_pregunta === 'opcion' && isset($pregunta['opciones']) && is_array($pregunta['opciones'])) {
                foreach ($pregunta['opciones'] as $opcion) {
                    if (!empty(trim($opcion))) {
                        $query_insert_opcion = "INSERT INTO opciones (id_pregunta, texto_opcion) VALUES (?, ?)";
                        $stmt_insert_opcion = $conn->prepare($query_insert_opcion);
                        $stmt_insert_opcion->bind_param("is", $id_pregunta, $opcion);
                        $stmt_insert_opcion->execute();
                    }
                }
            }
        }
    }
    
    header("Location: encuestas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Encuesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
        }
        .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .btn-custom {
            width: 100%;
            margin-top: 1rem;
        }
        .pregunta-card {
            background-color: #f1f1f1;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h1 class="text-center mb-4">Crear Nueva Encuesta</h1>
            <form method="POST" action="crear_encuesta.php">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título de la Encuesta</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                </div>
                
                <div id="preguntas-container">
                    <h4 class="mb-3">Preguntas</h4>
                </div>
                
                <button type="button" class="btn btn-secondary btn-custom" onclick="agregarPregunta()">
                    Agregar Pregunta
                </button>
                
                <button type="submit" class="btn btn-success btn-custom">
                    Guardar Encuesta
                </button>
            </form>
        </div>
    </div>

    <script>
        let preguntaCount = 0; // Contador para índices de preguntas

        function agregarPregunta() {
            let container = document.getElementById('preguntas-container');
            let preguntaHTML = `
                <div class="pregunta-card">
                    <div class="mb-3">
                        <label class="form-label">Pregunta</label>
                        <input type="text" name="preguntas[${preguntaCount}][texto]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Pregunta</label>
                        <select name="preguntas[${preguntaCount}][tipo]" class="form-control" onchange="mostrarOpciones(this)">
                            <option value="texto">Texto</option>
                            <option value="opcion">Opción</option>
                        </select>
                    </div>
                    <div class="opciones-container mb-3" style="display:none;">
                        <button type="button" class="btn btn-sm btn-primary" onclick="agregarOpcion(${preguntaCount})">
                            Agregar Opción
                        </button>
                        <div class="opciones mt-2"></div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', preguntaHTML);
            preguntaCount++; // Incrementar el contador de preguntas
        }

        function mostrarOpciones(select) {
            let container = select.closest('.pregunta-card').querySelector('.opciones-container');
            container.style.display = select.value === 'opcion' ? 'block' : 'none';
        }

        function agregarOpcion(preguntaIndex) {
            let container = document.querySelectorAll('.pregunta-card')[preguntaIndex].querySelector('.opciones');
            let opcionHTML = `
                <input type="text" name="preguntas[${preguntaIndex}][opciones][]" class="form-control mt-2" placeholder="Opción" required>
            `;
            container.insertAdjacentHTML('beforeend', opcionHTML);
        }
    </script>
</body>
</html>
