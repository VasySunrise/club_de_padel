<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 1) {
    header("Location: ../index.php");
    exit;
}

include '../includes/db.php';

// Mostrar mensajes de éxito o error
if (isset($_SESSION['mensaje_exito'])) {
    echo "<div class='mensaje-exito'>{$_SESSION['mensaje_exito']}</div>";
    unset($_SESSION['mensaje_exito']);
}

if (isset($_SESSION['mensaje_error'])) {
    echo "<div class='mensaje-error'>{$_SESSION['mensaje_error']}</div>";
    unset($_SESSION['mensaje_error']);
}

// Consultar reservas del usuario actual
$reservas = $conn->query("SELECT R.id_reserva, P.nombre AS pista, R.turno 
                          FROM RESERVA R
                          JOIN PISTA P ON R.pista = P.id_pista
                          WHERE R.usuario = {$_SESSION['id_usuario']}");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="../includes/dashboard_styles.css">
    <script>
        // Script para desaparecer el mensaje después de unos segundos
        document.addEventListener("DOMContentLoaded", function() {
            const mensajes = document.querySelectorAll('.mensaje-exito, .mensaje-error');
            mensajes.forEach(function(mensaje) {
                setTimeout(() => {
                    mensaje.style.transition = "opacity 1s ease";
                    mensaje.style.opacity = "0";
                    setTimeout(() => mensaje.remove(), 1000); // Elimina el elemento del DOM después del fade-out
                }, 3000); // Tiempo antes de que comience el fade-out (3 segundos)
            });
        });
    </script>
    <script>
        function confirmarBorrado(id) {
            // Mostrar un mensaje de confirmación
            const confirmacion = confirm(`¿Estás seguro de que deseas borrar la reserva con ID ${id}?`);
            return confirmacion; // Devuelve true para proceder con el borrado o false para cancelarlo
        }
    </script>
</head>
<body>
<!-- Encabezado -->
<div class="header">
    <h1>Panel de Usuario</h1>
    <a href="../logout.php" class="logout-btn">Cerrar Sesión</a>
</div>

<!-- Contenedor principal -->
<div class="container">
    <!-- Reservas -->
    <h2>Mis Reservas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Pista</th>
            <th>Turno</th>
            <th>Acciones</th>
        </tr>
        <?php while ($reserva = $reservas->fetch_assoc()): ?>
            <tr>
                <td><?= $reserva['id_reserva'] ?></td>
                <td><?= $reserva['pista'] ?></td>
                <td><?= $reserva['turno'] ?></td>
                <td>
                    <a href="borrar_reserva.php?id=<?= $reserva['id_reserva'] ?>"
                       class="btn"
                       onclick="return confirmarBorrado('<?= $reserva['id_reserva'] ?>')">Borrar</a>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Crear Reserva -->
    <h2>Crear Reserva</h2>
    <form method="POST" action="nueva_reserva.php">
        <select name="pista" required>
            <option value="">Selecciona una pista</option>
            <?php
            $pistas = $conn->query("SELECT * FROM PISTA");
            while ($pista = $pistas->fetch_assoc()):
                ?>
                <option value="<?= $pista['id_pista'] ?>"><?= $pista['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="turno" placeholder="Turno (1-24)" required>
        <button type="submit">Reservar</button>
    </form>
</div>
<footer class="footer">
    <p>&copy; Vasilica Barsan Boca - 2024 Club de Pádel. Todos los derechos reservados.</p>
</footer>
</body>
</html>
