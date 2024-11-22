<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'"; 
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){
    $Estado     = 'E';
    $oCompra    = 'off';
    $oMail      = 'off';
    $oCtaCte    = 'off';
    $contactoRecordatorio = '';
    $Observacion = '';
    if($dato->contactoRecordatorio){ $contactoRecordatorio = $dato->contactoRecordatorio; }
    if($dato->Observacion){ $Observacion = $dato->Observacion; }

    $fechaInicio            = $row['fechaInicio'];
    $proxRecordatorio       = $row['proxRecordatorio'];
    $dHabiles               = $row['dHabiles'];

    $fechaHoy = date('Y-m-d');

    if($contactoRecordatorio){
        $proxRecordatorio   = strtotime ( '+10 day' , strtotime ( $fechaHoy ) );
        $proxRecordatorio   = date ( 'Y-m-d' , $proxRecordatorio );
        $link->query("insert into cotizacionessegimiento    (
                                                CAM,
                                                fechaContacto,
                                                contactoRecordatorio,
                                                RAM,
                                                proxRecordatorio
                                            )    
                                  values    (   '$dato->CAM',
                                                '$fechaHoy',
                                                '$contactoRecordatorio',
                                                '$dato->RAM',
                                                '$proxRecordatorio'
                                            )");
    }

    if($dato->oCompra == 1){ $oCompra = 'on';    }else{ $oCompra = ''; }
    if($dato->oMail   == 1){ $oMail   = 'on';    }else{ $oMail   = ''; }
    if($dato->oCtaCte == 1){ $oCtaCte = 'on';    }else{ $oCtaCte = ''; }

    if($dato->RAM > 0){
        $SQLrm = "SELECT * FROM registromuestras Where RAM = '$dato->RAM'"; 
        $bdrm=$link->query($SQLrm);
        if($rowrm=mysqli_fetch_array($bdrm)){
            $situacionMuestra = 'P';
            $actSQLrm="UPDATE registromuestras SET ";
            $actSQLrm.="CAM                   = '".$dato->CAM.                    "', ";
            $actSQLrm.="situacionMuestra      = '".$situacionMuestra.             "' ";
            $actSQLrm.="WHERE RAM             = '".$dato->RAM. "'";
            $bdActrm=$link->query($actSQLrm); 

        }

        if($oCompra == 'on' or $oMail == 'on' or $oCtaCte == 'on'){
            $Estado = 'P';
            $fechaInicio = date('Y-m-d');
        }
    }

    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="usrCotizador          = '".$dato->usrCotizador.           "', ";
    $actSQL.="usrResponzable        = '".$dato->usrResponzable.         "', ";
    $actSQL.="fechaEstimadaTermino  = '".$dato->fechaEstimadaTermino.   "', ";
    $actSQL.="fechaAceptacion       = '".$dato->fechaAceptacion.        "', ";
    $actSQL.="fechaInicio           = '".$fechaInicio.                  "', ";
    $actSQL.="nOC                   = '".$dato->nOC.                    "', ";
    $actSQL.="oCompra               = '".$oCompra.                      "', ";
    $actSQL.="oMail                 = '".$oMail.                        "', ";
    $actSQL.="oCtaCte               = '".$oCtaCte.                      "', ";
    $actSQL.="tpEnsayo              = '".$dato->tpEnsayo.               "', ";
    $actSQL.="contactoRecordatorio  = '".$contactoRecordatorio.         "', ";
    $actSQL.="Observacion           = '".$Observacion.                  "', ";
    $actSQL.="correoInicioPAM       = '".$dato->correoInicioPAM.        "', ";
    $actSQL.="RAM                   = '".$dato->RAM.                    "', ";
    $actSQL.="Estado                = '".$Estado.                       "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 

}

    if($dato->correoInicioPAM == 'on'){
        
        $mail_destinatario  = 'francisco.olivares.rodriguez@gmail.com';
        $Cliente            = "Francisco Olivares";
        $RAM                = $dato->RAM;
        $CAM                = $dato->CAM;
        $fInicio            = $fechaInicio;
        $horaPAM            = date('H:i');
        $ft                 = date('Y-m-d');
        $emailCotizador     = "francisco.olivares@liceotecnologico.cl";
        $Descripcion        = "Prueba New";


        $loc = "Location: https://simet.cl/erp/cotizaciones/enviarCorreo2.php?mail_destinatario=$mail_destinatario&Cliente=$Cliente&RAM=$RAM&CAM=$CAM&fInicio=$fInicio&horaPAM=$horaPAM&fTermino=$ft&emailCotizador=$emailCotizador&Descripcion=$Descripcion";
        header($loc);
    }
    // Fin correo

$link->close();
?>