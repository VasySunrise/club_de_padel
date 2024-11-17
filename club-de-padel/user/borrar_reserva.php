<?php
session_start();
include '../includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $reserva_id = intval($_GET['id']);
    $usuario_id = $_SESSION['id_usuario'];

    // Verificar si la reserva pertenece al usuario actual
    $query = $conn->prepare("SELECT * FROM RESERVA WHERE id_reserva = ? AND usuario = ?");
    $query->bind_param("ii", $reserva_id, $usuario_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Borrar la reserva
        $delete_query = $conn->prepare("DELETE FROM RESERVA WHERE id_reserva = ?");
        $delete_query->bind_param("i", $reserva_id);

        if ($delete_query->execute()) {
            $_SESSION['mensaje_exito'] = "Reserva eliminada con éxito.";
        } else {
            $_SESSION['mensaje_error'] = "Error al intentar eliminar la reserva.";
        }
        $delete_query->close();
    } else {
        $_SESSION['mensaje_error'] = "No se encontró la reserva o no tienes permisos para eliminarla.";
    }

    $query->close();
    header("Location: dashboard.php");
    exit;
}
?>

