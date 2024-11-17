<?php
global $conn;
session_start();
include '../includes/db.php';

try {
    $query = $conn->query("DELETE FROM RESERVA");
    $_SESSION['mensaje_exito'] = "Todas las reservas han sido eliminadas con éxito.";
} catch (mysqli_sql_exception $e) {
    $_SESSION['mensaje_error'] = "Error al borrar todas las reservas: " . $e->getMessage();
}

header("Location: dashboard.php");
exit;
?>


