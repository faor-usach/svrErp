<?php
	session_start(); 
	include("conexion.php");
	if (!isset($_SESSION['usr'])){
		header("Location: index.php");
	}
	$nRegistros = 18;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 18;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		$inicio = ($_GET['inicio']-$nRegistros)+1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGas	=	mysql_query("SELECT * FROM MovGastos");
		$inicio	=	mysql_num_rows($bdGas) - $nRegistros;
		$limite	=	mysql_num_rows($bdGas);
		mysql_close($link);
	}
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

<link href="estilos.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<?php include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Mantención de Clientes
				<div id="ImagenBarra">
					<a href="mantclie.php?Proceso=1&RutCli=" title="Agregar">
						<img src="imagenes/add_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaintranet.php" title="Inicio">
						<img src="imagenes/room_32.png" width="28" height="28">
					</a>
				</div>
			</div>
			
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td width="15%"><strong>RUT</strong></td>';
				echo '			<td  width="30%"><strong>Listado de Clientes </strong></td>';
				echo '			<td  width="30%"><strong>Contacto</strong></td>';
				echo '			<td  width="15%"><strong>Teléfono</strong></td>';
				echo '			<td colspan="2"  width="10%"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$link=Conectarse();
				$bdCli=mysql_query("SELECT * FROM clientes Order By Cliente Limit $inicio, $nRegistros");
				if ($row=mysql_fetch_array($bdCli)){
					DO{
						echo '		<tr>';
						echo '			<td>'.$row['RutCli'].'</td>';
						echo '			<td>'.$row['Cliente'].'</td>';
						echo '			<td>'.$row['Contacto'].'</td>';
						echo '			<td>'.$row['FonoContacto'].'</td>';
    					echo '			<td><a href="mantclie.php?Proceso=2&RutCli='.$row['RutCli'].'"><img src="../imagenes/editar.gif"   width="20" height="20" title="Editar Ficha"></a></div></td>';
    					echo '			<td><a href="mantclie.php?Proceso=3&RutCli='.$row['RutCli'].'"><img src="../imagenes/Eliminar.png" width="20" height="20" title="Eliminar Personal"      ></a></div></td>';
						echo '		</tr>';
					}WHILE ($row=mysql_fetch_array($bdCli));
				}
				mysql_close($link);
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
				echo '		<tr>';
				echo '			<td align="center">';
				echo '				<a href="lclientes.php">Inicio</a> |';
				echo '				<a href="lclientes.php?inicio='.$inicio.'">Anterior</a> |';
				echo '				<a href="lclientes.php?limite='.$limite.'">Siguiente</a> |';
				echo '				<a href="lclientes.php?ultimo=fin">Final</a>';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '</div>';
			?>
		</div>
	</div>
	<div style="clear:both;"></div>
	<br>
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>

</body>
</html>
