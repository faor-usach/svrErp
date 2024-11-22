<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
include("../conexioncert.php"); 


if($dato->accion == 'leerCertificadoConformidad'){   
    $linkc=ConectarseCert();
	$outp = "";
	$SQL = "SELECT * FROM certificado Where RutCli = '$dato->RutCli'  Order By CodCertificado";
	$bd=$linkc->query($SQL);
	while($rs=mysqli_fetch_array($bd)){ 
        $agregaCertificado = 'No';
        if($rs['CodInforme'] == ''){
            $agregaCertificado = 'Si';
        }else{
            if($rs['CodInforme'] == $dato->CodInforme){
                $agregaCertificado = 'Si';
            }
        }
        if($agregaCertificado == 'Si'){
            if ($outp != "") {$outp .= ",";}
            $outp .= '{"RutCli":"'  . 			$rs["RutCli"]. 				'",';
            $outp .= '"fechaUpLoad":"'. 		$rs["fechaUpLoad"]. 		'",';
            $outp .= '"CodCertificado":"'. 		$rs["CodCertificado"]. 		'",';
            $outp .= '"CodigoVerificacion":"'. 	$rs["CodigoVerificacion"]. 	'",';
            $outp .= '"Lote":"'. 				$rs["Lote"]. 				'",';
            $outp .= '"nDescargas":"'. 			$rs["nDescargas"]. 			'",';
            $outp .= '"upLoad":"'. 				$rs["upLoad"]. 				'",';
            $outp .= '"Estado":"'. 				$rs["Estado"]. 				'",';
            $outp .= '"pdf":"'. 				$rs["pdf"]. 				'"}';
        }
        
	}
	$linkc->close();
	$outp ='{"records":['.$outp.']}';
	echo ($outp);	
}


if($dato->accion == 'leerMuestras'){
    $link=Conectarse();
	$outp = "";
	$SQL = "SELECT * FROM ammuestras Where CodInforme = '$dato->CodInforme' Order By idItem";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"idItem":"'  . 		        $rs["idItem"]. 				'",';
        $outp .= '"idMuestra":' 			    .json_encode($rs["idMuestra"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$outp .= '"Taller":"'. 				    $rs["Taller"]. 		    '"}';
	}
	$link->close();
	$outp ='{"records":['.$outp.']}';
	echo ($outp);
}

if($dato->accion == 'leerEnsayos'){
    $link=Conectarse();
	$outp = "";
	$SQL = "SELECT * FROM amtpensayo Order By tpEnsayo";
	$bd=$link->query($SQL);
	while($rs=mysqli_fetch_array($bd)){
		if ($outp != "") {$outp .= ",";}
		$outp .= '{"tpEnsayo":"'  . 		$rs["tpEnsayo"]. 				'",';
		$outp .= '"Ensayo":"'. 				$rs["Ensayo"]. 				    '"}';
	}
	$link->close();
	$outp ='{"records":['.$outp.']}';
	echo ($outp);
    
    //$outp .= '"Norma":' 			    	.json_encode($rs["Norma"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	
}

if($dato->accion == 'guardartpEnsayo'){
    $link=Conectarse();
    $actSQL="UPDATE amInformes SET ";
    $actSQL.="tpEnsayo       	= '".$dato->tpEnsayo. 			"' ";
    $actSQL.="WHERE CodInforme 	= '".$dato->CodInforme.         "'";
    $bdAct = $link->query($actSQL);    
    $link->close();
}
if($dato->accion == 'guardarTipoMuestra'){
    $link=Conectarse();
    $actSQL="UPDATE amInformes SET ";
    $actSQL.="tipoMuestra           = '".$dato->tipoMuestra. 			"' ";
    $actSQL.="WHERE CodInforme 	    = '".$dato->CodInforme.             "'";
    $bdAct = $link->query($actSQL);    
    $link->close();
}
if($dato->accion == 'guardaramEnsayo'){
    $link=Conectarse();
    $actSQL="UPDATE amInformes SET ";
    $actSQL.="amEnsayo              = '".$dato->amEnsayo. 			    "' ";
    $actSQL.="WHERE CodInforme 	    = '".$dato->CodInforme.             "'";
    $bdAct = $link->query($actSQL);    
    $link->close();
}
if($dato->accion == 'guardarfechaRecepcion'){ 
    $link=Conectarse();
    $actSQL="UPDATE amInformes SET ";
    $actSQL.="fechaRecepcion        = '".$dato->fechaRecepcion. 	    "' ";
    $actSQL.="WHERE CodInforme 	    = '".$dato->CodInforme.             "'";
    $bdAct = $link->query($actSQL);    
    $link->close();
}
if($dato->accion == 'guardarfechaInforme'){
    $link=Conectarse();
    $actSQL="UPDATE amInformes SET ";
    $actSQL.="fechaInforme          = '".$dato->fechaInforme. 	        "' ";
    $actSQL.="WHERE CodInforme 	    = '".$dato->CodInforme.             "'";
    $bdAct = $link->query($actSQL);    
    $link->close();
}
if($dato->accion == 'guardarnMuestras'){
    $link=Conectarse();
    $actSQL="UPDATE amInformes SET ";
    $actSQL.="nMuestras             = '".$dato->nMuestras. 	            "' ";
    $actSQL.="WHERE CodInforme 	    = '".$dato->CodInforme.             "'";
    $bdAct = $link->query($actSQL);    
    $link->close();
}

if($dato->accion == 'mostrarQR'){
	$linkc=ConectarseCert();
    $SQL = "SELECT * FROM certificado Where CodInforme = '$dato->CodInforme'";
	$bd=$linkc->query($SQL);
	if($rs=mysqli_fetch_array($bd)){
        $CodInforme = '';
        $actSQL="UPDATE certificado SET ";
        $actSQL.="CodInforme       	= '".$CodInforme. 			"' ";
        $actSQL.="WHERE CodInforme 	= '".$dato->CodInforme.         "'";
        $bdAct = $linkc->query($actSQL);    
    }

	$actSQL="UPDATE certificado SET ";
	$actSQL.="CodCertificado        = '".$dato->CodCertificado. 	    "', ";
	$actSQL.="CodInforme       	    = '".$dato->CodInforme. 			"' ";
	$actSQL.="WHERE CodCertificado 	= '".$dato->CodCertificado.         "'";
	$bdAct = $linkc->query($actSQL);
    $linkc->close();
}

if($dato->accion == 'leerData'){
    $res = '';
    $link=Conectarse();
    //$bd=$link->query("SELECT * FROM aminformes Where CodInforme = '$dato->CodInforme'");
    $bd=$link->query("SELECT * FROM aminformes Where CodInforme = '$dato->CodInforme'");
    if($rs=mysqli_fetch_array($bd)){
        
        $nMuestras = $rs['nMuestras'];
        if($rs['nMuestras'] < 10){
            $nMuestras = '0'.$rs['nMuestras'];
        }
        $bdc=$link->query("SELECT * FROM clientes Where RutCli = '".$rs['RutCli']."'");
        if($rsc=mysqli_fetch_array($bdc)){

        }
        $fr = explode('-', $dato->CodInforme);
        $RAM = $fr[1];
        $RAMA = trim($RAM);
        $bdr=$link->query("SELECT * FROM cotizaciones Where RAM = '$RAM'");
        if($rsr=mysqli_fetch_array($bdr)){

        }
        $bdcc=$link->query("SELECT * FROM contactoscli Where RutCli = '".$rs['RutCli']."' and nContacto = '".$rsr['nContacto']."'");
        if($rscc=mysqli_fetch_array($bdcc)){

        }
        // $fechaRecepcion = '0000-00-00';
        
        $fechaRecepcion = date('Y-m-d');
        $bdMuestras=$link->query("SELECT * FROM registromuestras Where RAM = '$RAMA'");
        if($rsm=mysqli_fetch_array($bdMuestras)){
            
            if($rs['fechaRecepcion'] == '0000-00-00'){
                $actSQL="UPDATE aminformes SET ";
                $actSQL.="fechaRecepcion       	= '".$rsm["fechaRegistro"]. 	     "' ";
                $actSQL.="WHERE CodInforme 	    = '".$dato->CodInforme.             "'";
                $bdAct = $link->query($actSQL);        
            }
            
            $fechaRecepcion = $rsm["fechaRegistro"];

        }
        
        $res.= '{"RutCli":"'.				$rs["RutCli"].				'",';
        $res.= '"CodInforme":"'. 			$rs["CodInforme"]. 			'",';
        $res.= '"fechaInforme":"'. 			$rs["fechaInforme"]. 	    '",';
        $res.= '"Cliente":"'. 			    $rsc["Cliente"]. 			'",';
        $res.= '"Direccion":"'. 			$rsc["Direccion"]. 			'",';
        $res.= '"Contacto":"'. 			    $rscc["Contacto"]. 			'",';
        $res.= '"tpEnsayo":"'. 			    $rs["tpEnsayo"]. 			'",';
        
        if($rs["tpEnsayo"] == 5){
            $linkc=ConectarseCert();
            $bdca=$linkc->query("SELECT * FROM certificado Where CodInforme = '$dato->CodInforme'");
            if($rsca=mysqli_fetch_array($bdca)){
                $res.= '"CodCertificado":"'. $rsca["CodCertificado"]. 			'",';
            }
            $linkc->close();
        }
        
        $res.= '"amEnsayo":"'. 			    $rs["amEnsayo"]. 			'",';
        $res.= '"fechaRecepcion":"'. 	    $rsm["fechaRegistro"]. 		'",';
        $res.= '"nMuestras":"'. 			$nMuestras. 			    '",';
        $res.= '"RAMA":"'. 	                $RAMA. 		                '",';
        $res.= '"tipoMuestra":"'. 			$rs["tipoMuestra"]. 		'"}';
        
        
    }
    $link->close();
	echo $res;	

}

?>