<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";
	$tNetos	= 0;
	$TpCosto = '';
	
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

		
	$RutProv 	= "";
	$Proveedor 	= "";
	$Direccion	= "";
	$Telefono	= "";
	$Celular	= "";
	$Email		= "";
	$Contacto	= "";
	$TpCta		= "";
	$NumCta		= "";
	$Banco		= "";

	$Proceso = 1;
	
	if(isset($_GET['Proceso'])) { $Proceso  = $_GET['Proceso']; }
	if(isset($_GET['RutProv'])) { $RutProv  = $_GET['RutProv']; }

	if($Proceso == 2 or $Proceso ==3){
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM Proveedores WHERE RutProv = '".$RutProv."'");
		if ($row=mysqli_fetch_array($bdProv)){
   			$Proveedor 	= $row['Proveedor'];
			$Direccion	= $row['Direccion'];
   			$Telefono  	= $row['Telefono'];
   			$Celular  	= $row['Celular'];
			$Email 		= $row['Email'];
			$Contacto 	= $row['Contacto'];
			$TpCta 		= $row['TpCta'];
			$TpCosto	= $row['TpCosto'];
			$NumCta 	= $row['NumCta'];
			$Banco 		= $row['Banco'];
		}
		$link->close();
		if($_GET['Proceso']==3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}

	$sw = false;
	if(isset($_POST['Proceso'])){ 
		$Proceso 	= $_POST['Proceso'];
		if(isset($_POST['Proveedor'])){
			$Proveedor 	= $_POST['Proveedor'];
			if(isset($_POST['RutProv'])){
				$RutProv 	= $_POST['RutProv'];
				if(isset($_POST['Direccion']))	{ $Direccion 	= $_POST['Direccion']; 	}
				if(isset($_POST['Telefono']))	{ $Telefono  	= $_POST['Telefono']; 	}
				if(isset($_POST['Email']))		{ $Email  		= $_POST['Email']; 		}
				if(isset($_POST['Contacto']))	{ $Contacto 	= $_POST['Contacto']; 	}
				if(isset($_POST['TpCta']))		{ $TpCta  		= $_POST['TpCta']; 		}
				if(isset($_POST['TpCosto']))	{ $TpCosto  	= $_POST['TpCosto']; 	}
				if(isset($_POST['NumCta']))		{ $NumCta  		= $_POST['NumCta'];		}
				if(isset($_POST['Banco']))		{ $Banco  		= $_POST['Banco']; 		}
				if(isset($_POST['Celular']))	{ $Celular  	= $_POST['Celular']; 	}
				$sw = true;
			}
		}
	}
	if($sw == true){
		$sw = false;
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
			$link=Conectarse();
			$bdProv=$link->query("SELECT * FROM Proveedores WHERE RutProv = '".$RutProv."'");
			if ($row=mysqli_fetch_array($bdProv)){
				if($Proceso == 2){
	   				$MsgUsr = 'Registro Actualizado...';
					$bdProv=$link->query("SELECT * FROM Proveedores WHERE RutProv = '".$RutProv."'");
					if ($row=mysqli_fetch_array($bdProv)){
						$actSQL="UPDATE Proveedores SET ";
						$actSQL.="Proveedor		='".$Proveedor."',";
						$actSQL.="Direccion		='".$Direccion."',";
						$actSQL.="Telefono		='".$Telefono."',";
						$actSQL.="Celular		='".$Celular."',";
						$actSQL.="Email		    ='".$Email."',";
						$actSQL.="Contacto		='".$Contacto."',";
						$actSQL.="TpCta		    ='".$TpCta."',";
						$actSQL.="TpCosto	    ='".$TpCosto."',";
						$actSQL.="NumCta		='".$NumCta."',";
						$actSQL.="Banco			='".$Banco."'";
						$actSQL.="WHERE RutProv	= '".$RutProv."'";
						$bdRec=$link->query($actSQL);
					}
				}
				if($Proceso == 3){
					$bdProv=$link->query("DELETE FROM Proveedores WHERE RutProv = '".$RutProv."'");
					$link->close();
					header("Location: proveedores.php");
				}
			}else{
				$link->query("insert into Proveedores(	RutProv,
														Proveedor,
														Direccion,
														Telefono,
														Celular,
														Email,
														Contacto,
														TpCta,
														TpCosto,
														NumCta,
														Banco) 
										values 		(	'$RutProv',
														'$Proveedor',
														'$Direccion',
														'$Telefono',
														'$Celular',
														'$Email',
														'$Contacto',
														'$TpCta',
														'$TpCosto',
														'$NumCta',
														'$Banco')");
   				$MsgUsr = 'Se ha registrado un nuevo Proveedor ...';
			}
			$link->close();
		}
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Módulo de Gastos</title>

<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
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
<script language="javascript" src="validaciones.js"></script> 
<script src="../jquery/jquery-1.6.4.js"></script>
<script>
$(document).ready(function(){
   $("#dFactura").click(function(){
	    $("#RegistroFactura").css("display", "block");
	    $("#RegistroBoleta").css("display", "none");
   });
   $("#dBoleta").click(function(){
	    $("#RegistroFactura").css("display", "none");
	    $("#RegistroBoleta").css("display", "block");
   });
	
	$("#NetoF").bind('keypress', function(event)
	{
	// alert(event.keyCode);
	if (event.keyCode == '9')
		{
		neto  = document.form.NetoF.value;
		iva	  = neto * 0.19;
		bruto = neto * 1.19;
		document.form.IvaF.value 	= iva;
		document.form.BrutoF.value 	= bruto;
		// document.form.Iva.focus();
		return 0;
		}
	});
});
</script>
</head>

<body onLoad="inicioformulario()">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="mproveedores.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
			<?php 
				$nomModulo = 'Mantención de Proveedores';
				include('menuIconos.php'); 
			?>
			</div>
			
			<?php include('barraOpciones.php'); ?>

			<!-- Fin Caja Cuerpo -->
			
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td>Registro de Poveedores';
				echo '				<div id="ImagenBarra">';
				if($Proceso == 1 || $Proceso == 2){
            		echo '			<input name="Grabar" type="image" id="Grabar" src="imagenes/save_32.png" width="28" height="28" title="Guardar">';
				}else{
            		echo '			<input name="Eliminar" type="image" id="Grabar" src="imagenes/inspektion.png" width="28" height="28" title="Eliminar">';
				}
				echo '				</div>';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				

				echo '<div id="RegistroFactura">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr>';
				echo '			<td>Rut: </td>';
				echo '			<td>';
				echo '				<input name="RutProv" 	type="text" size="10" maxlength="10" value="'.$RutProv.'">';
				echo '				<input name="Proceso"  	type="hidden" value="'.$Proceso.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Proveedor: </td>';
				echo '			<td>';
				echo '				<input name="Proveedor" 	type="text" size="50" maxlength="50" value="'.$Proveedor.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Dirección: </td>';
				echo '			<td>';
				echo '				<input name="Direccion" 	type="text" size="50" maxlength="50" value="'.$Direccion.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Email: </td>';
				echo '			<td>';
				echo '				<input name="Email" 	type="email" size="50" maxlength="50" value="'.$Email.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Telefono: </td>';
				echo '			<td>';
				echo '				<input name="Teléfono" 	type="text" size="30" maxlength="30" value="'.$Telefono.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Celular: </td>';
				echo '			<td>';
				echo '				<input name="Celular" 	type="text" size="13" maxlength="13" value="'.$Celular.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Contacto: </td>';
				echo '			<td>';
				echo '				<input name="Contacto" 	type="text" size="50" maxlength="50" value="'.$Contacto.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Tipo Cuenta: </td>';
				echo '			<td>';
				echo '				<input name="TpCta" 	type="text" size="40" maxlength="40" value="'.$TpCta.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Número de Cuenta: </td>';
				echo '			<td>';
				echo '				<input name="NumCta" 	type="text" size="40" maxlength="40" value="'.$NumCta.'">';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>Banco: </td>';
				echo '			<td>';
				echo '				<input name="Banco" 	type="text" size="50" maxlength="50" value="'.$Banco.'">';
				echo '			</td>';
				echo '		</tr>';?>
				
							<tr>
								<td>Emite Facturas Exenta: </td>
								<td>
									<select name="TpCosto">
										<?php if($TpCosto == 'S'){?>
											<option selected value="S"> Si </option>
											<option>					No </option>
										<?php }else{ ?>
											<option vlue="S"> Si </option>
											<option selected> No </option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<?php
				echo '	</table>';
				echo '</div>';


				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">';
				echo '		<tr>';
				echo '			<td>Mensaje al Usuario... ';
				if($MsgUsr){
					echo '<div id="Saldos">'.$MsgUsr.'</div>';
				}else{
					echo '<div id="Saldos" style="display:none; ">'.$MsgUsr.'</div>';
				}
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';


				if($tNetos > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total Página</td>';
					echo '			<td width="10%">'.number_format($tNeto , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tIva  , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tBruto, 0, ',', '.').'			</td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td>&nbsp;</td>';
					echo '		</tr>';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total General</td>';
					echo '			<td width="10%">'.number_format($tNetos , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tIvas  , 0, ',', '.').'			</td>';
					echo '			<td width="10%">'.number_format($tBrutos, 0, ',', '.').'			</td>';
    				echo '			<td></td>';
    				echo '			<td></td>';
					echo '		</tr>';
					echo '	</table>';
				}
				echo '</div>';
			?>

		</div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>
</body>
</html>