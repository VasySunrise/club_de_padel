<?php
global $conn;
session_start();
include '../includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 0) {
    header("Location: ../index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $password = $_POST['password'];

    // Verificar la contraseña del usuario actualmente logueado
    $query = $conn->prepare("SELECT pass FROM USUARIO WHERE id_usuario = ?");
    $query->bind_param("i", $_SESSION['id_usuario']);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $usuario_actual = $result->fetch_assoc();

        if (password_verify($password, $usuario_actual['pass'])) {
            // Verificar si el usuario tiene reservas asociadas
            $query_check_reservas = $conn->prepare("SELECT COUNT(*) AS total FROM RESERVA WHERE usuario = ?");
            $query_check_reservas->bind_param("i", $id);
            $query_check_reservas->execute();
            $result_check_reservas = $query_check_reservas->get_result();
            $reservas = $result_check_reservas->fetch_assoc();

            if ($reservas['total'] > 0) {
                // Usuario tiene reservas, mostrar mensaje de error
                $error = "No se puede borrar el usuario porque tiene reservas asociadas.";
            } else {
                // Usuario no tiene reservas, proceder a eliminar
                $delete_query = $conn->prepare("DELETE FROM USUARIO WHERE id_usuario = ?");
                $delete_query->bind_param("i", $id);

                if ($delete_query->execute()) {
                    // Configurar mensaje de éxito en sesión
                    $_SESSION['mensaje_exito'] = "Usuario eliminado con éxito.";
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Error al intentar borrar el usuario.";
                }
                $delete_query->close();
            }
            $query_check_reservas->close();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
    $query->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Usuario</title>
    <link rel="stylesheet" href="../includes/editar_usuario_styles.css">
</head>
<body>
<div class="container">
    <h1>¿Por seguridad, ingrese tu contraseña?</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <label for="password">Confirma tu contraseña:</label>
        <input type="password" name="password" id="password" placeholder="Introduce tu contraseña" required>
        <button type="submit">Confirmar Borrado</button>
    </form>
    <a href="dashboard.php" class="btn">Cancelar</a>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
</div>
</body>
</html>





