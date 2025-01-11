<?php
include "conexion.php";

$ID = $_GET["id"];
try {
    

    $sql = "DELETE FROM campeon WHERE `campeon`.`ID` = $ID";
    $conexion->query($sql);

    header("Location: campeones.php");
} catch (\Throwable $th) {
  

}