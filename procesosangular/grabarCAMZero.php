<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'"; 
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
    $Zero = 0;
    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="NetoUF        = '".$Zero.         "', ";
    $actSQL.="IvaUF         = '".$Zero.         "', ";
    $actSQL.="BrutoUF       = '".$Zero.         "', ";
    $actSQL.="Neto          = '".$Zero.         "', ";
    $actSQL.="Iva           = '".$Zero.         "', ";
    $actSQL.="Bruto         = '".$Zero.         "', ";
    $actSQL.="NetoUS        = '".$Zero.         "', ";
    $actSQL.="IvaUS         = '".$Zero.         "', ";
    $actSQL.="BrutoUS       = '".$Zero.         "' ";
    $actSQL.="WHERE CAM     = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 

    $actSQL="UPDATE dcotizacion SET ";
    $actSQL.="unitarioUF    = '".$Zero.         "', ";
    $actSQL.="unitarioUS    = '".$Zero.         "', ";
    $actSQL.="unitarioP     = '".$Zero.         "', ";
    $actSQL.="NetoUF        = '".$Zero.         "', ";
    $actSQL.="IvaUF         = '".$Zero.         "', ";
    $actSQL.="TotalUF       = '".$Zero.         "', ";
    $actSQL.="Neto          = '".$Zero.         "', ";
    $actSQL.="Iva           = '".$Zero.         "', ";
    $actSQL.="Bruto         = '".$Zero.         "', ";
    $actSQL.="NetoUS        = '".$Zero.         "', ";
    $actSQL.="IvaUS         = '".$Zero.         "', ";
    $actSQL.="TotalUS       = '".$Zero.         "' ";
    $actSQL.="WHERE CAM     = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 

}

$link->close();
?>