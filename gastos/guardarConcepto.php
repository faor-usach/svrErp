<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();

$SQL = "SELECT * FROM formularios Where nInforme = '$dato->nInforme'";
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){ 
    $actSQL="UPDATE formularios SET ";
    $actSQL.="nInforme              = '".$dato->nInforme.   "', ";
    $actSQL.="Concepto              = '".$dato->Concepto.   "' ";
    $actSQL.="WHERE nInforme        = '".$dato->nInforme.   "'";
    $bdAct=$link->query($actSQL); 
}

$link->close();
?>