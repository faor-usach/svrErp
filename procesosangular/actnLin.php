<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
    $actSQL="UPDATE dcotizacion SET ";
    $actSQL.="nLin                  = '".$dato->Lin."', ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "' and nLin = '$dato->nLin'";
    $bdAct=$link->query($actSQL); 
$link->close();
?>