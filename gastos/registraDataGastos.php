<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");


if($dato->accion == 'lecturaTablaGastos'){
    $outp = "";




    $IdRecurso = 0;
    $link=Conectarse();
    $filtroSQL = 'Where Estado != "I" ';
    if($dato->Formulario != ''){
        $ff = explode('(',$dato->Formulario);
        $Recurso = substr($ff[1],0,strlen($ff[1])-1);
        $bdRec=$link->query("SELECT * FROM recursos Where Formulario = '".$ff[0]."' and Recurso = '".$Recurso."'");
        if($rowRec=mysqli_fetch_array($bdRec)){
            $IdRecurso = $rowRec['IdRecurso'];
            $filtroSQL .= " and IdRecurso = '".$IdRecurso."'";
        }
    }
    
    
    if($dato->IdProyecto != ''){
        $filtroSQL .= " and IdProyecto = '".$dato->IdProyecto."'";
    }

    if($dato->cIva != ''){
        if($dato->cIva=="cIva"){ 
            $filtroSQL .= " and Iva > 0 and Neto > 0";
        }else{
            //$filtroSQL .= " and Iva = 0 and Neto = 0";
            $filtroSQL .= " and Iva = 0";
        }
    }
    $SQL = "SELECT * FROM movgastos ".$filtroSQL." Order By FechaGasto";

    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        $Recurso = '';
        $bdRec=$link->query("SELECT * FROM recursos Where IdRecurso = '".$rs['IdRecurso']."'");
        if($rowRec=mysqli_fetch_array($bdRec)){
            $Recurso = $rowRec['Formulario'].'('.$rowRec['Recurso'].')';
        }
        $Items = '';
        $bdIt = $link->query("SELECT * FROM ItemsGastos Where nItem = '".$rs['nItem']."'");
        if ($rowIt=mysqli_fetch_array($bdIt)){
            $Items = $rowIt['Items'];
        }
        if($rs["Iva"] > 0){
            $cIva = 'cIva';
        }
        if($rs["Iva"] == 0){
            $cIva = 'sIva';
        }

        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nGasto":"'  . 		    $rs["nGasto"]. 				'",';
        $outp .= '"Modulo":"'. 				$rs["Modulo"]. 				'",';
        $outp .= '"FechaGasto":"'. 			$rs["FechaGasto"]. 			'",';
        $outp .= '"TpDoc":"'. 			    $rs["TpDoc"]. 			    '",';
        $outp .= '"nDoc":"'. 			    $rs["nDoc"]. 			    '",';
        $outp .= '"Neto":"'. 			    $rs["Neto"]. 			    '",';
        $outp .= '"Iva":"'. 			    $rs["Iva"]. 			    '",';
        $outp .= '"cIva":"'. 			    $cIva. 			            '",';
        $outp .= '"Bruto":"'. 			    $rs["Bruto"]. 			    '",';
        $outp .= '"nItem":"'. 			    $rs["nItem"]. 			    '",';
        $outp .= '"IdGasto":"'. 			$rs["IdGasto"]. 			'",';
        $outp .= '"IdRecurso":"'. 			$rs["IdRecurso"]. 			'",';
        $outp .= '"Recurso":"'. 			$Recurso. 			        '",';
        $outp .= '"Items":"'. 			    $Items. 			        '",';
        $outp.= '"Bien_Servicio":' 			.json_encode($rs["Bien_Servicio"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
        $outp.= '"Proveedor":' 			    .json_encode($rs["Proveedor"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $outp .= '"IdProyecto":"'. 			$rs["IdProyecto"]. 			'"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}

if($dato->accion == 'solicitudGastos'){
    $res = '';
    
    $link=Conectarse();
    $SQL = "SELECT * FROM formularios Order By nInforme Desc"; 
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $nInf = $rs['nInforme'] + 1;

        $res.= '{"nInforme":"'.			$nInf.				        '",';
        $res.= '"Modulo":"'.	        $rs['Modulo'].		        '",';
        $res.= '"IdProyecto":"'. 		$rs['IdProyecto']. 		    '"}';
    }

    $link->close();
    echo $res;
    

}


?>