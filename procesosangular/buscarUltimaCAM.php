<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$res = '';
$link=Conectarse();
$CAM = $dato->CAM;
if($CAM == 0){
	$SQL = "SELECT * FROM cotizaciones Order By CAM Desc";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$CAM = $rs["CAM"] + 1;
        $actSQLrm="UPDATE tablaregform SET ";
        $actSQLrm.="CAM  = '".$CAM."' ";
        $bdActrm=$link->query($actSQLrm); 

	}
}
$Estado = 'E';

$Descripcion    = '';
$obsServicios   = '';
$Observacion    = '';
if($dato->Descripcion){
    $Descripcion = $dato->Descripcion;
}
if($dato->obsServicios){
    $obsServicios = $dato->obsServicios;
}
if($dato->Observacion){
    $Observacion = $dato->Observacion;
}


$SQL = "SELECT * FROM cotizaciones Where CAM = '$CAM'";
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){
    if($rs['Estado']){
        $Estado = $rs['Estado'];
    }
    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="usrCotizador          = '".$dato->usrCotizador.           "', ";
    $actSQL.="fechaCotizacion       = '".$dato->fechaCotizacion.        "', ";
    $actSQL.="usrCotizador          = '".$dato->usrCotizador.           "', ";
    $actSQL.="usrResponzable        = '".$dato->usrCotizador.           "', ";
    $actSQL.="Moneda               	= '".$dato->Moneda.                 "', ";
    $actSQL.="Rev               	= '".$dato->Rev.                    "', ";
    $actSQL.="pDescuento           	= '".$dato->pDescuento.             "', ";
    $actSQL.="fechaUF           	= '".$dato->fechaUF.             	"', ";
    $actSQL.="valorUF           	= '".$dato->valorUF.             	"', ";
    $actSQL.="valorUS           	= '".$dato->valorUS.             	"', ";
    $actSQL.="Validez               = '".$dato->Validez.                "', ";
    $actSQL.="dHabiles              = '".$dato->dHabiles.               "', ";
    $actSQL.="exentoIva            	= '".$dato->exentoIva.              "', ";
    $actSQL.="tpEnsayo              = '".$dato->tpEnsayo.               "', ";
    $actSQL.="OFE  					= '".$dato->OFE.         			"', ";
    $actSQL.="RutCli           		= '".$dato->RutCli.                 "', ";
    $actSQL.="Descripcion     		= '".$Descripcion.        	        "', ";
    $actSQL.="obsServicios     		= '".$obsServicios.             	"', ";
    $actSQL.="Observacion     		= '".$Observacion.              	"', ";
    $actSQL.="nContacto             = '".$dato->nContacto.              "', ";
    $actSQL.="Estado                = '".$Estado.                       "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 
}else{
    $Fan = 0;
    $newCotizacion = 'on';
    $SQLct = "SELECT * FROM controltablas Where newCotizacion != ''";
    $bdct=$link->query($SQLct);
    if($rsct = mysqli_fetch_array($bdct)){
        $actSQL="UPDATE controltablas SET ";
        $actSQL.="newCotizacion         = '".$newCotizacion.   "' ";
        $bdAct=$link->query($actSQL); 
    }else{
        $link->query("insert into controltablas ( newCotizacion ) value ( '$newCotizacion')");
    }

	$link->query("insert into cotizaciones    (
                                                CAM,
                                                Fan,
                                                fechaCotizacion,
                                                usrCotizador,
                                                Moneda,
                                                Validez,
                                                dHabiles,
                                                exentoIva,
                                                tpEnsayo,
                                                OFE,
                                                RutCli,
                                                nContacto,
                                                fechaUF,
                                                valorUF,
                                                valorUS,
                                                pDescuento,
                                                Descripcion,
                                                obsServicios,
                                                Observacion,
                                                Estado
                                            )    
                                  values    (   '$CAM',
                                  				'$Fan',
                                                '$dato->fechaCotizacion',
                                                '$dato->usrCotizador',
                                                '$dato->Moneda',
                                                '$dato->Validez',
                                                '$dato->dHabiles',
                                                '$dato->exentoIva',
                                                '$dato->tpEnsayo',
                                                '$dato->OFE',
                                                '$dato->RutCli',
                                                '$dato->nContacto',
                                                '$dato->fechaUF',
                                                '$dato->valorUF',
                                                '$dato->valorUS',
                                                '$dato->pDescuento',
                                                '$Descripcion',
                                                '$obsServicios',
                                                '$Observacion',
                                                '$Estado'
                                            )");
}


if($dato->OFE == 'on'){
    
    $bdOFE=$link->query("Select * From propuestaeconomica Where OFE = '$CAM'");
    if($rowOFE=mysqli_fetch_array($bdOFE)){
        $actSQL="UPDATE propuestaeconomica SET ";
        $actSQL.="usrElaborado      ='".$dato->usrCotizador.      "',";
        $actSQL.="fechaElaboracion  ='".$dato->fechaCotizacion.   "',";
        $actSQL.="RutCli            ='".$dato->RutCli.           "',";
        $actSQL.="nContacto         ='".$dato->nContacto.         "',";
        $actSQL.="fechaOferta       ='".$dato->fechaCotizacion.   "'";
        $actSQL.="WHERE OFE         = '$CAM'";
        $bdOFE=$link->query($actSQL);
    }else{
        $link->query("insert into propuestaeconomica(
                                                                OFE,
                                                                usrElaborado,
                                                                fechaElaboracion,
                                                                CAM,
                                                                RutCli,
                                                                nContacto,
                                                                fechaOferta
                                                            )    
                                                    values  (   
                                                                '$CAM',
                                                                '$dato->usrCotizador',
                                                                '$dato->fechaCotizacion',
                                                                '$CAM',
                                                                '$dato->RutCli',
                                                                '$dato->nContacto',
                                                                '$dato->fechaCotizacion'
                                                            )");
    }

}


$res = '';

$res.= '{"RutCli":"'.			$dato->RutCli.			'",';
$res.= '"CAM":"'. 				$CAM. 					'"}';

$link->close();
echo $res;	
?>