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
	$Concepto 	= "";
	$MsgUsr 	= "";
	$Formulario = "";
	$Iva		= "";
	$IdProyecto	= "";
	
	if(isset($_POST['Formulario']))	{ $Formulario 	= $_POST['Formulario']; }
	if(isset($_POST['Iva']))		{ $Iva 			= $_POST['Iva']; 		}
	if(isset($_POST['IdProyecto']))	{ $IdProyecto	= $_POST['IdProyecto']; }
	if(isset($_POST['Concepto'])){
		$Concepto = $_POST['Concepto'];
		if($_POST['Concepto']==""){
			$MsgUsr = "Debe Ingresar el Concepto o Motivo del Gasto... ";
		}else{
			if(!isset($_POST['Formulario'])){
				$MsgUsr = "Debe Ingresar el Tipo de Formulario a Imprimir... ";
			}else{
				if(!isset($_POST['Iva'])){
					$MsgUsr = "Debe decidir si incluye el I.V.A. al Formulario a Imprimir... ";
				}else{
					if(!isset($_POST['IdProyecto'])){
						$MsgUsr = "Debe asociar un Proyecto al Formulario a Imprimir... ";
					}else{
						require_once('formularios/F3B.php');
					}
				}
			}
		}
	}

?>
<!doctype html>
 
<html lang="es">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Reembolsos</title>

	<link href="estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenu.css" rel="stylesheet" type="text/css">
	<link href="../css/barramenuModulos.css" rel="stylesheet" type="text/css">
	<link href="../css/styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<script language="javascript" src="validaciones.js"></script> 
	<script src="../jquery/jquery-1.6.4.js"></script>
	<script>
		function open_f7(){
			window.open("formulario/F7-00001.pdf");
		}
		function open_formulario(){
			window.open("formulario/F3B-00001.pdf");
		}
	</script>
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

<body onLoad="inicioformulario()" ng-app="myApp" ng-controller="ctrlEnsayos">
	
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		
		<form name="form" action="eformularios.php" method="post">
		<div id="CajaCpo">
			<?php 
				$nomModulo = 'Formularios Emitidos';
				include('menuIconos.php'); 
			?>
			
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td>Emisión de Formularios';
				echo '				<div id="ImagenBarra">';
            	echo '					<input name="Imprimir" type="image" id="Imprimir" src="imagenes/printer_128_hot.png" width="28" height="28" title="Emitir Formulario">';
				echo '				</div>';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				
				echo '<div id="RegistroBoleta">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr>';
				echo '			<td>Conceptosss o motivo del los Gastos Realizados</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>';
				echo '				<input name="Concepto"  		type="text" size="65" maxlength="65"  value="'.$Concepto.'" requiered />';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				echo '</div>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">';
				echo '		<tr>';
				echo '			<td>Opciones';
				if($MsgUsr){
					echo '<div id="Saldos">'.$MsgUsr.'</div>';
				}else{
					echo '<div id="Saldos" style="display:none; ">'.$MsgUsr.'</div>';
				}
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaDocumentos">';
				echo '		<tr>';
				echo '			<td id="CajaOpc">';
				echo '				Formulario a Imprimir';
				echo '			</td>';
				echo '			<td id="CajaOpc">';
				echo '				Incluir al Formulario registros...';
				echo '			</td>';
				echo '			<td id="CajaOpc">';
				echo '				Seleccione Proyecto Asociado...';
				echo '			</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td id="CajaOpcDatos" valign="top">';
				if($Formulario=="F3B1"){
			    	echo '				<input type="radio" name="Formulario" value="F3B1" title="Imprime Formulario F3B, Banco, Cheque y Transferencia" 	checked	>Formulario F3B(Itau)	<br>';
				}else{
			    	echo '				<input type="radio" name="Formulario" value="F3B1" title="Imprime Formulario F3B, Banco, Cheque y Transferencia" 			>Formulario F3B(Itau)	<br>';
				}
				if($Formulario=="F3B2"){
			    	echo '				<input type="radio" name="Formulario" value="F3B2" title="Imprime Formulario F3B, AAA"									checked	>Formulario F3B(AAA)	<br>';
				}else{
			    	echo '				<input type="radio" name="Formulario" value="F3B2" title="Imprime Formulario F3B, AAA"											>Formulario F3B(AAA)	<br>';
				}					
				if($Formulario=="F7"){
			    	echo '				<input type="radio" name="Formulario" value="F7"   title="Imprime Formulario F7, Pago de Facturas"						checked	>Formulario F7		<br>';
				}else{
			    	echo '				<input type="radio" name="Formulario" value="F7"   title="Imprime Formulario F7, Pago de Facturas"								>Formulario F7		<br>';
				}
				echo '			</td>';
				echo '			<td id="CajaOpcDatos" valign="top">';
				if($Iva=="cIva"){
			    	echo '				<input type="radio" name="Iva" value="cIva" checked	>Con Iva<br>';
				}else{
			    	echo '				<input type="radio" name="Iva" value="cIva" 		>Con Iva<br>';
				}
				if($Iva=="sIva"){
			    	echo '				<input type="radio" name="Iva" value="sIva" checked	>Sin Iva<br>';
				}else{
			    	echo '				<input type="radio" name="Iva" value="sIva" 		>Sin Iva<br>';
				}
				echo '			</td>';
				echo '			<td id="CajaOpcDatos" valign="top">';
				$link=Conectarse();
				$bdPr=$link->query("SELECT * FROM Proyectos Order By IdProyecto");
				if ($row=mysqli_fetch_array($bdPr)){
					DO{
						if(isset($IdProyecto)){
							if($IdProyecto==$row['IdProyecto']){
			    				echo '<input type="radio" name="IdProyecto" value="'.$row['IdProyecto'].'" checked>'.$row['IdProyecto'].'<br>';
							}else{
			    				echo '<input type="radio" name="IdProyecto" value="'.$row['IdProyecto'].'">'.$row['IdProyecto'].'<br>';
							}
						}else{
			    			echo '<input type="radio" name="IdProyecto" value="'.$row['IdProyecto'].'">'.$row['IdProyecto'].'<br>';
						}
					}WHILE ($row=mysqli_fetch_array($bdPr));
				}
				$link->close();
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';

				$Txt = "Se debe seleccionar al menos un FORMULARIO y luego puedes ver los DOCUMENTOS que se incluirán en el Informe PDF, clic sobre este botón...";
			   	$newtext = wordwrap($Txt, 60, "<br />\n");
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaOpcDoc">';
				echo '		<tr>';
				echo '			<td>';
            	echo '				<input name="VerDoc" type="image" id="VerDoc" src="imagenes/klipper.png" width="34" height="34" title="Mostrar Documentos" align="middle">';
				//echo '				<strong>Se debe seleccionar al menos un FORMULARIO y luego puedes ver los DOCUMENTOS que se incluirán en el Informe PDF, clic sobre este botón...</strong>';
				echo '				<strong>'.$Txt.'</strong>';
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';
				
				if(isset($_POST['Formulario'])){
				
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width=" 5%"><strong>N°				</strong></td>';
				echo '			<td  width=" 8%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="15%"><strong>Proveedor		</strong></td>';
				echo '			<td  width="10%"><strong>Tip.Doc.		</strong></td>';
				echo '			<td  width=" 7%"><strong>N° Doc.		</strong></td>';
				echo '			<td  width="15%"><strong>Bien o Servicio</strong></td>';
				echo '			<td  width=" 5%"><strong>Neto			</strong></td>';
				echo '			<td  width=" 5%"><strong>IVA			</strong></td>';
				echo '			<td  width=" 5%"><strong>Bruto			</strong></td>';
				echo '			<td  width="10%"><strong>Item			</strong></td>';
				echo '			<td  width="10%"><strong>Proyecto		</strong></td>';
				echo '		</tr>';
				echo '	</table>';

				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$filtroSQL = "Where Estado != 'I'";
				
				if(isset($_POST['IdProyecto'])){
					$filtroSQL .= " && IdProyecto = '".$IdProyecto."'";
				}
				if(isset($_POST['Formulario'])){
					if($_POST['Formulario']=="F3B1"){
						$filtroSQL .= " && IdRecurso <= 3";
					}
					if($_POST['Formulario']=="F3B2"){
						$filtroSQL .= " && IdRecurso = 4";
					}
					if($_POST['Formulario']=="F7"){
						$filtroSQL .= " && IdRecurso = 5";
					}
				}
				if(isset($_POST['Iva'])){
					if($_POST['Iva']=="cIva"){
						$filtroSQL .= " && Iva > 0 && Neto > 0";
					}else{
						$filtroSQL .= " && Iva = 0 && Neto = 0";
					}
				}

				//echo "Filtro ".$filtroSQL;
				
				$tNeto 	= 0;
				$tIva	= 0;
				$tBruto	= 0;
				$link=Conectarse();

				$result  = $link->query("SELECT SUM(Neto) as tNeto, SUM(Iva) as tIva, SUM(Bruto) as tBruto FROM MovGastos WHERE Estado!='I'");  
				//$row   = mysqli_fetch_array($result, MYSQL_ASSOC);
				$row 	 = mysqli_fetch_array($result);
				$tNetos  = $row["tNeto"];
				$tIvas   = $row["tIva"];
				$tBrutos = $row["tBruto"];

				$bdGto=$link->query("SELECT * FROM MovGastos ".$filtroSQL." Order By FechaGasto");
				if ($row=mysqli_fetch_array($bdGto)){
					do{
						$n++;
						$tNeto	+= $row['Neto'];
						$tIva	+= $row['Iva'];
						$tBruto	+= $row['Bruto'];
						echo '<tr>';
						echo '			<td width=" 5%">'.$n.'			</td>';
						$fd 	= explode('-', $row['FechaGasto']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						echo '			<td width=" 8%">'.$Fecha.'		</td>';
						echo '			<td width="15%">'.$row['Proveedor'].'		</td>';
						echo '			<td width="10%">';
						if($row['TpDoc']=="B"){
							echo 'Boleta';
						}else{
							echo 'Factura';
						}
						echo '			</td>';
						echo '			<td width=" 7%">'.$row['nDoc'].'			</td>';
						echo '			<td width="15%">'.$row['Bien_Servicio'].'	</td>';
						echo '			<td width=" 5%">'.number_format($row['Neto'] , 0, ',', '.').'			</td>';
						echo '			<td width=" 5%">'.number_format($row['Iva']	 , 0, ',', '.').'				</td>';
						echo '			<td width=" 5%">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
						$link=Conectarse();
						$bdIt = $link->query("SELECT * FROM ItemsGastos Where nItem = '".$row['nItem']."'");
						if ($rowIt=mysqli_fetch_array($bdIt)){
							$Items = $rowIt['Items'];
						}
						echo '			<td width="10%">'.$Items.'			</td>';
						echo '			<td width="10%">'.$row['IdProyecto'].'			</td>';
						echo '		</tr>';
					}while ($row=mysqli_fetch_array($bdGto));
				}else{
					echo '	<tr>';
					echo '		<td>';
					echo '    No hay documentos para este Formulario...';
					echo '		</td>';
					echo '	</tr>';
				}
				$link->close();
				echo '	</table>';
				}

				if($tBruto > 0){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td width=" 5%">&nbsp;</td>';
					echo '			<td width=" 8%">&nbsp;</td>';
					echo '			<td width="15%">&nbsp;</td>';
					echo '			<td width="10%">&nbsp;</td>';
					echo '			<td width=" 7%">&nbsp;</td>';
					echo '			<td width="15%">Total Página</td>';
					echo '			<td width=" 5%">'.number_format($tNeto , 0, ',', '.').'			</td>';
					echo '			<td width=" 5%">'.number_format($tIva  , 0, ',', '.').'			</td>';
					echo '			<td width=" 5%">'.number_format($tBruto, 0, ',', '.').'			</td>';
    				echo '			<td width="10%">&nbsp;</td>';
    				echo '			<td width="10%">&nbsp;</td>';
					echo '		</tr>';
					echo '	</table>';
				}
				echo '</div>';
			?>

		</div>
		</form>
	</div>
	
		<br>
	<script src="../angular/angular.min.js"></script>
	<script src="../jsboot/bootstrap.min.js"></script>	
	<script src="moduloGastos.js"></script>

</body>
</html>