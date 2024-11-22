<?php
	session_start();
	include("conexion.php");
	if (!isset($_SESSION['usr'])){
		header("Location: http://localhost/simetlocal/intranet/");
	}
	if(isset($_GET['Proceso'])){
		$Proceso 	= $_GET['Proceso'];
		$RutCli		= $_GET['RutCli'];
	}
	if(isset($_POST['Proceso'])){
		$Proceso 	= $_POST['Proceso'];
		$RutCli		= $_POST['RutCli'];
	}
	if(isset($_POST['Grabar'])){
		$Cliente		= $_POST['Cliente'];
		$Giro			= $_POST['Giro'];
		$Direccion		= $_POST['Direccion'];
		$Telefono		= $_POST['Telefono'];
		$Celular		= $_POST['Celular'];
		$Email			= $_POST['Email'];
		$Contacto		= $_POST['Contacto'];
		$FonoContacto	= $_POST['FonoContacto'];
		$EmailContacto	= $_POST['EmailContacto'];
		$Contacto2		= $_POST['Contacto2'];
		$FonoContacto2	= $_POST['FonoContacto2'];
		$EmailContacto2	= $_POST['EmailContacto2'];
		$Contacto2		= $_POST['Contacto3'];
		$FonoContacto2	= $_POST['FonoContacto3'];
		$EmailContacto2	= $_POST['EmailContacto3'];
		$Contacto2		= $_POST['Contacto4'];
		$FonoContacto2	= $_POST['FonoContacto4'];
		$EmailContacto2	= $_POST['EmailContacto4'];
		$Sitio			= $_POST['Sitio'];
		$Logo			= $_POST['Logo'];
		$Msg			= $_POST['Msg'];
		
		if($Proceso == 1){ /* Agregar */
			$link=Conectarse();
			$bdCli=mysql_query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
			if ($row=mysql_fetch_array($bdCli)){
   				echo "<script> alert('Cliente ya registrado ...');</script>";
			}else{
				mysql_query("insert into clientes	 (	RutClie,
														Cliente,
														Giro,
														Direccion,
														Telefono,
														Celular,
														Email,
														Contacto,
														FonoContacto,
														EmailContacto,
														Contacto2,
														FonoContacto2,
														EmailContacto2,
														Contacto3,
														FonoContacto3,
														EmailContacto3,
														Contacto4,
														FonoContacto4,
														EmailContacto4,
														Sitio,
														Logo,
														Msg) 
										values 		(	'$RutCli',
														'$Cliente',
														'$Giro',
														'$Direccion',
														'$Telefono',
														'$Celular',
														'$Email',
														'$Contacto',
														'$FonoContacto',
														'$EmailContacto',
														'$Contacto2',
														'$FonoContacto2',
														'$EmailContacto2',
														'$Contacto3',
														'$FonoContacto3',
														'$EmailContacto3',
														'$Contacto4',
														'$FonoContacto4',
														'$EmailContacto4',
														'$Sitio',
														'$Logo',
														'$Msg')",$link);
			}
			mysql_close($link);
		}
		if($Proceso == 2){ /* Grabar */
			$link=Conectarse();
			$bdCli=mysql_query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
			if ($row=mysql_fetch_array($bdCli)){
				$actSQL="UPDATE clientes SET ";
				$actSQL.="Cliente		='".$Cliente."', ";
				$actSQL.="Giro			='".$Giro."', ";
				$actSQL.="Direccion		='".$Direccion."', ";
				$actSQL.="Telefono		='".$Telefono."', ";
				$actSQL.="Celular		='".$Celular."', ";
				$actSQL.="Email			='".$Email."', ";
				$actSQL.="Contacto		='".$Contacto."', ";
				$actSQL.="FonoContacto	='".$FonoContacto."', ";
				$actSQL.="EmailContacto	='".$EmailContacto."', ";
				$actSQL.="Contacto2		='".$Contacto2."', ";
				$actSQL.="FonoContacto2	='".$FonoContacto2."', ";
				$actSQL.="EmailContacto2='".$EmailContacto2."', ";
				$actSQL.="Contacto3		='".$Contacto3."', ";
				$actSQL.="FonoContacto3	='".$FonoContacto3."', ";
				$actSQL.="EmailContacto3='".$EmailContacto3."', ";
				$actSQL.="Contacto4		='".$Contacto4."', ";
				$actSQL.="FonoContacto4	='".$FonoContacto4."', ";
				$actSQL.="EmailContacto4='".$EmailContacto4."', ";
				$actSQL.="Sitio			='".$Sitio."', ";
				$actSQL.="Logo			='".$Logo."', ";
				$actSQL.="Msg			='".$Msg."'";
				$actSQL.="WHERE RutCli	= '".$RutCli."'";
				$bdCli=mysql_query($actSQL);
			}
			mysql_close($link);
		}
		if($Proceso == 3){ /* Eliminar */
			$link=Conectarse();
			$bdPro=mysql_query("DELETE FROM clientes WHERE RutCli = '".$RutCli."'");
			mysql_close($link);
			header("Location: lclientes.php");
		}
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
		<form name="frmItems" action="mantprov.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				Ficha de Clientes
				<div id="ImagenBarra">
					<a href="lclientes.php" title="Volver">
						<img src="imagenes/preview_back_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="#">
					<?php
						if($Proceso==3){
            				echo '<input name="Eliminar" type="image" id="Eliminar" src="../imagenes/Eliminar.png" width="28" height="28" title="Eliminar">';
						}else{
            				echo '<input name="Grabar" type="image" id="Grabar" src="imagenes/save_32.png" width="28" height="28" title="Guardar">';
						}
					?>
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
				if($Proceso == 1){ $TpEvento = 'Agregando un Nuevo Cliente ...'; };
				if($Proceso == 2){ $TpEvento = 'Editando Datos del Cliente ...'; };
				if($Proceso == 3){ $TpEvento = 'Eliminando Cliente ...'; };
				$Cliente		= "";
				$Giro			= "";
				$Direccion		= "";
				$Telefono		= "";
				$Celular		= "";
				$Email			= "";
				$Contacto		= "";
				$FonoContacto	= "";
				$EmailContacto	= "";
				$Contacto2		= "";
				$FonoContacto2	= "";
				$EmailContacto2	= "";
				$Contacto3		= "";
				$FonoContacto3	= "";
				$EmailContacto3	= "";
				$Contacto4		= "";
				$FonoContacto4	= "";
				$EmailContacto4	= "";
				$Sitio			= "";
				$Logo			= "";
				$Msg			= "";
				$link=Conectarse();
				$bdCli=mysql_query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
				if ($rowCli=mysql_fetch_array($bdCli)){
					$Cliente		= $rowCli['Cliente'];
					$Giro			= $rowCli['Giro'];
					$Direccion		= $rowCli['Direccion'];
					$Telefono		= $rowCli['Telefono'];
					$Celular		= $rowCli['Celular'];
					$Email			= $rowCli['Email'];
					$Contacto		= $rowCli['Contacto'];
					$FonoContacto	= $rowCli['FonoContacto'];
					$EmailContacto	= $rowCli['EmailContacto'];
					$Contacto2		= $rowCli['Contacto2'];
					$FonoContacto2	= $rowCli['FonoContacto2'];
					$EmailContacto2	= $rowCli['EmailContacto2'];
					$Contacto3		= $rowCli['Contacto3'];
					$FonoContacto3	= $rowCli['FonoContacto3'];
					$EmailContacto3	= $rowCli['EmailContacto3'];
					$Contacto4		= $rowCli['Contacto4'];
					$FonoContacto4	= $rowCli['FonoContacto4'];
					$EmailContacto4	= $rowCli['EmailContacto4'];
					$Sitio			= $rowCli['Sitio'];
					$Logo			= $rowCli['Logo'];
					$Msg			= $rowCli['Msg'];
				}
				mysql_close($link);
				echo '			<td width="6%"><strong>'.$TpEvento.'</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				echo '		<tr>';
				echo '			<td><strong>RUT </strong></td>';
				echo ' 		  	<td><strong>';
      		    echo '				<input name="RutCli" 	type="text" id="RutCli" size="50" maxlength="50"  value="'.$RutCli.'">';
      		    echo '				<input name="Proceso" 	type="hidden" id="Proceso" value="'.$Proceso.'">';
      		  	echo '				</strong>';
				echo '			</td>';
				echo ' 		</tr>';
				echo '		<tr>';
      		  	echo ' 			<td>Cliente :</td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Cliente" type="text" id="Cliente" size="50" maxlength="50" value="'.$Cliente.'">';
      		  	echo '			</td>';
   		  		echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Giro : </td>';
      		  	echo '			<td height="30">';
				echo '				<textarea name="Giro" cols="60" rows="5" id="Giro">'.$Msg.'</textarea></td>';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Dirección :</td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Direccion" type="text" id="Direccion" size="50" maxlength="50" value="'.$Direccion.'">';
				echo '			</td>';
   		  		echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Teléfono : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Telefono" type="text" id="Telefono" size="50" maxlength="50" value="'.$Telefono.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Celular : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Celular" type="text" id="Celular" size="50" maxlength="50" value="'.$Celular.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Correo Electrónico : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Email" type="text" id="Email" size="50" maxlength="50" value="'.$Email.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Contacto : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Contacto" type="text" id="Contacto" size="50" maxlength="50" value="'.$Contacto.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Teléfono : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="FonoContacto" type="text" id="FonoContacto" size="50" maxlength="50" value="'.$FonoContacto.'">';
				echo '			</td>';
				echo '		</tr>';
      		  	echo '			<td>Correo Electrónico : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="EmailContacto" type="text" id="EmailContacto" size="50" maxlength="50" value="'.$EmailContacto.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Contacto : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Contacto2" type="text" id="Contacto2" size="50" maxlength="50" value="'.$Contacto2.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Teléfono : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="FonoContacto2" type="text" id="FonoContacto2" size="50" maxlength="50" value="'.$FonoContacto2.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		</tr>';
      		  	echo '			<td>Correo Electrónico : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="EmailContacto2" type="text" id="EmailContacto2" size="50" maxlength="50" value="'.$EmailContacto2.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Contacto : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Contacto3" type="text" id="Contacto3" size="50" maxlength="50" value="'.$Contacto3.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Teléfono : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="FonoContacto3" type="text" id="FonoContacto3" size="50" maxlength="50" value="'.$FonoContacto3.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		</tr>';
      		  	echo '			<td>Correo Electrónico : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="EmailContacto3" type="text" id="EmailContacto3" size="50" maxlength="50" value="'.$EmailContacto3.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Contacto : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Contacto4" type="text" id="Contacto4" size="50" maxlength="50" value="'.$Contacto4.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Teléfono : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="FonoContacto4" type="text" id="FonoContacto4" size="50" maxlength="50" value="'.$FonoContacto4.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		</tr>';
      		  	echo '			<td>Correo Electrónico : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="EmailContacto4" type="text" id="EmailContacto4" size="50" maxlength="50" value="'.$EmailContacto4.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
      		  	echo '			<td>Sitio : </td>';
      		  	echo '			<td height="30">';
				echo '				<input name="Sitio" type="text" id="Sitio" size="50" maxlength="50" value="'.$Sitio.'">';
				if($Sitio){
					$imgfoto="logos/".$Logo;
					if ($Logo){
						$bDir="http://".$Sitio;
						echo "<a href=".$bDir." target=_blank title='".$Sitio."'>".$bDir."</a>";
					}
				}
				echo '			</td>';
				echo '		</tr>';
				if($RutCli){
				echo '		<tr>';
      		  	echo '			<td>Logo : </td>';
      		  	echo '			<td height="30">';
				if ($Logo){
					$imgfoto="logos/".$Logo;
					echo "<a href='uploadimg.php?RutCli=".$RutCli."'><img src='".$imgfoto."' border='0' border=2></a>";
				}else{
					echo "<a href='uploadimg.php?RutCli=".$RutCli."'><img src='imagenes/sin_foto.png' border='0' border=2></a>";
				}
				echo '			</td>';
				echo '		</tr>';
				}
				echo '		<tr>';
      		  	echo '			<td>Mensaje : </td>';
      		  	echo '			<td height="30">';
				echo '				<textarea name="Msg" cols="60" rows="5" id="Msg">'.$Msg.'</textarea></td>';
				echo '			</td>';
				echo '		</tr>';
    			echo '	</table>';
			?>
		</div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>

</body>
</html>
