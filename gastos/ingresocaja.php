<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
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
	$RegIngresos = $result->num_rows; // obtenemos el número de filas
	$link->close();

	if($RegIngresos==0){
		$MsgUsr = "Cuenta sin Saldo, debe Registrar el Saldo Inicial...";
	}
		
	$FechaIng   = date('Y-m-d');
	$Hora		= date('H:i:s');
	$Detalle	= "";
	$Ingreso 	= "";
	$IngresoO   = 0;
	$Proceso 	= 1;
	$TpMov 		= 'I';

	if($_GET['nIngreso']) { $nIngreso  = $_GET['nIngreso']; 	}
	if($_GET['Proceso']) { $Proceso  = $_GET['Proceso']; 	}
	if($_GET['FechaIng']){ $FechaIng = $_GET['FechaIng']; 	}
	if($_GET['TpMov'])	 { $TpMov 	 = $_GET['TpMov']; 		}
	if($_GET['Detalle']) { $Detalle  = $_GET['Detalle']; 	}
	
	if($_GET['Proceso']==2 || $_GET['Proceso']==3){
		$link=Conectarse();
		$bdIng=$link->query("SELECT * FROM Ingresos WHERE nIngreso = '".$nIngreso."'");
		if ($row=mysqli_fetch_array($bdIng)){
   			$nIngreso = $row['nIngreso'];
   			$FechaIng = $row['FechaIng'];
			$Hora	  = $row['Hora'];
   			$TpMov    = $row['TpMov'];
   			$Detalle  = $row['Detalle'];
   			$Ingreso  = $row['Ingreso'];
			$IngresoO = $row['Ingreso'];
		}
		$link->close();
		if($_GET['Proceso']==3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}

	$sw = false;
	if(isset($_POST['Proceso'])){ 
		$nIngreso 	= $_POST['nIngreso'];
		$Proceso 	= $_POST['Proceso'];
		if(isset($_POST['FechaIng'])){
			$FechaIng 	= $_POST['FechaIng'];
			$Hora		= $_POST['Hora'];
			if(isset($_POST['Detalle'])){
				$Detalle = $_POST['Detalle'];
				if(isset($_POST['Ingreso'])){
					$Ingreso  = $_POST['Ingreso'];
					$IngresoO = $_POST['IngresoO'];
					if($Ingreso>0){
						$sw = true;
					}
				}
			}
		}
		if($sw==false){
   			$MsgUsr = 'Error de Ingreso: Debe ingresar todos los campos ...';
		}
	}
	
	if($sw == true){
		$sw = false;
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
			$link=Conectarse();
			$bdIng=$link->query("SELECT * FROM Ingresos WHERE nIngreso = '".$nIngreso."'");
			if ($row=mysqli_fetch_array($bdIng)){
				if($Proceso == 2){
					$IngresoOld = 0;
					$EgresoOld 	= 0;
					$IngresoOld = $row['Ingreso'];
					$EgresoOld 	= $row['Egreso'];
					$actSQL="UPDATE Ingresos SET ";
					if($TpMov=='E'){
						$actSQL.="Ingreso		    ='".$Cero."',";
						$actSQL.="Egreso		    ='".$Ingreso."'";
					}else{
						$actSQL.="Ingreso		    ='".$Ingreso."',";
						$actSQL.="Egreso		    ='".$Cero."'";
					}
					$actSQL.="WHERE nIngreso = '".$nIngreso."'";
					$bdRec=$link->query($actSQL);
					
	   				$MsgUsr = 'Registro Actualizado...';
					
					$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
					if ($rowRec=mysqli_fetch_array($bdRec)){
						if($TpMov=='E'){
							$Haber		= ($rowRec['Egreso'] - $EgresoOld) + $Ingreso;
						}else{
							$Debe	  	= ($rowRec['Ingreso'] - $IngresoOld) + $Ingreso;
						}
						$actSQL="UPDATE Recursos SET ";
						if($TpMov=='E'){
							$actSQL.="Egreso		    ='".$Haber."',";
						}else{
							$actSQL.="Ingreso		    ='".$Debe."',";
						}
						$actSQL.="Saldo		    	='".$SaldoAct."'";
						$actSQL.="WHERE IdRecurso	= '1'";
						
						$bdRec=$link->query($actSQL);
					}
					$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
					if ($rowRec=mysqli_fetch_array($bdRec)){
						$SaldoAct = $rowRec['Ingreso'] - $rowRec['Egreso'];
						$actSQL="UPDATE Recursos SET ";
						$actSQL.="Saldo		    	='".$SaldoAct."'";
						$actSQL.="WHERE IdRecurso	= '1'";
						
						$bdRec=$link->query($actSQL);
					}
				}
				if($Proceso == 3){
					$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
					if ($rowRec=mysqli_fetch_array($bdRec)){
						$SaldoAct = $rowRec['Saldo'] - $Ingreso;
						$actSQL="UPDATE Recursos SET ";
						$actSQL.="Saldo		    	='".$SaldoAct."'";
						$actSQL.="WHERE IdRecurso	= '1'";
						$bdRec=$link->query($actSQL);
					}
					$bdPro=$link->query("DELETE FROM Ingresos WHERE nIngreso = '".$nIngreso."'");
					$link->close();
					header("Location: ingresoscajachica.php");
				}
			}else{
				$result 	= $link->query("SELECT * FROM Ingresos");
				$nIngreso 	= $result->num_rows + 1;
				$link->query("insert into Ingresos	 (	nIngreso,
														IdRecurso,
														FechaIng,
														Hora,
														Detalle,
														Ingreso,
														Egreso,
														Saldo) 
										values 		(	'$nIngreso',
														'1',
														'$FechaIng',
														'$Hora',
														'$Detalle',
														'$Ingreso',
														'$Egreso',
														'$Saldo')");
   				$MsgUsr = 'Se ha registrado un nuevo Ingreso ...';
				$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
				if ($rowRec=mysqli_fetch_array($bdRec)){
						if($TpMov=='E'){
							$SaldoAct 	= $rowRec['Saldo'] - $Ingreso;
							$Haber		= $rowRec['Egreso'] + $Ingreso;
						}else{
							$SaldoAct = $rowRec['Saldo'] + $Ingreso;
							$Debe		= $rowRec['Ingreso'] + $Ingreso;
						}
						$actSQL="UPDATE Recursos SET ";
						if($TpMov=='E'){
							$actSQL.="Egreso		    ='".$Haber."',";
						}else{
							$actSQL.="Ingreso		    ='".$Debe."',";
						}
						$actSQL.="Saldo		    	='".$SaldoAct."'";
						$actSQL.="WHERE IdRecurso	= '1'";
						$bdRec=$link->query($actSQL);
				}
				
			}
			$link->close();
			header("Location: ingresoscajachica.php");
			$FechaIng 	= date('Y-m-d');
			$Hora		= date('H:i:s');
			$Detalle 	= "";
			$Ingreso 	= "";
			$Egreso		= "";
			$Saldo 		= "";
		}
	}
	$Saldo = 0;
	$link=Conectarse();
	$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
	if ($row=mysqli_fetch_array($bdRec)){
		$Recurso	= $row['Recurso'];
		$Salida 	= $row['Salida'];
		$Saldo 		= $row['Saldo'];
	}
	$link->close();
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modulo de Gastos</title>

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
		<form name="form" action="ingresocaja.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<?php 
					$nomModulo = 'Ingresos Banco';
					include('menuIconos.php'); 
				?>
				<?php
					include_once('mSaldos.php');
				?>				
			</div>
			<div id="BarraFiltro">
				<img src="imagenes/settings_32.png" width="28" height="28">
			</div>
			<!-- Fin Caja Cuerpo -->
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td>Cuenta: Itau';
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
				echo '			<td>Fecha</td>';
				echo '			<td>Ing./Egr.</td>';
				echo '			<td>Detalle</td>';
				echo '			<td>Monto</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>';
				echo '				<input name="FechaIng" 	type="date" size="10" maxlength="10" value="'.$FechaIng.'">';
				echo '				<input name="nIngreso"  type="hidden" value="'.$nIngreso.'">';
				echo '				<input name="Proceso"  	type="hidden" value="'.$Proceso.'">';
				echo '				<input name="Hora"  	type="hidden" value="'.$Hora.'">';
				echo '			</td>';
				echo '			<td>';
								?>
									<select name="TpMov">
										<option value="I">Ingreso</option>
										<option value="E">Egreso</option>
									</select>
								<?php
				echo '			</td>';
				echo '			<td><input name="Detalle" 	type="text"   size="60" maxlength="60" value="'.$Detalle.'">	</td>';
				echo '			<td><input name="Ingreso"	type="text"   size="10" maxlength="10" value="'.$Ingreso.'">';
				echo '				<input name="IngresoO"	type="hidden" size="10" maxlength="10" value="'.$IngresoO.'">';
				echo '			</td>';
				echo '		</tr>';
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
					echo '			<td width="15%">Total PÃ¡gina</td>';
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