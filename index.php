<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplicador de Encuestas - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="styles.css">

</head>

<body>

  <div class="container">

    <h1>Aplicador de Encuestas</h1>

    <div class="login-box">

      <h2>Login</h2>

      <img src="login-icon.jpg" alt="Login Icon" class="login-icon">

      <!-- Aquí configuramos el formulario para interactuar con PHP -->
      <form action="login.php" method="POST"> 

        <input type="text" name="usuario" placeholder="Usuario" class="input-field" required>

        <input type="password" name="contrasena" placeholder="Contraseña" class="input-field" required>
        
        <button type="submit" class="login-button">Iniciar sesión</button>

      </form>

    </div>

  </div>
  
</body>
</html>
