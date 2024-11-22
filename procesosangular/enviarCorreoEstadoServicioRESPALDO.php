<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
date_default_timezone_set("America/Santiago");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");
$res = '';
$link=Conectarse();
$SQL = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM' and Estado = 'P'";  
$bd=$link->query($SQL);
if($row=mysqli_fetch_array($bd)){ 
   $bdCl=$link->query("Select * From clientes Where RutCli = '".$row['RutCli']."'");
   if($rowCl=mysqli_fetch_array($bdCl)){
        $mail_destinatario = $rowCl['Email'];
        $Cliente = $rowCl['Cliente'];

        $bdCc=$link->query("Select * From contactoscli Where RutCli = '".$row['RutCli']."' and nContacto = '".$row['nContacto']."'");
        if($rowCc=mysqli_fetch_array($bdCc)){
            $mail_destinatario = $rowCc['Email'];
        }

        $res.= '{"CAM":"'.			    $dato->CAM.				    '",';
        $res.= '"RAM":"'.               $dato->RAM. 				'"}';
        


    }
    $CAM        = $dato->CAM;
    $RAM        = $dato->RAM;
    $fInicio    = $row['fechaInicio'];
    $horaPAM    = date('H:i');
    $fd = explode('-', $row['fechaInicio']);
    $dSem = array('Dom.','Lun.','Mar.','Mié.','Jue.','Vie.','Sáb.');
    $ft = $row['fechaInicio'];
    if($horaPAM >= '12:00'){
        $dh = $row['dHabiles']+1;
    }else{
        $dh = $row['dHabiles'];
    }
    $dHabiles = $dh;
    $fechaHoy   = date('Y-m-d');
            
    $dd = 0;
    for($i=1; $i<=$dh; $i++){
        $ft = strtotime ( '+'.$i.' day' , strtotime ( $fechaHoy ) );
        $ft = date ( 'Y-m-d' , $ft );
        $dia_semana = date("w",strtotime($ft));
        if($dia_semana == 0 or $dia_semana == 6){
            $dh++;
            $dd++;
        }
    }
    $fe = explode('-', $ft);

    $bdCorreo=$link->query("Select * From usuarios Where usr = '".$row['usrCotizador']."'");
    if($rowCorreo=mysqli_fetch_array($bdCorreo)){
        $emailCotizador = $rowCorreo['email'];
    }
    $Descripcion = utf8_decode($row['Descripcion']);

        $mail_destinatario  = 'francisco.olivares.rodriguez@gmail.com';
        $emailCotizador     = "francisco.olivares@liceotecnologico.cl";

    //$loc = "Location: https://simet.cl/erp/cotizaciones/enviarCorreo2.php?mail_destinatario=$mail_destinatario&Cliente=$Cliente&RAM=$RAM&CAM=$CAM&fInicio=$fInicio&horaPAM=$horaPAM&fTermino=$ft&emailCotizador=$emailCotizador&Descripcion=$Descripcion";
    $loc = "https://simet.cl/erp/cotizaciones/enviar.php";
    //header("Location: https://simet.cl/erp/cotizaciones/enviar.php");
    
}
    

    // Fin correo

$link->close();
echo $res;	
?>