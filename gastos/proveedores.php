<?php
	session_start(); 
	include_once("../conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	$link=Conectarse();
	$sql = "SELECT * FROM Ingresos";  // sentencia sql
	$result = $link->query($sql);
	$numero = $result->num_rows; // obtenemos el número de filas
	$link->close();

	if($numero==0){
		header("Location: ingresocaja.php?Proceso=1");
	}

	$nRegistros = 100;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 100;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		if($_GET['inicio']==0){
			$inicio = 0;
			$limite = 100;
		}else{
			$inicio = ($_GET['inicio']-$nRegistros)+1;
			$limite = $inicio+$nRegistros;
		}
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/tpv.css" rel="stylesheet" type="text/css">

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
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
			<?php 
				$nomModulo = 'Principal';
				include('menuIconos.php'); 
			?>
				<div id="ImagenBarra">
					<a href="mproveedores.php?Proceso=1" title="Registrar Proveedor">
						<img src="imagenes/add_32.png" width="28" height="28">
					</a>
				</div>
				
			</div>

			<?php 	include('barraOpciones.php'); ?>

			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width="10%"><strong>RUT 			</strong></td>';
				echo '			<td  width="20%"><strong>Proveedor	</strong></td>';
				echo '			<td  width="20%"><strong>Contacto		</strong></td>';
				echo '			<td  width="10%"><strong>Tp.Cta			</strong></td>';
				echo '			<td  width="10%"><strong>NÂ° Cta			</strong></td>';
				echo '			<td  width="20%"><strong>Banco			</strong></td>';
				echo '			<td colspan="2"  width="10%"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$link=Conectarse();
				$bdProv=$link->query("SELECT * FROM Proveedores Order By Proveedor");
				if ($row=mysqli_fetch_array($bdProv)){
					DO{
						$n++;
						echo '		<tr>';
						echo '			<td width="10%">'.$row['RutProv'].'		</td>';
						echo '			<td width="20%">'.$row['Proveedor'].'	</td>';
						echo '			<td width="20%">'.$row['Contacto'].'	</td>';
						echo '			<td width="10%">'.$row['TpCta'].'		</td>';
						echo '			<td width="10%">'.$row['NumCta'].'		</td>';
						echo '			<td width="20%">'.$row['Banco'].'		</td>';
    					echo '			<td><a href="mproveedores.php?Proceso=2&RutProv='.$row['RutProv'].'"><img src="imagenes/corel_draw_128.png"   width="22" height="22" title="Editar Ficha"></a></td>';
    					echo '			<td><a href="mproveedores.php?Proceso=3&RutProv='.$row['RutProv'].'"><img src="imagenes/delete_32.png" 		 width="22" height="22" title="Eliminar"	></a></td>';
						echo '		</tr>';
					}WHILE ($row=mysqli_fetch_array($bdProv));
				}
				$link->close();
				echo '	</table>';
				echo '</div>';
			?>


		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
<!--
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>
-->
</body>
</html>
