<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$Estado     = 'C';

    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="Estado                = '".$Estado.                       "', ";
    $actSQL.="Observacion           = '".$dato->Observacion.            "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 

$link->close();
?>