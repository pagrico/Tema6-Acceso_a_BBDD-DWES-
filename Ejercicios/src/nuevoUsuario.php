<?php
include "conexion.php";

$cliente = new stdClass();
$cliente->nombre = $_GET["nombre"];
$cliente->usuario = $_GET["usuario"];
$cliente->email = $_GET["email"];
$cliente->password = password_hash($_GET["password"], PASSWORD_BCRYPT);

$sql = "INSERT INTO `usuario` (`nombre`, `usuario`, `password`, `email`) 
        VALUES ('$cliente->nombre', '$cliente->usuario', '$cliente->password', '$cliente->email')";

// Registro y redirección
if ($conexion->query($sql)) {
    // Si el registro es exitoso, redirige
    header("Location: registro.php?mensaje=exito");
    exit; // Importante para detener la ejecución después de redirigir
} else {
    // Si hay un error, redirige con mensaje de error
    $error = urlencode($conexion->error);
    header("Location: registro.php?mensaje=error&detalle=$error");
    exit;
}
?>