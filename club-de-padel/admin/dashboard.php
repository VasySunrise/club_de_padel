<?php
global $conn;
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] != 0) {
    header("Location: ../index.php");
    exit;
}

include '../includes/db.php';

// Consultar usuarios
$usuarios = $conn->query("SELECT * FROM USUARIO");

// Consultar pistas
$pistas = $conn->query("SELECT * FROM PISTA");

// Consultar reservas
$reservas = $conn->query("SELECT R.id_reserva, U.nombre AS usuario, P.nombre AS pista, R.turno 
                          FROM RESERVA R
                          JOIN USUARIO U ON R.usuario = U.id_usuario
                          JOIN PISTA P ON R.pista = P.id_pista");
// Mensajes
if (isset($_SESSION['mensaje_exito'])) {
    echo "<div class='mensaje-exito'>{$_SESSION['mensaje_exito']}</div>";
    unset($_SESSION['mensaje_exito']); // Limpiar mensaje después de mostrarlo
}

if (isset($_SESSION['mensaje_error'])) {
    echo "<div class='mensaje-error'>{$_SESSION['mensaje_error']}</div>";
    unset($_SESSION['mensaje_error']); // Limpiar mensaje después de mostrarlo
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../includes/dashboard_styles.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const mensajes = document.querySelectorAll('.mensaje-exito, .mensaje-error');
            mensajes.forEach(function (mensaje) {
                setTimeout(() => {
                    mensaje.style.transition = "opacity 1s ease";
                    mensaje.style.opacity = "0";
                    setTimeout(() => mensaje.remove(), 1000); // Elimina el elemento del DOM después del fade-out
                }, 3000); // Tiempo antes de comenzar el fade-out (3 segundos)
            });
        });
    </script>
    <script>
        function confirmarBorradoUsuario(id) {
            // Mostrar un cuadro de confirmación
            const confirmacion = confirm(`¿Estás seguro de que deseas borrar el usuario con ID ${id}?`);
            return confirmacion; // Devuelve true para proceder con el borrado o false para cancelarlo
        }
    </script>
    <script>
        function confirmarBorradoPista(id) {
            // Mostrar un cuadro de confirmación
            const confirmacion = confirm(`¿Estás seguro de que deseas borrar la pista con ID ${id}?`);
            return confirmacion; // Devuelve true para proceder con el borrado o false para cancelarlo
        }
    </script>
    <script>
        function confirmarBorradoReserva(id) {
            const confirmacion = confirm(`¿Estás seguro de que deseas borrar la reserva con ID ${id}?`);
            return confirmacion; // Devuelve true si el usuario confirma, o false si cancela
        }
    </script>
    <script>
        function confirmarBorrarTodasReservas() {
            const confirmacion = confirm("¿Estás seguro de que deseas borrar todas las reservas?");
            return confirmacion; // Devuelve true para proceder o false para cancelar
        }
    </script>
</head>
<body>
<!-- Encabezado -->
<div class="header">
    <h1>Panel de Administración</h1>
    <a href="../logout.php" class="logout-btn">Cerrar Sesión</a>
</div>
<!-- Contenido principal -->
<div class="container">
    <!-- Gestión de Usuarios -->
    <h2>Gestión de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?= $usuario['id_usuario'] ?></td>
                <td><?= $usuario['nombre'] ?></td>
                <td><?= $usuario['tipo'] == 0 ? 'Administrador' : 'Usuario' ?></td>
                <td>
                    <a href="editar_usuario.php?id=<?= $usuario['id_usuario'] ?>" class="btn">Editar</a>
                    <a href="borrar_usuario.php?id=<?= $usuario['id_usuario'] ?>"
                       class="btn"
                       onclick="return confirmarBorradoUsuario('<?= $usuario['id_usuario'] ?>')">Borrar</a>


                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <form method="POST" action="nuevo_usuario.php">
        <h3>Crear Usuario</h3>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" id="pass" placeholder="Contraseña" required>
        <label for="tipo">Tipo de Usuario:</label>
        <select name="tipo" id="tipo">
            <option value="0">Administrador</option>
            <option value="1">Usuario</option>
        </select>
        <button type="submit">Crear</button>
    </form>

    <!-- Gestión de Pistas -->
    <h2>Gestión de Pistas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        <?php while ($pista = $pistas->fetch_assoc()): ?>
            <tr>
                <td><?= $pista['id_pista'] ?></td>
                <td><?= $pista['nombre'] ?></td>
                <td>
                    <a href="editar_pista.php?id=<?= $pista['id_pista'] ?>" class="btn">Editar</a>
                    <a href="borrar_pista.php?id=<?= $pista['id_pista'] ?>"
                       class="btn"
                       onclick="return confirmarBorradoPista('<?= $pista['id_pista'] ?>')">Borrar</a>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <form method="POST" action="nueva_pista.php">
        <h3>Crear Nueva Pista</h3>
        <label for="nombre_pista">Nombre de la Pista:</label>
        <input type="text" name="nombre" id="nombre_pista" placeholder="Nombre de la pista" required>
        <button type="submit">Crear</button>
    </form>

    <!-- Gestión de Reservas -->
    <h2>Gestión de Reservas</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Pista</th>
            <th>Turno</th>
            <th>Acciones</th>
        </tr>
        <?php while ($reserva = $reservas->fetch_assoc()): ?>
            <tr>
                <td><?= $reserva['id_reserva'] ?></td>
                <td><?= $reserva['usuario'] ?></td>
                <td><?= $reserva['pista'] ?></td>
                <td><?= $reserva['turno'] ?></td>
                <td>
                    <a href="borrar_reserva.php?id=<?= $reserva['id_reserva'] ?>"
                       class="btn"
                       onclick="return confirmarBorradoReserva('<?= $reserva['id_reserva'] ?>')">Borrar</a>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <form method="POST" action="borrar_todas_reservas.php">
        <button type="submit" onclick="return confirmarBorrarTodasReservas()">Borrar todas las reservas</button>
    </form>
</div>
<footer class="footer">
    <p>&copy; Vasilica Barsan Boca - 2024 Club de Pádel. Todos los derechos reservados.</p>
</footer>
</body>
</html>
