<?php
global $conn;
include 'includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $tipo = intval($_POST['tipo']); // 0 para admin, 1 para usuario

    // Verificar si las contraseñas coinciden
    if ($password !== $confirm_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        // Verificar si el usuario ya existe
        $query = $conn->prepare("SELECT * FROM USUARIO WHERE nombre = ?");
        $query->bind_param("s", $nombre);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            $error = "El nombre de usuario ya existe.";
        } else {
            // Insertar el nuevo usuario
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $insert_query = $conn->prepare("INSERT INTO USUARIO (nombre, pass, tipo) VALUES (?, ?, ?)");
            $insert_query->bind_param("ssi", $nombre, $hashed_password, $tipo);

            if ($insert_query->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $error = "No se pudo crear el usuario. Inténtalo de nuevo.";
            }
            $insert_query->close();
        }
        $query->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="includes/index_styles.css">
</head>
<body>
<!-- Encabezado moderno -->
<header class="main-header">
    <h1>Club de Pádel</h1>
    <p>Crear un nuevo usuario en el sistema.</p>
</header>

<!-- Contenedor principal -->
<div class="container">
    <h2>Crear Usuario</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="">
        <label for="nombre"><strong>Nombre de Usuario:</strong></label>
        <input type="text" name="nombre" id="nombre" value="admin" readonly>

        <label for="password"><strong>Elige una contraseña:</strong></label>
        <input type="password" name="password" id="password" placeholder="mínimo 8 caracteres" required minlength="8">

        <label for="confirm_password"><strong>Confirma tu contraseña:</strong></label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Repite la contraseña" required minlength="8">
        <br>
        <small>La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una minúscula, un número y un carácter especial.</small>
        <br>
        <label for="tipo"><strong>Tipo de Usuario:</strong></label>
        <select name="tipo" id="tipo">
            <option value="0">Administrador</option>
        </select><br>

        <button type="submit">Crear Usuario</button><br>
        <button class="generate-admin-btn" onclick="window.location.href='index.php';">Volver al inicio</button>
    </form>
</div>

<!-- Script de validación de contraseña -->
<script>
    document.querySelector('form').addEventListener('submit', function (event) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        if (!passwordRegex.test(password)) {
            event.preventDefault(); // Evitar el envío del formulario
            alert('La contraseña debe tener al menos 8 caracteres, incluyendo una letra mayúscula, una minúscula, un número y un carácter especial.');
        } else if (password !== confirmPassword) {
            event.preventDefault(); // Evitar el envío del formulario
            alert('Las contraseñas no coinciden. Por favor, verifica.');
        }
    });
</script>

<footer class="footer">
    <p>&copy; Vasilica Barsan Boca - 2024 Club de Pádel. Todos los derechos reservados.</p>
</footer>
</body>
</html>
