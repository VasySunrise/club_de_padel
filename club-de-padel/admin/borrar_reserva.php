<?php
global $conn;
session_start();
include '../includes/db.php';

if (isset($_GET['id'])) {
    $reserva_id = intval($_GET['id']);

    try {
        $query = $conn->prepare("DELETE FROM RESERVA WHERE id_reserva = ?");
        $query->bind_param("i", $reserva_id);
        $query->execute();

        $_SESSION['mensaje_exito'] = "La reserva con ID $reserva_id ha sido eliminada con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensaje_error'] = "Error al borrar la reserva: " . $e->getMessage();
    }

    header("Location: dashboard.php");
    exit;
}
?>

