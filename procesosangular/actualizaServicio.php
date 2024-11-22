<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php");

if($dato->accion == "actServicio"){
    $link=Conectarse(); 
    $SQL = "SELECT * FROM servicios Where nServicio = '$dato->nServicio'";
    $bd=$link->query($SQL);
    if($row=mysqli_fetch_array($bd)){ 
        $actSQL="UPDATE servicios SET ";
        $actSQL.="Servicio              = '".$dato->Servicio.           "', ";
        $actSQL.="ValorUF               = '".$dato->ValorUF.            "', ";
        $actSQL.="ValorPesos            = '".$dato->ValorPesos.         "', ";
        $actSQL.="ValorUS               = '".$dato->ValorUS.            "', ";
        $actSQL.="tpServicio            = '".$dato->tpServicio.         "', ";
        $actSQL.="Estado                = '".$dato->Estado.             "' ";
        $actSQL.="WHERE nServicio       = '".$dato->nServicio.          "'";
        $bdAct=$link->query($actSQL); 
    }
    $link->close();
}

if($dato->accion == "deleteServicio"){
    $link=Conectarse();
    $bd=$link->query("SELECT * FROM servicios WHERE nServicio = '$dato->nServicio'");
    if($rs=mysqli_fetch_array($bd)){
        $bd=$link->query("DELETE FROM servicios WHERE nServicio = '$dato->nServicio'");
    }
    $link->close();
}
if($dato->accion == "editServicio"){
	$res = '';
	$link=Conectarse();
	$SQL = "Select * From servicios Where nServicio = '$dato->nServicio'";
	$bd=$link->query($SQL);
	if($rs = mysqli_fetch_array($bd)){
		$res .= '{"nServicio":"'.		    $rs["nServicio"].				'",';
        $res .= '"Servicio":' 			    .json_encode($rs["Servicio"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) 	.',';
		$res .= '"ValorUF":"'. 				$rs["ValorUF"]. 				'",';
		$res .= '"ValorPesos":"'. 			$rs["ValorPesos"]. 				'",';
		$res .= '"ValorUS":"'. 			    $rs["ValorUS"]. 				'",';
		$res .= '"tpServicio":"'. 			$rs["tpServicio"]. 				'",';
		$res .= '"Estado":"'. 			    $rs["Estado"]. 			        '"}';
	}
	$link->close();
	echo $res;	

}
if($dato->accion == "agregaServicio"){
    $nServicio = 0;
    $link=Conectarse(); 
    $SQL = "SELECT * FROM servicios Order By nServicio Desc";
    $bd=$link->query($SQL);
    if($row=mysqli_fetch_array($bd)){
        $nServicio = $row['nServicio'];
        $nServicio++;
    }
    $link->query("insert into servicios(
            nServicio           ,
            Servicio            ,
            ValorUF             ,
            ValorUS             ,
            ValorPesos          ,
            tpServicio          ,
            Estado
            ) 
    values 	(	
            '$nServicio'        ,
            '$dato->Servicio'   ,
            '$dato->ValorUF'    ,
            '$dato->ValorUS'    ,
            '$dato->ValorPesos' ,
            '$dato->tpServicio' ,
            '$dato->Estado'
    )");
    
    $link->close();
}
?>