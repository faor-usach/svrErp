<?php
include('conexionlocal.php');

	$link=Conectarse();
	$bdGto=mysql_query("SELECT * FROM MovGastos Order By nGasto");
	if ($rowGto=mysql_fetch_array($bdGto)){
		DO{
			echo 'nGasto: '.$rowGto['nGasto'].'<br>';
		}WHILE ($rowGto=mysql_fetch_array($bdGto));
	}
	$sql 	= "SELECT * FROM Formularios Where Modulo = 'G'";  // sentencia sql
	$result = mysql_query($sql);
	$nInf 	= mysql_num_rows($result); // obtenemos el número de filas
	$nInf 	= $nInf +1;
	$sql 	= "SELECT * FROM formularios Where Modulo = 'G' Order By nInforme";
	if ($rowGto=mysql_fetch_array($sql)){
		$nInf 	= $rowGto['nInforme'];
		echo 'Informe'.$nInf;
	}
	mysql_close($link);
?>
