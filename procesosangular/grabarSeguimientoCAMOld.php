<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'"; 
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
    $Estado                 = 'E';
    $oCompra                = '';
    $oMail                  = '';
    $oCtaCte                = '';
    $fechaInicio            = $row['fechaInicio'];
    $proxRecordatorio       = $row['proxRecordatorio'];
    $dHabiles               = $row['dHabiles'];

    $fechaHoy = date('Y-m-d');

    if($dato->contactoRecordatorio){
        $proxRecordatorio   = strtotime ( '+10 day' , strtotime ( $fechaHoy ) );
        $proxRecordatorio   = date ( 'Y-m-d' , $proxRecordatorio );
    }


    if($dato->oCompra == 1){ $oCompra = 'on';    }
    if($dato->oMail   == 1){ $oMail   = 'on';    }
    if($dato->oCtaCte == 1){ $oCtaCte = 'on';    }
    if($dato->RAM > 0){
        if($oCompra == 'on' or $oCorreo == 'on' or $oCtaCte == 'on'){
            $Estado = 'E';
            $fechaInicio = date('Y-m-d');
        }
    }

    if($dato->contactoRecordatorio){
        $link->query("insert into CotizacionesSegimiento    (
                                                CAM,
                                                fechaContacto,
                                                contactoRecordatorio,
                                                proxRecordatorio
                                            )    
                                  values    (   '$CAM',
                                                '$fechaHoy',
                                                '$contactoRecordatorio',
                                                '$proxRecordatorio'
                                            )");
    }


    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="RAM                   = '".$RAM.                          "', ";
    $actSQL.="oCompra               = '".$oCompra.                      "', ";
    $actSQL.="oMail                 = '".$oMail.                        "', ";
    $actSQL.="oCtaCte               = '".$oCtaCte.                      "', ";
    $actSQL.="nOC                   = '".$dato->nOC.                    "', ";
    $actSQL.="fechaAceptacion       = '".$dato->fechaAceptacion.        "', ";
    $actSQL.="fechaInicio           = '".$fechaInicio.                  "', ";
    $actSQL.="Estado                = '".$Estado.                       "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 
/*
    $actSQL.="Fan                   = '".$Fan.                          "', ";
    $actSQL.="proxRecordatorio      = '".$proxRecordatorio.             "', ";
    $actSQL.="correoInicioPAM       = '".$correoInicioPAM.              "', ";
    $actSQL.="fechaEstimadaTermino  = '".$data->fechaEstimadaTermino.   "', ";
    $actSQL.="usrCotizador          = '".$data->usrCotizador.           "', ";
    $actSQL.="usrResponzable        = '".$data->usrResponzable.         "', ";
    $actSQL.="contactoRecordatorio  = '".$data->contactoRecordatorio.   "', ";
    $actSQL.="Descripcion           = '".$data->Descripcion.            "', ";
*/

}

$link->close();
?>