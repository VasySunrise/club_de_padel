<?php
global $conn;
session_start();
include '../includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 0) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM USUARIO WHERE id_usuario = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $usuario = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $tipo = intval($_POST['tipo']);

    try {
        $query = $conn->prepare("UPDATE USUARIO SET nombre = ?, tipo = ? WHERE id_usuario = ?");
        $query->bind_param("sii", $nombre, $tipo, $id);
        $query->execute();

        // Mensaje de éxito
        $_SESSION['mensaje_exito'] = "El usuario '{$nombre}' ha sido actualizado con éxito.";
    } catch (mysqli_sql_exception $e) {
        // Mensaje de error
        $_SESSION['mensaje_error'] = "Error al actualizar el usuario: " . $e->getMessage();
    }

    // Redirigir al panel de administración
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../includes/editar_usuario_styles.css">
</head>
<body>
<div class="container">
    <h1>Editar Usuario</h1>
    <form method="POST">
        <label for="nombre">Nombre del Usuario:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label for="tipo">Tipo de Usuario:</label>
        <select name="tipo" id="tipo">
            <option value="0" <?= $usuario['tipo'] == 0 ? 'selected' : '' ?>>Administrador</option>
            <option value="1" <?= $usuario['tipo'] == 1 ? 'selected' : '' ?>>Usuario</option>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>
</div>
</body>
</html>


