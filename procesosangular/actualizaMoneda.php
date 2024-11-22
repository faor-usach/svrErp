<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();

$NetoUF     = 0;
$IvaUF      = 0;
$BrutoUF    = 0;
$Neto       = 0;
$Iva        = 0;
$Bruto      = 0;
$NetoUS     = 0;
$IvaUS      = 0;
$BrutoUS    = 0;

$SQLc = "SELECT * FROM dcotizacion Where CAM = '$dato->CAM'";
$bdc=$link->query($SQLc);
while($rs=mysqli_fetch_array($bdc)){
    $NetoUF += $rs['NetoUF'];
    $IvaUF += $rs['IvaUF'];
    $BrutoUF += $rs['TotalUF'];
    $Neto += $rs['Neto'];
    $Iva += $rs['Iva'];
    $Bruto += $rs['Bruto'];
    $NetoUS += $rs['NetoUS'];
    $IvaUS += $rs['IvaUS'];
    $BrutoUS += $rs['TotalUS'];
}
$SQLcz = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'";
$bdcz=$link->query($SQLcz);
if($rsz=mysqli_fetch_array($bdcz)){
    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="Moneda                = '".$dato->Moneda.           "', ";
    $actSQL.="NetoUF                = '".$NetoUF.                 "', ";
    $actSQL.="IvaUF                 = '".$IvaUF.                  "', ";
    $actSQL.="BrutoUF               = '".$BrutoUF.                "', ";
    $actSQL.="Iva                   = '".$Iva.                    "', ";
    $actSQL.="Neto                  = '".$Neto.                   "', ";
    $actSQL.="Bruto                 = '".$Bruto.                  "', ";
    $actSQL.="NetoUS                = '".$NetoUS.                 "', ";
    $actSQL.="IvaUS                 = '".$IvaUS.                  "', ";
    $actSQL.="BrutoUS               = '".$BrutoUS.                "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 
}

$link->close();
?>