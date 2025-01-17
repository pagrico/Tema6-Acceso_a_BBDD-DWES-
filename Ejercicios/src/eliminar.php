<?php
include "conexion.php";


try {


    $sql = "DELETE FROM campeon WHERE `campeon`.`ID` = '$_POST[id]'";
    $conexion->query($sql);

    header("Location: campeones.php");
} catch (\Throwable $th) {


}