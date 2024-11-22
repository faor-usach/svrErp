<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	
	$MsgUsr 	 = "";
	$Cargo		 = '';
	$Funcionario = '';
	$Prevision	 = '';
	$Liquido	 = 0;
	
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

	/* Declaraci�n de Variables */	
	$Run 				= "";
	$nHorasExtras		= "";
	$Paterno 			= "";
	$Materno			= "";
	$Nombres			= "";
	$Sexo				= "";
	$FechaNac			= "";
	$ProfesionOficio	= "";
	$Direccion			= "";
	$Comuna				= "";
	$Ciudad				= "";
	$Cargo				= "";
	$LugarTrabajo		= "";
	$TipoContrato		= "";
	$FechaContrato		= date('Y-m-d');
	$TerminoContrato	= date('Y-m-d');
	$ServicioIntExt		= "";
	$SueldoBase			= "";
	$PeriodoPago		= "M";
	$Banco				= "";
	$nCuenta			= "";
	$Fonos				= "";
	$Celular			= "";
	$Email				= "";
	$Estado				= "";
	$FechaPago			= "";

	$Mes = array(
					1 => 'Enero', 
					2 => 'Febrero',
					3 => 'Marzo',
					4 => 'Abril',
					5 => 'Mayo',
					6 => 'Junio',
					7 => 'Julio',
					8 => 'Agosto',
					9 => 'Septiembre',
					10 => 'Octubre',
					11 => 'Noviembre',
					12 => 'Diciembre'
				);
				
	
	$MesNum = array(	
					'Enero' 		=> '01', 
					'Febrero' 		=> '02',
					'Marzo' 		=> '03',
					'Abril' 		=> '04',
					'Mayo' 			=> '05',
					'Junio' 		=> '06',
					'Julio' 		=> '07',
					'Agosto' 		=> '08',
					'Septiembre'	=> '09',
					'Octubre' 		=> '10',
					'Noviembre' 	=> '11',
					'Diciembre'		=> '12'
				);

	$Proceso = 1;
	
	$fd 		= explode('-', date('Y-m-d'));
	$Periodo 	= $fd[1].".".$fd[0];

	if(isset($_GET['Proceso'])) 	{ $Proceso  	= $_GET['Proceso']; 	}
	if(isset($_GET['Run'])) 		{ $Run  		= $_GET['Run']; 		}
	if(isset($_GET['Periodo'])) 	{ $Periodo  	= $_GET['Periodo']; 	}
//	if($_GET['FechaPago']) 	{ $FechaPago  	= $_GET['FechaPago']; 	}

	if(isset($_POST['Run'])) 		{ $Run  	= $_POST['Run']; 		}
	if(isset($_POST['Periodo'])) 	{ $Periodo  = $_POST['Periodo']; 	}

	$m = substr($Periodo,0,2);
	$Mm = $Mes[ intval($m) ];

	$pPago = $Mm.'.'.$fd[0];
	$FechaPago = date('Y-m-d');
	
	if($Run){
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM Personal WHERE Run = '".$Run."'");
		if ($row=mysqli_fetch_array($bdProv)){
			$Funcionario 		= $row['Paterno'].' '.$row['Materno'].' '.$row['Nombres'];
   			$Paterno 			= $row['Paterno'];
   			$Materno 			= $row['Materno'];
   			$Nombres 			= $row['Nombres'];
			$Cargo				= $row['Cargo'];
			$LugarTrabajo		= $row['LugarTrabajo'];
			$TipoContrato		= $row['TipoContrato'];
			$FechaContrato		= $row['FechaContrato'];
			$TerminoContrato	= $row['TerminoContrato'];
			$ServicioIntExt		= $row['ServicioIntExt'];
			$SueldoBase			= $row['SueldoBase'];
			$Banco				= $row['Banco'];
			$nCuenta			= $row['nCuenta'];
			$Fonos				= $row['Fonos'];
			$Celular			= $row['Celular'];
			$Email				= $row['Email'];
			$Estado				= $row['Estado'];
		}
		$bdS=$link->query("SELECT * FROM Sueldos WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."'");
		if ($rowS=mysqli_fetch_array($bdS)){
   			$SueldoBase 	= $rowS['SueldoBase'];
   			$Liquido 		= $rowS['Liquido'];
   			$FechaPago 		= $rowS['FechaPago'];
   			$Estado 		= $rowS['Estado'];
		}
		$link->close();
	}

	$sw = false;
	if(isset($_POST['Proceso'])){ 
		$Proceso 	= $_POST['Proceso'];
		if(isset($_POST['SueldoBase'])){
			$SueldoBase = $_POST['SueldoBase'];
			$Liquido 	= $_POST['Liquido'];
			if(isset($_POST['Run'])){
				$Run 			= $_POST['Run'];
				$Periodo 		= $_POST['Periodo'];
				$FechaPago 		= $_POST['FechaPago'];
				if(isset($_POST['FechaPago'])){
					$Estado 		= 'P';
				}
				$sw = true;
			}
		}
	}


	if($sw == true){
		$sw = false;
		
		if($Proceso == 1 || $Proceso == 2 || $Proceso == 3){ /* Agregar */
			$link=Conectarse();
			$bdProv=$link->query("SELECT * FROM Sueldos WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."'");
			if ($row=mysqli_fetch_array($bdProv)){
				if($Proceso == 2){
	   				$MsgUsr = 'Registro Actualizado...';
					$link=Conectarse();
					$bdProv=$link->query("SELECT * FROM Sueldos WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."'");
					if ($row=mysqli_fetch_array($bdProv)){
						$actSQL="UPDATE Sueldos SET ";
						if($FechaPago){
							$actSQL.="FechaPago		='".$FechaPago."',";
							$actSQL.="Estado		='P',";
						}
						$actSQL.="SueldoBase		='".$SueldoBase."',";
						$actSQL.="Liquido			='".$Liquido."'";
						$actSQL.="WHERE Run			= '".$Run."' && PeriodoPago = '".$Periodo."'";
						$bdProv=$link->query($actSQL);
					}
					$link->close();
					header("Location: CalculoSueldos.php?Mm=".$Mm);
				}
				if($Proceso == 3){
					$link=Conectarse();
					$bdSu=$link->query("DELETE FROM Sueldos WHERE Run = '".$Run."' && PeriodoPago = '".$Periodo."'");
					$link->close();
					header("Location: CalculoSueldos.php?Mm=".$Mm);
				}
			}else{
					$IdProyecto = 'IGT-1118';
					echo $Periodo;
					$link->query("insert into Sueldos(
														Run,
														PeriodoPago,
														IdProyecto,
														SueldoBase,
														Liquido,
														FechaPago,
														Estado
														) 
										values 		(	
														'$Run',
														'$Periodo',
														'$IdProyecto',
														'$SueldoBase',
														'$Liquido',
														'$FechaPago',
														'$Estado'
														)");
					header("Location: CalculoSueldos.php?Mm=".$Mm);
			}
			$link->close();
		}
	}
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>M&oacute;dulo de Sueldos</title>

<link href="styles.css" rel="stylesheet" type="text/css">

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
	$("#SueldoBase").bind('keydown', function(event)
	{
		//alert(event.keyCode);
		if (event.keyCode == '9')
			{
	  		var Sb   = $(this).val();
			var Li = Math.round(Sb * 1.05 * 1.08 * 1.04);
			$("#Liquido").val(Li);
			return 0;
			}
	});
	$("#Liquido").bind('keydown', function(event)
	{
		//alert(event.keyCode);
		if (event.keyCode == '9')
			{
	  		var Li   = $(this).val();
			var Sb = Math.round(Li / 1.05 / 1.08 / 1.04);
			$("#SueldoBase").val(Sb);
			return 0;
			}
	});

});
</script>


</head>

<body onLoad="document.form.SueldoBase.focus()">
	<?php include_once('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="cSueldo2017.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<img src="../gastos/imagenes/subst_student.png" width="28" height="28" align="middle">
				<strong style="color:#FFFFFF; padding:0px 5px 5px; margin:5px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">
					<?php
						$txtTitulo  = 'Cálculo de Liquidación - ';
						if($Nombres) { $txtTitulo .= $Nombres.' '.$Paterno.' - '; }
						$txtTitulo .= '<span id="BoxPeriodo">'.$pPago.'</span>';
						echo $txtTitulo;
					?>
				</strong>
				<?php include_once('barramenu.php'); ?>
			</div>
			
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="personal.php" title="Personal">
						<img src="../gastos/imagenes/subst_student.png"><br>
					</a>
					Personal
				</div>
				<div id="ImagenBarraLeft" title="Prestadores">
					<a href="phonorarios.php" title="Prestadores">
						<img src="../gastos/imagenes/send_48.png"><br>
					</a>
					Prestadores
				</div>
				<div id="ImagenBarraLeft" title="Proveedores">
					<a href="proveedores.php" title="Proveedores">
						<img src="../gastos/imagenes/contactus_128.png"><br>
					</a>
					Proveedores
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Sueldos">
					<a href="CalculoSueldos.php" title="Cálculo de Sueldos">
						<img src="../gastos/imagenes/purchase_128.png"><br>
					</a>
					Sueldos
				</div>
				<div id="ImagenBarraLeft" title="Cálculo de Honorarios">
					<a href="CalculoHonorarios.php" title="Servicios de Honorarios">
						<img src="../gastos/imagenes/blank_128.png"><br>
					</a>
					Honorarios
				</div>
				<div id="ImagenBarraLeft" title="Pago Factura Proveedores">
					<a href="CalculoFacturas.php" title="Pago con Factura">
						<img src="../gastos/imagenes/crear_certificado.png"><br>
					</a>
					Facturas
				</div>
				<div id="ImagenBarraLeft" title="Informes Emitidos">
					<a href="ipdf.php" title="Informes Emitidos">
						<img src="../gastos/imagenes/pdf.png"><br>
					</a>
					Emitidos
				</div>
			</div>
			
			<!-- Fin Caja Cuerpo -->

			<div align="center">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td>Indivualización del Funcionario
							<div id="ImagenBarra">
								<?php
									if($Proceso == 1 || $Proceso == 2){
										echo '			<input name="Grabar" type="image" id="Grabar" src="../gastos/imagenes/save_32.png" width="28" height="28" title="Guardar">';
									}else{
										echo '			<input name="Eliminar" type="image" id="Grabar" src="../gastos/imagenes/inspektion.png" width="28" height="28" title="Eliminar">';
									}
								?>
							</div>
						</td>
					</tr>
				</table>
				<div id="RegistroFactura">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaId">
						<tr>
							<td width="10%">Rut: </td>
							<td>
								<?php
									if($Run){
										echo '<strong>'.$Run.'</stong>';
										echo '<input name="Run" 	type="hidden" size="10" maxlength="10" value="'.$Run.'">';
									}
								?>
								<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">
								<input name="Periodo"  	type="hidden" value="<?php echo $Periodo; ?>">
								<input name="FechaPago"	type="hidden" value="<?php echo $FechaPago; ?>">
							</td>
						</tr>
						<tr>
							<td>Funcionario: </td>
							<td>
								<?php
								if($Funcionario){
									echo '<strong>'.$Paterno.' '.$Materno.' '.$Nombres.'</strong>';
								}else{
									echo '<select name="Funcionario" onChange="window.location = this.options[this.selectedIndex].value; return true;">';
									$link=Conectarse();
									$bdPh=$link->query("SELECT * FROM Personal");
									if ($row=mysqli_fetch_array($bdPh)){
										DO{
											$vFuncionario = $row['Paterno'].' '.$row['Materno'].' '.$row['Nombres'];
											if($Funcionario == $vFuncionario){
												echo "<option selected 	value='cSueldo2017.php?Proceso=1&Run=".$row['Run']."&Periodo=".$Periodo."'>".$row['Paterno'].' '.$row['Materno'].' '.$row['Nombres']."</option>";
											}else{
												if($Funcionario == ""){
													$Funcionario = "X";
													echo "	<option selected></option>";
												}
												echo "<option  			value='cSueldo2017.php?Proceso=1&Run=".$row['Run']."&Periodo=".$Periodo."'>".$row['Paterno'].' '.$row['Materno'].' '.$row['Nombres']."</option>";
											}
										}WHILE ($row=mysqli_fetch_array($bdPh));
									}
									$link->close();
									echo '</select>';
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Cargo: </td>
							<td>
								<strong><?php echo $Cargo; ?></strong>
							</td>
						</tr>
					</table>

					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
						<tr>
							<td>Datos Sueldo</td>
						</tr>
					</table>
					
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">
						<tr>
							<td>Haberes </td>
							<td>% </td>
							<td>Bruto </td>
							<td>Fecha Pago </td>
						</tr>
						<tr>
							<td>
								<input name="SueldoBase" id="SueldoBase"	type="text" 	size="9" maxlength="9" value="<?php echo $SueldoBase; ?>">
							</td>
							<td>1.05 * 1.08 * 1.04</td>
							<td>
								<input name="Liquido" 	id="Liquido"		type="text" size="10" maxlength="10" value="<?php echo $Liquido; ?>">
							</td>
							<td>
								<?php 
									echo $Mm;
								?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>
</body>
</html>