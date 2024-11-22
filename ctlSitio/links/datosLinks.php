<?php
	if(isset($_POST['imagenesLinks'])){
		echo 'imagenesLinks...';
	}
	$nServicio 		= '';
	$nomServicio	= '';

	if(isset($_GET['nServicio'])) 	{ $nServicio 	= $_GET['nServicio']; 	}
	if(isset($_GET['accion'])) 		{ $accion 		= $_GET['accion']; 		}

	if(isset($_POST['nServicio'])) 	{ $nServicio 	= $_POST['nServicio']; 	}
	if(isset($_POST['accion'])) 	{ $accion 		= $_POST['accion']; 	}

	if(isset($_POST['guardaLinks'])) { 
		if(isset($_POST['nomServicio'])) 		{ $nomServicio 			= $_POST['nomServicio']; 			}
		if(isset($_POST['txtServicio'])) 		{ $txtServicio 			= $_POST['txtServicio']; 			}
		if(isset($_POST['descripcionServicio'])){ $descripcionServicio 	= $_POST['descripcionServicio']; 	}
		
		$linkSitio=ConectarseSitio();
		$bdSe=mysql_query("SELECT * FROM servicios Where nServicio = '".$nServicio."'");
		if($rowSe=mysql_fetch_array($bdSe)){
			$actSQL="UPDATE servicios SET ";
			$actSQL.="nomServicio			='".$nomServicio.		"',";
			$actSQL.="txtServicio			='".$txtServicio.		"',";
			$actSQL.="descripcionServicio	='".$descripcionServicio."'";
			$actSQL.="WHERE nServicio 	= '".$nServicio."'";
			$bdCot=mysql_query($actSQL);
		}else{
			mysql_query("insert into servicios	(
													nServicio,
													nomServicio,
													txtServicio,
													descripcionServicio
												)	 
										values 	(	'$nServicio',
										  			'$nomServicio',
													'$txtServicio',
													'$descripcionServicio'
										  		)",$link);
		}
		mysql_close($linkSitio);
	}

	$linkSitio=ConectarseSitio();
	$bdSe=mysql_query("SELECT * FROM servicios Where nServicio = '".$nServicio."'");
	if($rowSe=mysql_fetch_array($bdSe)){
		$nomServicio 			= $rowSe['nomServicio'];
		$txtServicio 			= $rowSe['txtServicio'];
		$descripcionServicio 	= $rowSe['descripcionServicio'];
	}
	mysql_close($linkSitio);
?>
<form name="form" action="index.php" method="post">
	<table border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
		<tr>
			<td style="font-size:18px;" width="80%">
				<input name="nServicio" id="nServicio" 	value="<?php echo $nServicio; ?>" 	type="hidden">
				<input name="accion" 	id="accion" 	value="<?php echo $accion; ?>" 		type="hidden">
				Ficha Links <b><?php echo $nomServicio; ?></b>
			</td>
			<td style="border-left:1px solid #ccc; padding-left:5px;" width="20%">
				<button name="imagenesLinks">
					<img src="/imagenes/banner_design_128.png" width="50"><br>
					Imágen
				</button>
				<button name="guardaLinks">
					<img src="/imagenes/guardar.png" width="50"><br>
					Guardar
				</button>
			</td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" id="boxIngreso">
		<tr>
			<td width="20%" height="30" valign="top">Servicio / Link :</td>
			<td width="80%">
				<input name="nomServicio" id="nomServicio" width="100%" size="25" maxlength="25" value="<?php echo $nomServicio; ?>" autofocus placeholder="Links" required>
			</td>
		</tr>
		<tr>
			<td width="20%" height="30" valign="top">Descripción :</td>
			<td width="80%">
				<textarea name="txtServicio" id="txtServicio" rows="10" cols="90" placeholder="Descripción del Servicio..." required><?php echo $txtServicio; ?></textarea>
			</td>
		</tr>
		<tr>
			<td width="20%" height="30" valign="top">Detalle Servicio :</td>
			<td width="80%">
				<textarea name="descripcionServicio" id="descripcionServicio" rows="20" cols="90" placeholder="Detalle del Servicio..." required><?php echo $descripcionServicio; ?></textarea>
			</td>
		</tr>
	</table>
</form>