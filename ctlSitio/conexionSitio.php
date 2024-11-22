<?php 
	function ConectarseSitio()
		{
			if(!($linkSitio=mysql_connect("localhost","simet_sitio","simet.2014"))){
				echo "Error cenexion.";
				exit();
			}
			if(!mysql_select_db("simet_sitio",$linkSitio)){
				echo "Error seleccionando la Base de Datos.";
				exit();
			}
			return $linkSitio;
		}
		
		
?>