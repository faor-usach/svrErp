<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));
$res = '';
$CAM = 1000;
$res.= '{"RutCli":"'.			$dato->RutCli.			'",';
$res.= '"CAM":"'. 				$CAM. 					'"}';

echo $res;	
?>