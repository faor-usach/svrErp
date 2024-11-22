<?php 
	function ConectarseBak()
		{
			if (!($linkBak=mysql_connect("c://localhost/","root",""))){
				echo "Error cenexion Respaldo <br>";
				exit();
			}
			if (!mysql_select_db("simet_laboratorio",$linkBak)){
				echo "Error seleccionando la Base de Datos Respaldo <br>";
				exit();
			}
			return $linkBak;
		}
?>