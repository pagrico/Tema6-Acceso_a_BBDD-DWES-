<?php
include "conexion.php";

$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : null;
$detalle = isset($_GET['detalle']) ? $_GET['detalle'] : null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente = new stdClass();
    $cliente->nombre = $_POST["nombre"];
    $cliente->usuario = $_POST["usuario"];
    $cliente->email = $_POST["email"];
    $cliente->password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $sql = "INSERT INTO `usuario` (`nombre`, `usuario`, `password`, `email`) 
            VALUES ('$cliente->nombre', '$cliente->usuario', '$cliente->password', '$cliente->email')";

    if ($conexion->query($sql)) {
        // Redirigir con éxito
        header("Location: registro.php?mensaje=exito");
        exit;
    } else {
        // Redirigir con error
        $error = urlencode($conexion->error);
        header("Location: registro.php?mensaje=error&detalle=$error");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Registro de Usuario</h2>

        <!-- Mensaje de Feedback -->
        <?php if ($mensaje === 'exito'): ?>
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                El usuario se ha registrado correctamente.
            </div>
        <?php elseif ($mensaje === 'error'): ?>
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700">
                Hubo un error al registrar el usuario: <?php echo htmlspecialchars($detalle); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <form action="registro.php" method="POST">
            <!-- Campo Nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre:</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="nombre" id="nombre" required
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Campo Usuario -->
            <div class="mb-4">
                <label for="usuario" class="block text-gray-700 font-semibold mb-2">Usuario:</label>
                <div class="relative">
                    <i class="fas fa-user-tag absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" name="usuario" id="usuario" required
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Campo Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña:</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                    <input type="password" name="password" id="password" required
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Campo Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                    <input type="email" name="email" id="email" required
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Botón de Envío -->
            <div class="text-center">
                <button type="submit"
                    class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <i class="fas fa-paper-plane mr-2"></i>Registrar
                </button>
            </div>
        </form>
    </div>
</body>

</html>