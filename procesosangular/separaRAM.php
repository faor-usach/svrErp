<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'"; 
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
    $fechaInicio            = $row['fechaInicio'];
    $fechaHoy = date('Y-m-d');

    if($dato->RAM > 0){
        $SQLrm = "SELECT * FROM registromuestras Where RAM = '$dato->RAM'"; 
        $bdrm=$link->query($SQLrm);
        if($rowrm=mysqli_fetch_array($bdrm)){
            $situacionMuestra   = 'R';
            $CAM                = 0;

            $actSQLrm="UPDATE registromuestras SET ";
            $actSQLrm.="CAM                   = '".$CAM.                          "', ";
            $actSQLrm.="situacionMuestra      = '".$situacionMuestra.             "' ";
            $actSQLrm.="WHERE RAM             = '".$dato->RAM. "'";
            $bdActrm=$link->query($actSQLrm); 

        }
    }
    $Estado = 'E';
    $RAM    = 0;

    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="RAM                   = '".$RAM.                          "', ";
    $actSQL.="Estado                = '".$Estado.                       "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 
}

$link->close();
?>