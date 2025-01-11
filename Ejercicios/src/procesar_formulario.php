<?php
include "conexion.php";
$sql = "UPDATE `campeon` SET `Nombre`='$_POST[nombre]',`Rol`='$_POST[rol]',`Dificultad`='$_POST[dificultad]',`Descripcion`='$_POST[descripcion]' WHERE ID=$_POST[id]";

$conexion->query($sql);

header("Location: campeones.php");
?>