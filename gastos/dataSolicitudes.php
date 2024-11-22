<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");


if($dato->accion == 'lecturaSolicitudes'){
    $outp = "";
    $link=Conectarse();
    $fechaHoy = date('Y-m-d');
    $fd = explode('-', $fechaHoy);
    $SQL = "SELECT * FROM formularios where Modulo = 'G' and year(Fecha) = '".$fd[0]."' and month(Fecha) = '".$fd[1]."' Order By nInforme Desc";
    // echo $SQL;
    $bd=$link->query($SQL);
    while($rs=mysqli_fetch_array($bd)){
        if ($outp != "") {$outp .= ",";}
		$outp .= '{"nInforme":"'  . 		$rs["nInforme"]. 			'",';
        $outp .= '"Formulario":"'. 			$rs["Formulario"]. 			'",';
        $outp .= '"Impuesto":"'. 			$rs["Impuesto"]. 	        '",';
        $outp .= '"Fecha":"'. 			    $rs["Fecha"]. 			    '",';
        $outp .= '"Neto":"'. 			    $rs["Neto"]. 			    '",';
        $outp .= '"Iva":"'. 			    $rs["Iva"]. 			    '",';
        $outp .= '"Bruto":"'. 			    $rs["Bruto"]. 			    '",';
        $outp.= '"Concepto":' 			    .json_encode($rs["Concepto"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
	    $outp .= '"IdProyecto":"'. 			$rs["IdProyecto"]. 			'"}';    
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();
    echo ($outp);
}



?>