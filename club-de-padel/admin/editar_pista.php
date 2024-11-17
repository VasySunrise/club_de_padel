<?php
global $conn;
session_start();
include '../includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 0) {
    header("Location: ../index.php");
    exit;
}

// Obtener los detalles de la pista a editar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM PISTA WHERE id_pista = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $pista = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);

    try {
        // Actualizar el nombre de la pista
        $query = $conn->prepare("UPDATE PISTA SET nombre = ? WHERE id_pista = ?");
        $query->bind_param("si", $nombre, $id);
        $query->execute();

        // Mensaje de éxito
        $_SESSION['mensaje_exito'] = "La pista '{$nombre}' ha sido actualizada con éxito.";
    } catch (mysqli_sql_exception $e) {
        // Mensaje de error
        $_SESSION['mensaje_error'] = "Error al actualizar la pista: " . $e->getMessage();
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
    <title>Editar Pista</title>
    <link rel="stylesheet" href="../includes/editar_pista_styles.css">
</head>
<body>
<div class="container">
    <h1>Editar Pista</h1>
    <form method="POST">
        <label for="nombre">Nombre de la Pista:</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($pista['nombre']) ?>" required>
        <button type="submit">Guardar Cambios</button>
    </form>
</div>
</body>
</html>



