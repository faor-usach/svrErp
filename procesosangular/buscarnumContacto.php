<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php"); 
$res = '';
$link=Conectarse();

$SQL = "SELECT * FROM contactoscli Where RutCli = '$dato->RutCli' and Contacto like '%$dato->Contacto%'";
$bd=$link->query($SQL);
if($rs = mysqli_fetch_array($bd)){

		$res.= '{"nContacto":"'.			$rs["nContacto"].					'",';
	   	$res.= '"Email":"'. 				trim($rs["Email"]). 				'"}';


}
$link->close();
echo $res;	
?>