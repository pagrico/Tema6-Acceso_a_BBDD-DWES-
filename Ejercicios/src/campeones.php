<?php
include "conexion.php";

// Capturar los parámetros de orden
$ordenColumna = isset($_GET['columna']) ? $_GET['columna'] : 'id';
$ordenDireccion = isset($_GET['direccion']) && $_GET['direccion'] === 'desc' ? 'DESC' : 'ASC';

// Validar columna y dirección
$columnasPermitidas = ['id', 'nombre', 'rol', 'dificultad', 'descripcion'];
if (!in_array($ordenColumna, $columnasPermitidas)) {
    $ordenColumna = 'id';
}

try {
    // Consulta con orden dinámico
    $sql = "SELECT * FROM `campeon` ORDER BY $ordenColumna $ordenDireccion";
    $resultado = $conexion->query($sql);

    // Inicio del HTML
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Campeones</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100 p-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-center">Lista de Campeones</h1>
            <table class="table-auto w-full border-collapse border border-gray-300 bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">';

    // Cabeceras con iconos para ordenar
    $iconos = [
        'asc' => '<i class="fas fa-caret-up"></i>',
        'desc' => '<i class="fas fa-caret-down"></i>'
    ];

    foreach ($columnasPermitidas as $columna) {
        $direccionInvertida = $ordenDireccion === 'ASC' ? 'desc' : 'asc';
        $iconoActual = ($ordenColumna === $columna && $ordenDireccion === 'ASC') ? $iconos['asc'] : ($ordenColumna === $columna ? $iconos['desc'] : '');
        echo '<th class="border border-gray-300  py-2">
                <a href="?columna=' . $columna . '&direccion=asc" class="text-blue-500 hover:underline">' . ucfirst($columna) . '</a> ' .
            '<a href="?columna=' . $columna . '&direccion=asc">' . $iconos['asc'] . '</a>
                <a href="?columna=' . $columna . '&direccion=desc">' . $iconos['desc'] . '</a>
              </th>';
    }

    echo '<th class="border border-gray-300 px-4 py-2">Acciones</th>
          </tr>
      </thead>
      <tbody>';

    // Generar las filas de la tabla
    while ($fila = $resultado->fetch()) {
        echo '<tr class="text-center hover:bg-gray-100">
                <td class="border border-gray-300 px-4 py-2">' . htmlspecialchars($fila[0]) . '</td>
                <td class="border border-gray-300 px-4 py-2">' . htmlspecialchars($fila[1]) . '</td>
                <td class="border border-gray-300 px-4 py-2">' . htmlspecialchars($fila[2]) . '</td>
                <td class="border border-gray-300 px-4 py-2">' . htmlspecialchars($fila[3]) . '</td>
                <td class="border border-gray-300 px-4 py-2">' . htmlspecialchars($fila[4]) . '</td>
                <td class="border border-gray-300 px-4 py-2">
                    <form action="editar.php" method="GET" class="inline">
                        <input type="hidden" name="id" value="' . htmlspecialchars($fila[0]) . '">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-1 px-3 rounded hover:bg-blue-600">Editar</button>
                    </form>
                    <form action="eliminar.php" method="GET" class="inline">
                        <input type="hidden" name="id" value="' . htmlspecialchars($fila[0]) . '">
                        <button type="submit" class="bg-red-500 text-white font-bold py-1 px-3 rounded hover:bg-red-600 ml-2">Eliminar</button>
                    </form>
                </td>
              </tr>';
    }

    // Cerrar la tabla y el HTML
    echo '        </tbody>
            </table>
        </div>
    </body>
    </html>';
} catch (PDOException $e) {
    // Manejo de errores
    echo "Error al ejecutar la consulta: " . $e->getMessage();
    error_log("Error al ejecutar la consulta: " . $e->getMessage(), 3, __DIR__ . "/error.log"); // Registrar en log
}
?>