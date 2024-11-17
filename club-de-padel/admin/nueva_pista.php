<?php
global $conn;
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);

    try {
        $query = $conn->prepare("INSERT INTO PISTA (nombre) VALUES (?)");
        $query->bind_param("s", $nombre);
        $query->execute();

        $_SESSION['mensaje_exito'] = "La pista '$nombre' se ha creado con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensaje_error'] = "Error al crear la pista: " . $e->getMessage();
    }

    header("Location: dashboard.php");
    exit;
}
?>


