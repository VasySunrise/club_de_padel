<?php
global $conn;
session_start();
include '../includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 0) {
    header("Location: ../index.php");
    exit;
}

// Verificar si se ha pasado un ID válido
if (isset($_GET['id'])) {
    $pista_id = intval($_GET['id']);

    try {
        // Preparar la consulta de eliminación
        $query = $conn->prepare("DELETE FROM PISTA WHERE id_pista = ?");
        $query->bind_param("i", $pista_id);

        // Ejecutar la consulta
        $query->execute();

        if ($query->affected_rows > 0) {
            // Si la pista fue eliminada
            $_SESSION['mensaje_exito'] = "La pista con ID $pista_id ha sido eliminada con éxito.";
        } else {
            // Si no se eliminó ninguna fila (por ejemplo, si el ID no existe)
            $_SESSION['mensaje_error'] = "No se pudo encontrar la pista con ID $pista_id.";
        }

    } catch (mysqli_sql_exception $e) {
        // Manejar errores de integridad referencial (como reservas asociadas a la pista)
        if ($e->getCode() === 1451) { // Código de error para restricción de clave foránea
            $_SESSION['mensaje_error'] = "No se puede eliminar la pista con ID $pista_id porque tiene reservas asociadas. Elimine las reservas antes de borrar la pista.";
        } else {
            // Otros errores de base de datos
            $_SESSION['mensaje_error'] = "Error al intentar eliminar la pista: " . $e->getMessage();
        }
    }
}

// Redirigir de vuelta al panel de administración
header("Location: dashboard.php");
exit;
?>


