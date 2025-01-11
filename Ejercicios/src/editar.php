<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>




<?php
include "conexion.php";

$ID = $_GET["id"] ?? null; // Aseguramos que ID esté definido.

if (!$ID) {
    die("ID no especificado.");
}

try {
    // Preparar consulta segura
    $sql = "SELECT * FROM campeon WHERE ID = ?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$ID]);
    $campeon = $sentencia->fetch(PDO::FETCH_ASSOC);

    if (!$campeon) {
        die("No se encontró ningún campeón con ID $ID.");
    }
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}

// Generar el formulario dinámico
echo '
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <form action="procesar_formulario.php" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-700">Formulario de Campeón</h2>
        
        <!-- Campo ID (solo lectura) -->
        <div class="mb-4">
            <label for="id" class="block text-gray-700 text-sm font-bold mb-2">ID:</label>
            <input type="text" id="id" name="id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-200 cursor-not-allowed" value="' . htmlspecialchars($campeon["ID"]) . '" readonly>
        </div>
        
        <!-- Campo Nombre -->
        <div class="mb-4">
            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="' . htmlspecialchars($campeon["Nombre"]) . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingrese el nombre">
        </div>
        
        <!-- Campo Rol -->
        <div class="mb-4">
            <label for="rol" class="block text-gray-700 text-sm font-bold mb-2">Rol:</label>
            <input type="text" id="rol" name="rol" value="' . htmlspecialchars($campeon["Rol"]) . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingrese el rol">
        </div>
        
        <!-- Campo Dificultad -->
        <div class="mb-4">
            <label for="dificultad" class="block text-gray-700 text-sm font-bold mb-2">Dificultad:</label>
            <input type="text" id="dificultad" name="dificultad" value="' . htmlspecialchars($campeon["Dificultad"]) . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ingrese la dificultad">
        </div>
        
        <!-- Campo Descripción -->
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4" placeholder="Ingrese la descripción">' . htmlspecialchars($campeon["Descripcion"]) . '</textarea>
        </div>
        
        <!-- Botón Enviar -->
        <div class="flex items-center justify-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Enviar
            </button>
            
        </div>
    </form>
</body>
';
?>
</body>

</html>