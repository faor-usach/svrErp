<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include_once("../conexionli.php");
$res = '';
$agnoAct 	= date('Y');
$mesAct 	= date('m');
$link=Conectarse();
$SQL = "SELECT * FROM tablaindicadores Where mesInd = '$mesAct' and agnoInd = '$agnoAct'"; 
$bd=$link->query($SQL);
if($rs=mysqli_fetch_array($bd)){
	$res.= '{"indMin":"'.			$rs["indMin"].		'",';
    $res.= '"indMeta":"'.			$rs["indMeta"]. 	'",';
   	$res.= '"rCot":"'. 				$rs["rCot"]. 		'"}';
}
$link->close();
//echo '{"msg":"Busqueda Exitosa","msg2":['.$res.']}';	
echo $res;	

?>
