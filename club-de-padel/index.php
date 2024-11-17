<?php
global $conn;
session_start();
include 'includes/db.php';

// Verificar si existe el usuario 'admin'
$admin_check_query = $conn->prepare("SELECT * FROM USUARIO WHERE nombre = 'admin'");
$admin_check_query->execute();
$admin_result = $admin_check_query->get_result();
$admin_exists = ($admin_result->num_rows > 0);
$admin_check_query->close();

// Manejo del inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $password_ingresada = $_POST['pass'];

    $query = $conn->prepare("SELECT * FROM USUARIO WHERE nombre = ?");
    $query->bind_param("s", $nombre);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        // Verificar la contraseña usando password_verify
        if (password_verify($password_ingresada, $usuario['pass'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['tipo'] = $usuario['tipo'];

            if ($usuario['tipo'] == 0) {
                header("Location: admin/dashboard.php");
                exit();
            } else {
                header("Location: user/dashboard.php");
                exit();
            }
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Club de Pádel</title>
    <link rel="stylesheet" href="includes/index_styles.css">
</head>
<body>
<!-- Encabezado moderno -->
<header class="main-header">
    <h1>Club de Pádel</h1>
    <p>Bienvenido al sistema de gestión. Por favor, inicia sesión para continuar.</p>
</header>

<!-- Contenedor del panel de login -->
<div class="container">
    <h2>Inicio de Sesión</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="">
        <label for="nombre"><strong>Nombre de Usuario:</strong></label>
        <input type="text" name="nombre" id="nombre" value="admin" readonly>
        <label for="pass"><strong>Contraseña:</strong></label>
        <input type="password" name="pass" id="pass" placeholder="Introduce tu contraseña" required>
        <div class="form-buttons">
            <button type="submit">Entrar</button><br>
            <?php if (!$admin_exists): ?>
                <br>
                <button class="generate-admin-btn" onclick="window.location.href='crear_admin.php';">Generar usuario 'ADMIN'</button>
                <br>
                <br>
                <strong>🔒 Atención:</strong>
                <br>
                <br>
                <small>Por tu comodidad, 🛠️ genera un usuario administrador para poder empezar a operar con la aplicación.</small>
                <br>
                <br>
                <small>😊 ¡Es un pequeño paso para una experiencia más fluida y segura!</small>
                <small>😊 ¡Esta operacion solo aparece al principio!</small>
            <?php endif; ?>
        </div>
    </form>
</div>
<footer class="footer">
    <p>&copy; Vasilica Barsan Boca - 2024 Club de Pádel. Todos los derechos reservados.</p>
</footer>
</body>
</html>




