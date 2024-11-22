<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
include_once("../conexionli.php");


if($dato->accion = 'loadSolicitud'){
    $res        = '';
    $fichero    = '';
    $solicitud  = 'Nada';
    $agnoActual = date('Y');
    $carpetaSolicitud = 'Y://AAA/LE/FINANZAS/'.$agnoActual.'/GASTOS/tmp/REM-'.$dato->nInforme.'.pdf';
    if(file_exists($carpetaSolicitud)){
        $solicitud = 'REM-'.$dato->nInforme.'.pdf';
    }

    $link=Conectarse();
    $SQL = "Select * From formularios Where nInforme = '$dato->nInforme'";
    $bd=$link->query($SQL);
    if($rs = mysqli_fetch_array($bd)){

        $res .= '{"nInforme":"'         . 	$rs["nInforme"]. 		'",';
        $res .= '"Modulo":"'            .   $rs["Modulo"] .         '",';
        $res .= '"Formulario":"'        . 	$rs["Formulario"].      '",';
        $res .= '"solicitud":"'         . 	$solicitud.             '",';
        $res .= '"Concepto":"'          . 	$rs["Concepto"]. 		'"}';
    }
    $link->close();
    echo $res;
}
?>