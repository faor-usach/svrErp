<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../../conexionli.php"); 

$outp = '';
$link=Conectarse();
$bd=$link->query("SELECT * FROM cotizaciones Where CAM = '$dato->OFE'");
if($rs=mysqli_fetch_array($bd)){
    $Cliente            = '';
    $Direccion          = '';
    $Contacto           = '';
    $Email              = '';
    $nContacto          = 0;
    $CAM                = 0;
    $RAM                = 0;
    $Rev                = 0;
    $tituloOferta       = '';
    $usrElaborado 		= '';
    $fechaElaboracion   = '';
    $fechaAprobacion    = '';
    $objetivoGeneral    = '';

    $nContacto      = $rs['nContacto'];

    $bdCli = $link->query("SELECT * FROM Clientes Where RutCli = '".$rs['RutCli']."'");
	if($rowCli=mysqli_fetch_array($bdCli)){
		$Cliente 	= $rowCli['Cliente'];
		$CLIENTE 	= $rowCli['Cliente'];
		$Direccion 	= $rowCli['Direccion'];
	}	

	$bdCon = $link->query("SELECT * FROM contactoscli Where RutCli = '".$rs['RutCli']."' and nContacto = '".$nContacto."'");
	if($rowCon=mysqli_fetch_array($bdCon)){
		$Contacto 	= $rowCon['Contacto'];
		$Email 		= $rowCon['Email'];
	}	
	$bdPro = $link->query("SELECT * FROM propuestaeconomica Where OFE = '$dato->OFE'");
	if($rowPro=mysqli_fetch_array($bdPro)){
        $tituloOferta 		= $rowPro['tituloOferta'];
        $usrElaborado 		= $rowPro['usrElaborado'];
        $fechaElaboracion   = $rowPro['fechaElaboracion'];
        $fechaAprobacion    = $rowPro['fechaAprobacion'];
        $objetivoGeneral    = $rowPro['objetivoGeneral'];
    }

  	if ($outp != "") {$outp .= ",";}
  	$outp .= '{"OFE":"'  		        . $dato->OFE 		        . '",'; 
  	$outp .= '"RutCli":"'  		        . $rs["RutCli"] 	        . '",';
  	$outp .= '"CAM":"'  		        . $rs["CAM"] 	            . '",';
  	$outp .= '"RAM":"'  		        . $rs["RAM"] 	            . '",';
  	$outp .= '"NetoUF":"'  		        . $rs["NetoUF"] 	        . '",';
  	$outp .= '"Validez":"'  		    . $rs["Validez"] 	        . '",';
  	$outp .= '"dHabiles":"'  		    . $rs["dHabiles"] 	        . '",';
  	$outp .= '"tituloOferta":"'  		. $tituloOferta 	        . '",';
  	$outp .= '"usrElaborado":"'  		. $usrElaborado 	        . '",';
  	$outp .= '"fechaElaboracion":"'     . $fechaElaboracion 	    . '",';
  	$outp .= '"fechaAprobacion":"'      . $fechaAprobacion 	        . '",';
  	$outp .= '"objetivoGeneral":"'      . $objetivoGeneral 	        . '",';
  	$outp .= '"Cliente":"'  		    . $Cliente 	                . '",';
  	$outp .= '"Direccion":"'  		    . $Direccion 	            . '",';
  	$outp .= '"Contacto":"'  		    . $Contacto 	            . '",';
  	$outp .= '"nContacto":"'  		    . $nContacto 	            . '",';
  	$outp .= '"Email":"'  		        . $Email 	                . '",';
  	$outp .= '"tpEnsayo":"'	    	    . $rs["tpEnsayo"]  		    . '"}';
}
//$outp ='{"records":['.$outp.']}';

$json_string = $outp;
$file = 'json/'.$dato->OFE.'.json';
file_put_contents($file, $json_string);


$link->close();

 //header("Location: http://servidordata/erp/procesosangular/ofe/exportarPlantilla.php?CAM=15315&version=New");					

?>