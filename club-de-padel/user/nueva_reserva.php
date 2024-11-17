<?php
session_start();
include '../includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['id_usuario'];
    $pista_id = intval($_POST['pista']);
    $turno = intval($_POST['turno']);

    // Validar que los datos sean correctos
    if ($pista_id <= 0 || $turno <= 0 || $turno > 24) {
        $_SESSION['mensaje_error'] = "Turno inválido o datos incorrectos.";
        header("Location: dashboard.php");
        exit;
    }

    // Comprobar si ya existe una reserva para la pista y el turno seleccionados
    $query = $conn->prepare("SELECT * FROM RESERVA WHERE pista = ? AND turno = ?");
    $query->bind_param("ii", $pista_id, $turno);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['mensaje_error'] = "El turno seleccionado ya está reservado.";
        header("Location: dashboard.php");
        exit;
    }

    // Crear la reserva
    $insert_query = $conn->prepare("INSERT INTO RESERVA (usuario, pista, turno) VALUES (?, ?, ?)");
    $insert_query->bind_param("iii", $usuario_id, $pista_id, $turno);

    if ($insert_query->execute()) {
        $_SESSION['mensaje_exito'] = "Reserva creada con éxito.";
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['mensaje_error'] = "Error al crear la reserva.";
        header("Location: dashboard.php");
        exit;
    }
}
?>

