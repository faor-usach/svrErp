<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'"; 
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
    $Estado = 'E';
    $fechaInicio = '0000-00-00';
    $RAM    = 0;

    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="fechaInicio           = '".$fechaInicio.                  "', ";
    $actSQL.="Estado                = '".$Estado.                       "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 
}

$link->close();
?>