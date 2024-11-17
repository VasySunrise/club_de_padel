<?php
$host = 'localhost:1986';
$user = 'vasilica';
$password = 'Vasi2024';
$database = 'padel';

try {
    $conn = new mysqli($host, $user, $password, $database);

    // Verificar si hay errores en la conexión
    if ($conn->connect_error) {
        throw new Exception("Error de conexión a la base de datos en el puerto 1986, comprueba el puerto el usuario o contraseña: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // Mostrar un mensaje amigable al usuario con estilo CSS
    echo <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Conexión</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff4d4d, #ff9999);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .error-container h2 {
            color: #ff4d4d;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }
        .error-container p {
            font-size: 1rem;
            margin: 10px 0;
        }
        .error-container .details {
            font-size: 0.9rem;
            color: #666;
            margin-top: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h2>Error de Conexión</h2>
        <p>No se pudo conectar a la base de datos. Por favor, verifica el fichero de conexión.</p>
        <div class="details">Detalles técnicos: {$e->getMessage()}</div>
    </div>
</body>
</html>
HTML;
    exit;
}
?>

