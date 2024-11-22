<?php
require('ToRtf.php');
$f = new ToRtf();
$f->fichero = 'PlantillaQuimicoAcero.rtf';
$f->fsalida = '10289-01-Qu01.rtf';
$f->dirsalida = 'tablaEnsayosRtf/';
$f->retorno = 'fichero';
$f->prefijo = 'Qu_';
$f->valores = array(
	'#*ITEM*#' 		=> '10289-01-Q01',
	'#*C*#' 		=> '0.5',
	);

$campos = array(
	'#*ITEM*#' 		=> '10289-01-Q01',
	'#*C*#' 		=> '0.5',
	);
	
	$txtplantilla = leerArchivo('PlantillaQuimicoAcero.rtf');
	$punt = fopen("tablaEnsayosRtf/Quimico.rtf","w");//-- CREAMOS EL NUEVO FICHERO
	
	if(is_array($campos) and count($campos)>0){				
		foreach($campos as $k=>$v){//-- REEMPLAZAMOS LAS VARIABLES					
			$v = utf8_decode($v);
			//echo $k.' '.$v.'<br>';
			$txtplantilla = str_replace($k,$v,$txtplantilla);
		}
	}
	fputs($punt,$txtplantilla);//-- AGREGAMOS EL CONTENIDO AL NUEVO FICHERO
	fclose($punt);//- CERRAMOS LA CONEXION DEL FICHERO
	
	
	function leerArchivo($fichero)
	{//-- CARGAMOS EL FICHERO EN UNA VARIABLE
		if(is_file($fichero)){
			$texto = file($fichero);
			$ntexto = sizeof($texto);
			$todo ='';
			for($n=0;$n<$ntexto;$n++)
			{
				$todo = $todo.$texto[$n];
			}
			return $todo;
		}else{
			$this->error = 'Archivo de Origen no existe';
			return false;
		}
	}
	
	
	


	
//$f->rtf();
?>