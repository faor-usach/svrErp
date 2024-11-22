<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8"); 

$dato = json_decode(file_get_contents("php://input"));
include_once("../conexionli.php");

if($dato->accion == 'revivirCAM'){
    $link=Conectarse();

    $Estado          = 'E';
    $fechaCotizacion = date('Y-m-d');

    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="fechaCotizacion   ='".$fechaCotizacion.	"',";
    $actSQL.="Estado            ='".$Estado.	        "'";
    $actSQL.="WHERE CAM 	    = '$dato->CAM'";
    $bdDu=$link->query($actSQL);

    $link->close();
}


?>