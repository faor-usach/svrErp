<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr 	= "";	
	$TpDoc 		= "";
	$Proceso 	= "1";
	$nGasto 	= 0;
	$tNetos		= 0;
	$IdAutoriza = '';
	$Concepto	= '';
	$NetoF		= 0;
	$IvaF		= 0;
	$exento 	= 'off';
	if(isset($_POST['exento'])){ $exento	= $_POST['exento']; }
	if($exento != 'on'){
		$exento 	= 'off';
	}
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

	if(isset($_POST['Proceso'])){ 
		$Proceso 	= $_POST['Proceso'];
	}else{
				$ProveedorB 	= "";
				$nDocB			= "";
				$Bien_ServicioB	= "";
				$BrutoB			= "";
				$FechaGastoB    = date('Y-m-d');
				$HoraB			= date("H:i:s");

				$ProveedorF 	= "";
				$nDocF			= "";
				$Bien_ServicioF	= "";
				$BrutoF			= "";
				$FechaGastoF    = date('Y-m-d');
				$HoraF			= date("H:i:s");

				$Items 		= "";
				$TpGasto 	= "";
				$Recurso 	= "";
				$IdProyecto = "";
				$IdAuoriza	= "";
				$TpDoc = "B";
	}

	if(isset($_GET['Proceso'])) 	{ $Proceso   = $_GET['Proceso']; 	}
	if(isset($_GET['nGasto']))  	{ $nGasto 	 = $_GET['nGasto']; 	}
	if(isset($_GET['nInforme']))   	{ $nInforme	 = $_GET['nInforme']; 	}

	if(isset($_POST['Proceso'])) 	{ $Proceso   = $_POST['Proceso']; 	}
	if(isset($_POST['nGasto']))  	{ $nGasto 	 = $_POST['nGasto']; 	}
	if(isset($_POST['nInforme']))  	{ $nInforme	 = $_POST['nInforme']; 	}
	if(isset($_POST['Concepto']))  	{ $Concepto	 = $_POST['Concepto']; 	}

	if($Proceso == 2 or $Proceso == 3){
		$link=Conectarse();
		$bdGas=$link->query("SELECT * FROM MovGastos WHERE nGasto = '".$nGasto."'");
		if ($row=mysqli_fetch_array($bdGas)){
   			$TpDoc  		= $row['TpDoc'];
			if($TpDoc=="B"){
	   			$FechaGastoB 	= $row['FechaGasto'];
				$HoraB			= $row['Hora'];
	   			$nDocB  		= $row['nDoc'];
	   			$ProveedorB  	= $row['Proveedor'];
				$Bien_ServicioB	= $row['Bien_Servicio'];
				$NetoB 			= $row['Neto'];
				$IvaB 			= $row['Iva'];
				$BrutoB			= $row['Bruto'];
			}
			if($TpDoc=="F"){
	   			$FechaGastoF 	= $row['FechaGasto'];
				$HoraF			= $row['Hora'];
	   			$nDocF  		= $row['nDoc'];
	   			$ProveedorF  	= $row['Proveedor'];
				$Bien_ServicioF	= $row['Bien_Servicio'];
				$exento			= $row['exento'];
				$NetoF 			= $row['Neto'];
				$IvaF 			= $row['Iva'];
				$BrutoF			= $row['Bruto'];
			}
			
			$nInforme = $row['nInforme'];
			
			if($nInforme) {
				$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."'");
				if ($rowForm=mysqli_fetch_array($bdForm)){
					$Concepto = $rowForm['Concepto'];
				}
			}
						
			$bdIt=$link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
			if ($rowIt=mysqli_fetch_array($bdIt)){
				$Items 			= $rowIt['Items'];
			}
			$bdTpGto=$link->query("SELECT * FROM TipoGasto Where IdGasto = '".$row['IdGasto']."'");
			if ($rowGto=mysqli_fetch_array($bdTpGto)){
				$TpGasto 		= $rowGto['TpGasto'];
			}
			$link=Conectarse();
			$bdRec=$link->query("SELECT * FROM Recursos Where IdRecurso = '".$row['IdRecurso']."'");
			if ($rowRec=mysqli_fetch_array($bdRec)){
				$Recurso 		= $rowRec['Recurso'];
				$IdRecurso 		= $rowRec['IdRecurso'];
			}
			$IdProyecto 	= $row['IdProyecto'];
			$IdAutoriza 	= $row['IdAutoriza'];
		}
		$link->close();
		if(isset($_GET['Proceso']) == 3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}
	
	$sw = false;
	if(isset($_POST['TpDoc'])){
		$TpDoc 		= $_POST['TpDoc'];
		$Proceso	= $_POST['Proceso'];
		$nGasto		= $_POST['nGasto'];
		if($_POST['TpDoc']=="B"){
			if(isset($_POST['ProveedorB']))		{ $ProveedorB 	  = $_POST['ProveedorB']; 	 }
			if(isset($_POST['nDocB']))			{ $nDocB 		  = $_POST['nDocB']; 	  	 }
			if(isset($_POST['FechaGastoB']))	{ $FechaGastoB 	  = $_POST['FechaGastoB']; $HoraB = $_POST['HoraB']; }
			if(isset($_POST['Bien_ServicioB']))	{ $Bien_ServicioB = $_POST['Bien_ServicioB'];}
			if(isset($_POST['BrutoB']))			{ $BrutoB 		  = $_POST['BrutoB']; 		 }
			if(isset($_POST['ProveedorB'])){
				if(isset($_POST['nDocB'])){
					if(isset($_POST['FechaGastoB'])){
						if(isset($_POST['Bien_ServicioB'])){
							if(isset($_POST['BrutoB'])){
								if(isset($_POST['Items'])){
									if(isset($_POST['TpGasto'])){
										if(isset($_POST['Recurso'])){
											if(isset($_POST['IdProyecto'])){
												$sw = true;
											}
										}
									}
								}
							}
						}
					}
				}
			}
			$ProveedorF 	= "";
			$nDocF			= "";
			$Bien_ServicioF	= "";
			$exento			= '';
			$BrutoF			= "";
			$FechaGastoF    = date('Y-m-d');
			$HoraF			= date("H:i:s");
		}else{
			if(isset($_POST['ProveedorF']))		{ $ProveedorF 	  = $_POST['ProveedorF']; 	 	}
			if(isset($_POST['nDocF']))			{ $nDocF 		  = $_POST['nDocF']; 		 	}
			if(isset($_POST['FechaGastoF']))	{ $FechaGastoF 	  = $_POST['FechaGastoF']; $HoraF = $_POST['HoraF']; }
			if(isset($_POST['Bien_ServicioF']))	{ $Bien_ServicioF = $_POST['Bien_ServicioF'];	}
			if(isset($_POST['exento']))			{ $exento 		  = $_POST['exento'];			}
			if(isset($_POST['ProveedorF'])){
				if(isset($_POST['nDocF'])){
					if(isset($_POST['FechaGastoF'])){
						if(isset($_POST['Bien_ServicioF'])){
							if(isset($_POST['NetoF'])){
								if(isset($_POST['Items'])){
									if(isset($_POST['TpGasto'])){
										if(isset($_POST['Recurso'])){
											if(isset($_POST['IdProyecto'])){
												$sw = true;
											}
										}
									}
								}
							}
						}
					}
				}
			}
			if(isset($_POST['NetoF'])){
				$NetoF 	= $_POST['NetoF'];
				$IvaF   = 0;
				$BrutoF = $NetoF;
				if($exento == 'off'){
					$IvaF	= intval(round(($NetoF * 0.19)));
					$BrutoF	= $NetoF + $IvaF;
				}
			}
			$ProveedorB 	= "";
			$nDocB			= "";
			$Bien_ServicioB	= "";
			$BrutoB			= "";
			$FechaGastoB    = date('Y-m-d');
			$HoraB    		= date("H:i:s");
		}
		if(isset($_POST['Items']))			{ $Items 		  = $_POST['Items']; 		 }
		if(isset($_POST['TpGasto']))		{ $TpGasto 		  = $_POST['TpGasto']; 		 }
		if(isset($_POST['Recurso']))		{ $Recurso 		  = $_POST['Recurso']; 		 }
		if(isset($_POST['IdProyecto']))		{ $IdProyecto 	  = $_POST['IdProyecto']; 	 }
		if(isset($_POST['IdAutoriza']))		{ $IdAutoriza 	  = $_POST['IdAutoriza']; 	 }

		if($sw==false){
   			$MsgUsr = 'Error de Ingreso: Debe ingresar todos los campos ...';
		}
	}
	if(isset($ProveedorF) || isset($ProveedorB)){
		if(isset($ProveedorF)){
			$Proveedor = $ProveedorF;
		}else{
			$Proveedor = $ProveedorB;
		}
		
		
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM Proveedores Where RutProv = '".$Proveedor."'");
		if ($row=mysqli_fetch_array($bdProv)){
			$Proveedor = $row['Proveedor'];
		}
		$link->close();
		if(isset($ProveedorF)){
			$ProveedorF = $Proveedor;
		}else{
			$ProveedorB = $Proveedor;
		}
		
	}
	if($sw == true){
		$sw = false;
		if($_POST['TpDoc']=="B"){
			$Proveedor		= $_POST['ProveedorB'];
			$nDoc			= $_POST['nDocB'];
			$FechaGasto		= $_POST['FechaGastoB'];
			$Hora			= $_POST['HoraB'];
			$Bien_Servicio	= $_POST['Bien_ServicioB'];
			$Neto			= "";
			$Iva			= "";
			$Bruto			= $_POST['BrutoB'];
		}else{
			$Proveedor		= $_POST['ProveedorF'];
			$nDoc			= $_POST['nDocF'];
			$FechaGasto		= $_POST['FechaGastoF'];
			$Hora			= $_POST['HoraF'];
			$Bien_Servicio	= $_POST['Bien_ServicioF'];
			if(isset($_POST['exento'])) { $exento	= $_POST['exento']; }else{ $exento = 'off'; }
			$Neto			= $_POST['NetoF'];
			$Iva			= $_POST['IvaF'];
			$Bruto			= $_POST['BrutoF'];
		}
		$IdProyecto		= $_POST['IdProyecto'];

		$link=Conectarse();
		$bdIt = $link->query("SELECT * FROM ItemsGastos Where Items = '".$_POST['Items']."'");
		if ($row=mysqli_fetch_array($bdIt)){
			$nItem = $row['nItem'];
		}
		$bdTg = $link->query("SELECT * FROM TipoGasto Where TpGasto = '".$_POST['TpGasto']."'");
		if ($row=mysqli_fetch_array($bdTg)){
			$IdGasto = $row['IdGasto'];
		}
		$bdRec = $link->query("SELECT * FROM Recursos Where Recurso = '".$_POST['Recurso']."'");
		if ($row=mysqli_fetch_array($bdRec)){
			$IdRecurso = $row['IdRecurso'];
		}
		$link->close();
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3 ){ /* Agregar */
			If($Proceso==1){ $nGasto = 0; }
			$link=Conectarse();
			$bdGto=$link->query("SELECT * FROM MovGastos WHERE nGasto = '".$nGasto."'");
			if ($rowGto=mysqli_fetch_array($bdGto)){
				$nInforme = $rowGto ['nInforme'];
				$BrutoOld = $rowGto['Bruto'];
				if($Proceso == 2){
					if($TpDoc=="F"){
						if($Neto>0){
							$Bruto = $Neto;
							if($exento == 'off'){
								$Iva	= intval(round(($Neto * 0.19)));
								$Bruto	= $Neto + $Iva;
							}
						}
					}
					$actSQL="UPDATE MovGastos SET ";
					$actSQL.="Proveedor	    ='".$Proveedor."',";
					$actSQL.="nDoc	    	='".$nDoc."',";
					$actSQL.="FechaGasto   	='".$FechaGasto."',";
					$actSQL.="Hora   		='".$Hora."',";
					$actSQL.="Bien_Servicio	='".$Bien_Servicio."',";
					$actSQL.="exento	    ='".$exento."',";
					$actSQL.="Neto		    ='".$Neto."',";
					$actSQL.="Iva		    ='".$Iva."',";
					$actSQL.="Bruto		    ='".$Bruto."',";
					$actSQL.="nItem		    ='".$nItem."',";
					$actSQL.="IdGasto	    ='".$IdGasto."',";
					$actSQL.="IdRecurso		='".$IdRecurso."',";
					$actSQL.="IdProyecto	='".$IdProyecto."',";
					$actSQL.="IdAutoriza	='".$IdAutoriza."'";
					$actSQL.="WHERE nGasto  = '".$nGasto."'";
					$bdGto=$link->query($actSQL);
	   				//$MsgUsr = 'Registro de Gastos Actualizado...';
					$BrutoF = $Bruto;
					if($IdRecurso==1){
						$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
						if ($rowRec=mysqli_fetch_array($bdRec)){
							$SaldoAct = ($rowRec['Saldo'] + $BrutoOld) - $Bruto;
							$Egreso   = ($rowRec['Egreso'] - $BrutoOld) - $Bruto;
							$actSQL="UPDATE Recursos SET ";
							$actSQL.="Egreso		    ='".$Egreso."',";
							$actSQL.="Saldo		    	='".$SaldoAct."'";
							$actSQL.="WHERE IdRecurso	= '1'";
							$bdRec=$link->query($actSQL);
						}
					}
					if($nInforme>0){
						$result  = $link->query("SELECT SUM(Neto) as tNeto FROM MovGastos WHERE nInforme = '".$nInforme."'");
						$row 	 = mysqli_fetch_array($result);
						$tNeto = $row['tNeto'];
						$result  = $link->query("SELECT SUM(Iva) as tIva FROM MovGastos WHERE nInforme = '".$nInforme."'");
						$row 	 = mysqli_fetch_array($result);
						$tIva = $row['tIva'];
						$result  = $link->query("SELECT SUM(Bruto) as tBruto FROM MovGastos WHERE nInforme = '".$nInforme."'");
						$row 	 = mysqli_fetch_array($result);
						$tBruto = $row['tBruto'];

						$bdForm=$link->query("SELECT * FROM Formularios WHERE nInforme = '".$nInforme."'");
						if ($rowForm=mysqli_fetch_array($bdForm)){
							$actSQL="UPDATE Formularios SET ";
							$actSQL.="Concepto	    	='".$Concepto."',";
							$actSQL.="Neto		    	='".$tNeto."',";
							$actSQL.="Iva		    	='".$tIva."',";
							$actSQL.="Bruto		    	='".$tBruto."'";
							$actSQL.="WHERE nInforme 	= '".$nInforme."'";
							$bdForm=$link->query($actSQL);
						}
					}
				}
				if($Proceso == 3){
					if($IdRecurso==1){
						$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
						if ($rowRec=mysqli_fetch_array($bdRec)){
							$SaldoAct 	= $rowRec['Saldo'] - $BrutoOld;
							$Egreso 	= $rowRec['Egreso'] - $BrutoOld;
							$actSQL="UPDATE Recursos SET ";
							$actSQL.="Egreso	    	='".$Egreso."',";
							$actSQL.="Saldo		    	='".$SaldoAct."'";
							$actSQL.="WHERE IdRecurso	= '1'";
							$bdRec=$link->query($actSQL);
						}
					}
					$bdGas=$link->query("DELETE FROM MovGastos WHERE nGasto = '".$nGasto."'");
					$link->close();
					header("Location: igastos.php");
				}
				
			}else{
				$bdGt = $link->query('SELECT * FROM MovGastos Order By nGasto Desc');
				if($rowGt=mysqli_fetch_array($bdGt)){
					//$nGasto = $result->num_rows + 1;
					$nGasto = $rowGt['nGasto'] + 1;
				}
				
				$Modulo = 'G';
				$link->query("insert into MovGastos	 (	nGasto,
														Modulo,
														FechaGasto,
														Hora,
														TpDoc,
														Proveedor,
														nDoc,
														Bien_Servicio,
														exento,
														Neto,
														Iva,
														Bruto,
														nItem,
														IdGasto,
														IdRecurso,
														IdProyecto,
														IdAutoriza) 
										values 		(	'$nGasto',
														'$Modulo',
														'$FechaGasto',
														'$Hora',
														'$TpDoc',
														'$Proveedor',
														'$nDoc',
														'$Bien_Servicio',
														'$exento',
														'$Neto',
														'$Iva',
														'$Bruto',
														'$nItem',
														'$IdGasto',
														'$IdRecurso',
														'$IdProyecto',
														'$IdAutoriza')");
   				$MsgUsr = 'Se ha registrado un nuevo gasto...'.$nGasto;
				
				if($IdRecurso==1){
					$bdRec=$link->query("SELECT * FROM Recursos WHERE IdRecurso = '1'");
					if ($rowRec=mysqli_fetch_array($bdRec)){
						$SaldoAct = $rowRec['Saldo'] - $Bruto;
						$Egreso   = $rowRec['Egreso'] + $Bruto;
						$actSQL="UPDATE Recursos SET ";
						$actSQL.="Egreso		    ='".$Egreso."',";
						$actSQL.="Saldo		    	='".$SaldoAct."'";
						$actSQL.="WHERE IdRecurso	= '1'";
						$bdRec=$link->query($actSQL);
					}
				}

				header("Location: registragastos.php");

				$ProveedorB 	= "";
				$nDocB			= 0;
				$Bien_ServicioB	= "";
				$BrutoB			= 0;
				$FechaGastoB    = date('Y-m-d');
				$HoraB    		= date("H:i:s");

				$ProveedorF 	= "";
				$nDocF			= 0;
				$Bien_ServicioF	= "";
				$BrutoF			= 0;
				$FechaGastoF    = date('Y-m-d');
				$HoraF    		= date("H:i:s");

				$Items 		= "";
				$TpGasto 	= "";
				$Recurso 	= "";
				$IdProyecto = "";
				$IdAuoriza	= "";
			}
			$link->close();
		}
	}

		$link=Conectarse();
		$bdGas=$link->query("SELECT * FROM MovGastos WHERE nGasto = '".$nGasto."'");
		if($row=mysqli_fetch_array($bdGas)){
   			$TpDoc  		= $row['TpDoc'];
			if($TpDoc=="B"){
	   			$FechaGastoB 	= $row['FechaGasto'];
				$HoraB			= $row['Hora'];
	   			$nDocB  		= $row['nDoc'];
	   			$ProveedorB  	= $row['Proveedor'];
				$Bien_ServicioB	= $row['Bien_Servicio'];
				$NetoB 			= $row['Neto'];
				$IvaB 			= $row['Iva'];
				$BrutoB			= $row['Bruto'];
			}
			if($TpDoc=="F"){
	   			$FechaGastoF 	= $row['FechaGasto'];
				$HoraF			= $row['Hora'];
	   			$nDocF  		= $row['nDoc'];
	   			$ProveedorF  	= $row['Proveedor'];
				$Bien_ServicioF	= $row['Bien_Servicio'];
				$exento			= $row['exento'];
				$NetoF 			= $row['Neto'];
				$IvaF 			= $row['Iva'];
				$BrutoF			= $row['Bruto'];
			}
		}
		$link->close();

	function buscador($n){
		$n = "Francisco";
		return $n;
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
		iva	  = parseInt(neto * 0.19);
		bruto = parseInt(neto * 1.19);

		$("#IvaF").val(iva);
		$("#BrutoF").val(bruto);
		
		//document.form.IvaF.value 	= iva;
		//document.form.BrutoF.value 	= bruto;
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
		<form name="form" action="registragastos.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<?php 
					$nomModulo = 'Registra Gastos';
					include('menuIconos.php'); 
				?>
			</div>
			<?php include('barraOpciones.php'); ?>
			
			<!-- Fin Caja Cuerpo -->
			<div align="center">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td>
							<span style="font-size:20px;">Registro de Gastos</span>
								<div id="ImagenBarra">
									<?php if($Proceso == 1 || $Proceso == 2){?>
            								<input name="Grabar" type="image" id="Grabar" src="imagenes/save_32.png" width="28" height="28" title="Guardar">
									<?php }else{ ?>
            								<input name="Eliminar" type="image" id="Eliminar" src="imagenes/inspektion.png" width="28" height="28" title="Eliminar">
									<?php } ?>
								</div>
						</td>
					</tr>
				</table>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">
					<tr style="float:left;">
						<?php if($TpDoc=="B"){?>
							<td>
								<input name="TpDoc" id="dBoleta"  type="radio" value="B" checked>Boleta
							</td>
							<td>
								<input name="TpDoc" id="dFactura" type="radio" value="F">Factura
							</td>
						<?php }else{ ?>
							<td>
								<input name="TpDoc" id="dBoleta"  type="radio" value="B" >Boleta
							</td>
							<td>
								<input name="TpDoc" id="dFactura" type="radio" value="F" checked>Factura
							</td>
						<?php } ?>
					</tr>
				</table>
				<?php if($TpDoc=="B"){ ?>					
				<div id="RegistroFactura" style="display:none;">
				<?php }else{ ?>
					<div id="RegistroFactura">
				<?php } ?>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
							<td>Proveedor					</td>
							<td>N° Factura					</td>
							<td>Fecha						</td>
							<td>Bien o Servicio / Concepto	</td>
							<td>Exento						</td>
							<td>Neto						</td>
							<td>IVA							</td>
							<td>Bruto						</td>
						</tr>
						<tr>
							<td>
								<input name="ProveedorF" 	 	type="text" size="50" maxlength="50" list="prov" value="<?php echo $ProveedorF; ?>" onchange(buscador(<?php echo $ProveedorF; ?>))>
									<datalist id="prov">
										<?php
											$link=Conectarse();
											$bdProv=$link->query("SELECT * FROM Proveedores");
											if($row=mysqli_fetch_array($bdProv)){
												do{?>
													<option value="<?php echo $row['Proveedor']; ?>">
													<?php
												}while ($row=mysqli_fetch_array($bdProv));
											}
										?>
									</datalist>
									<input name="Proceso"  			type="hidden" value="<?php echo $Proceso; ?>">
									<input name="nGasto"  			type="hidden" value="<?php echo $nGasto; ?>">
							</td>
							<td>
								<input name="nDocF" 				type="text" 	size="10" maxlength="10" value="<?php echo $nDocF; ?>">
							</td>
							<td>
								<input name="FechaGastoF"			type="date" 	size="8" maxlength="8" value="<?php echo $FechaGastoF; ?>">
								<input name="HoraF"					type="hidden" 	size="10" maxlength="10" value="<?php echo $HoraF; ?>">
							</td>
							<td>
								<input name="Bien_ServicioF" 		type="text" 	size="30" maxlength="100" value="<?php echo $Bien_ServicioF; ?>">
								<?php if($Concepto){ ?>
										<br>Concepto <br>
										<input name="Concepto" 		type="text" size="30" maxlength="100" value="<?php echo $Concepto; ?>">
										<input name="nInforme" 		type="hidden"  value="<?php echo $nInforme; ?>">
								<?php } ?>
							</td>
							<td>
								<?php 
									echo $exento;
									if($exento == 'on'){ ?>
									<input type="checkbox" name="exento" checked>
								<?php }else{ ?>
									<input type="checkbox" name="exento">
								<?php } ?>
							</td>
							<td>
								<input name="NetoF" id="NetoF"	type="text" size="7" maxlength="10" value="<?php echo $NetoF; ?>">
							</td>
							<td>
								<input name="IvaF" 				type="text" size="7" maxlength="10" value="<?php echo $IvaF; ?>">
							</td>
							<td>
								<input name="BrutoF" 			type="text" size="7" maxlength="10" value="<?php echo $BrutoF; ?>">
							</td>
						</tr>
					</table>
				</div>
				
				<!-- Registro de Boletas -->
				
				<?php if($TpDoc=="B"){ ?>
					<div id="RegistroBoleta">
				<?php }else{ ?>
					<div id="RegistroBoleta" style="display:none;">
				<?php } ?>
						<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
							<tr>
								<td>Proveedor		</td>
								<td>N° Boleta		</td>
								<td>Fecha			</td>
								<td>Bien o Servicio	</td>
								<td>Total			</td>
							</tr>
						<tr>
							<td>
								<input name="ProveedorB" list="prov" type="text" size="50" maxlength="50"  value="<?php echo $ProveedorB; ?>" />
									<datalist id="prov">
										<?php
											$link=Conectarse();
											$bdProv=$link->query("SELECT * FROM Proveedores");
											if($row=mysqli_fetch_array($bdProv)){
												do{?>
													<option value="<?php echo $row['Proveedor']; ?>">
													<?php
												}while ($row=mysqli_fetch_array($bdProv));
											}
										?>
									</datalist>
								<input name="Proceso"  			type="hidden" value="<?php echo $Proceso; ?>">
								<input name="nGasto"  			type="hidden" value="<?php echo $nGasto; ?>">
							</td>
							<td>
								<input name="nDocB"	 	 		type="text" size="10" maxlength="10" 	value="<?php echo $nDocB; ?>">
							</td>
							<td>
								<input name="FechaGastoB"		type="date"   size="10" maxlength="10" 	value="<?php echo $FechaGastoB; ?>">
								<input name="HoraB"				type="hidden" size="10" maxlength="10" 	value="<?php echo $HoraB; ?>">
							</td>
							<td>
								<input name="Bien_ServicioB"  	type="text" size="30" maxlength="100" 	value="<?php echo $Bien_ServicioB; ?>">
							</td>
							<td>
								<input name="BrutoB" 			type="text" size="10" maxlength="10" 	value="<?php echo $BrutoB; ?>">
							</td>
						</tr>
					</table>
				</div>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">
					<tr>
						<td>Opciones
							<?php if($MsgUsr){ ?>
									<div id="Saldos"><?php echo $MsgUsr; ?></div>
							<?php }else{ ?>
									<div id="Saldos" style="display:none; "><?php echo $MsgUsr; ?></div>
							<?php } ?>
						</td>
					</tr>
				</table>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
					<tr>
						<td id="CajaOpc">
							Items de Gastos
						</td>
						<td id="CajaOpc">
							Tipo de Gastos
						</td>
						<td id="CajaOpc">
							Cuenta de Cargo
						</td>
						<td id="CajaOpc">
							Proyectos
						</td>
					</tr>
					<tr>
						<td id="CajaOpcDatos" valign="top">
							<?php
								$link=Conectarse();
								$bdIt=$link->query("SELECT * FROM ItemsGastos Order By nItem");
								if ($row=mysqli_fetch_array($bdIt)){
									do{
										if(isset($Items)){
											if($Items==$row['Items']){ ?>
												<input type="radio" name="Items" value="<?php echo $row['Items']; ?>" checked>	<?php echo $row['Items']; ?><br>
											<?php }else{ ?>
												<input type="radio" name="Items" value="<?php echo $row['Items']; ?>">			<?php echo $row['Items']; ?><br>
											<?php }
										}else{ ?>
											<input type="radio" 	name="Items" value="<?php echo $row['Items']; ?>">			<?php echo $row['Items']; ?><br>
											<?php
										}
									}while ($row=mysqli_fetch_array($bdIt));
								}
								$link->close();
							?>
						</td>
						<td id="CajaOpcDatos" valign="top">
							<?php
								$link=Conectarse();
								$bdTpGto=$link->query("SELECT * FROM TipoGasto Where Estado = 'on' Order By IdGasto");
								if ($row=mysqli_fetch_array($bdTpGto)){
									do{
										if(isset($TpGasto)){
											if($TpGasto==$row['TpGasto']){?>
												<input type="radio" name="TpGasto" value="<?php echo $row['TpGasto']; ?>" checked>	<?php echo $row['TpGasto']; ?><br>
											<?php }else{ ?>
												<input type="radio" name="TpGasto" value="<?php echo $row['TpGasto']; ?>">			<?php echo $row['TpGasto']; ?><br>
												<?php
											}
										}else{ ?>
											<input type="radio" 	name="TpGasto" value="<?php echo $row['TpGasto']; ?>">			<?php echo $row['TpGasto']; ?><br>
											<?php
										}
									}while($row=mysqli_fetch_array($bdTpGto));
								}
								$link->close();
							?>
						</td>
						<td id="CajaOpcDatos" valign="top">
							<?php 
								$link=Conectarse();
								$bdRec=$link->query("SELECT * FROM Recursos  Where Estado = 'on' Order By nPos");
								if ($row=mysqli_fetch_array($bdRec)){
									do{
										if(isset($Recurso)){
											if($Recurso==$row['Recurso']){ ?>
												<input type="radio" name="Recurso" value="<?php echo $row['Recurso']; ?>" checked>	<?php echo $row['Recurso']; ?><br>
											<?php }else{ ?>
												<input type="radio" name="Recurso" value="<?php echo $row['Recurso']; ?>">			<?php echo $row['Recurso']; ?><br>
												<?php
											}
										}else{ ?>
											<input type="radio" 	name="Recurso" value="<?php echo $row['Recurso']; ?>">			<?php echo $row['Recurso']; ?><br>
											<?php
										}
									}while($row=mysqli_fetch_array($bdRec));
								}
								$link->close();
							?>
						</td>
						<td id="CajaOpcDatos" valign="top">
							<?php 
								$link=Conectarse();
								$bdPr=$link->query("SELECT * FROM Proyectos Order By IdProyecto");
								if ($row=mysqli_fetch_array($bdPr)){
									do{
										if(isset($IdProyecto)){
											if($IdProyecto==$row['IdProyecto']){ ?>
												<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>" checked><?php echo $row['IdProyecto']; ?><br>
											<?php }else{ ?>
												<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto']; ?>">		<?php echo $row['IdProyecto']; ?><br>
												<?php
											}
										}else{ ?>
											<input type="radio" name="IdProyecto" value="<?php echo $row['IdProyecto'];?>">				<?php echo $row['IdProyecto']; ?><br>
											<?php 
										}
									}while($row=mysqli_fetch_array($bdPr));
								}
								$link->close();
							?>
						</td>
					</tr>
				</table>
				<?php if($tNetos > 0){ ?>
						<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">
							<tr>
								<td width=" 5%">&nbsp;</td>
								<td width=" 8%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								<td width="10%">&nbsp;</td>
								<td width=" 7%">&nbsp;</td>
								<td width="15%">Total Página</td>
								<td width="10%"><?php echo number_format($tNeto , 0, ',', '.'); ?>	</td>
								<td width="10%"><?php echo number_format($tIva  , 0, ',', '.'); ?>	</td>
								<td width="10%"><?php echo number_format($tBruto, 0, ',', '.'); ?>	</td>
    							<td></td>
    							<td></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td width=" 5%">&nbsp;</td>
								<td width=" 8%">&nbsp;</td>
								<td width="15%">&nbsp;</td>
								<td width="10%">&nbsp;</td>
								<td width=" 7%">&nbsp;</td>
								<td width="15%">Total General</td>
								<td width="10%"><?php echo number_format($tNetos , 0, ',', '.'); ?>	</td>
								<td width="10%"><?php echo number_format($tIvas  , 0, ',', '.'); ?>	</td>
								<td width="10%"><?php echo number_format($tBrutos, 0, ',', '.'); ?>	</td>
    							<td></td>
    							<td></td>
							</tr>
						</table>
						<?php
				}
				?>
				</div>
		</div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>

</body>
</html>