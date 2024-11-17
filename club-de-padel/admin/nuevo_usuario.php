<?php
global $conn;
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $tipo = intval($_POST['tipo']);

    try {
        $query = $conn->prepare("INSERT INTO USUARIO (nombre, pass, tipo) VALUES (?, ?, ?)");
        $query->bind_param("ssi", $nombre, $pass, $tipo);
        $query->execute();

        $_SESSION['mensaje_exito'] = "El usuario '$nombre' se ha creado con éxito.";
    } catch (mysqli_sql_exception $e) {
        $_SESSION['mensaje_error'] = "Error al crear el usuario: " . $e->getMessage();
    }

    header("Location: dashboard.php");
    exit;
}
?>


