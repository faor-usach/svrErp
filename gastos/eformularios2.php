<?php
	session_start();
	include_once("conexion.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=mysql_query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysql_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}
		mysql_close($link);
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Emisi&oacute;n de Formularios</title>

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

	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>	

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>	

<script>
	function realizaProceso(Concepto, Formulario, Iva, IdProyecto){
		var parametros = {
			"Concepto" 		: Concepto,
			"Formulario"	: Formulario,
			"Iva" 			: Iva,
			"IdProyecto"	: IdProyecto
		};
		document.form.value.Formulario = Formulario;
		$.ajax({
			data: parametros,
			url: 'verFormularios.php',
			type: 'post',
			beforeSend: function () {
				$("#resultado").html("<div id='cajaRegistraPruebas'><img src='../imagenes/ajax-loader.gif'></div>");
			},
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}
</script>

</head>

<body onLoad="inicioformulario()">
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
				echo '			<td>Concepto o motivo del los Gastos Realizados</td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td>';
				echo '				<input name="Concepto"  		type="text" size="65" maxlength="65" placeholder="Ingrese Concepto..."  value="'.$Concepto.'">';
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
				echo '			<td id="CajaOpcDatos" valign="top">';?>
				
									<input type="radio" name="Formulario" id="Formulario" value="1" 	onClick="realizaProceso($('#Concepto').val(), $('#Formulario').val(), $('#Iva').val(), $('#IdProyecto').val())" title="Imprime Formulario F3B" 					>Formulario F3B(Itau)	<br>
									<input type="radio" name="Formulario" id="Formulario" value="2" 	onClick="realizaProceso($('#Concepto').val(), $('#Formulario').val(), $('#Iva').val(), $('#IdProyecto').val())" title="Imprime Formulario F3B, AAA"				>Formulario F3B(AAA)	<br>
									<input type="radio" name="Formulario" id="Formulario" value="3" 	onClick="realizaProceso($('#Concepto').val(), $('#Formulario').val(), $('#Iva').val(), $('#IdProyecto').val())" title="Imprime Formulario F7, Pago de Facturas"	>Formulario F7			<br>
									<input type="text" name="Formulario">

				<?php 
				echo '			</td>';
				echo '			<td id="CajaOpcDatos" valign="top">';?>
									<input type="radio" id="Iva" name="Iva" value="cIva" onClick="realizaProceso($('#Concepto').val(), $('#Formulario').val(), $('#Iva').val(), $('#IdProyecto').val())"		>Con Iva<br>
									<input type="radio" id="Iva" name="Iva" value="sIva" onClick="realizaProceso($('#Concepto').val(), $('#Formulario').val(), $('#Iva').val(), $('#IdProyecto').val())"		>Sin Iva<br>
									
				<?php
				echo '			</td>';
				echo '			<td id="CajaOpcDatos" valign="top">';
				$link=Conectarse();
				$bdPr=mysql_query("SELECT * FROM Proyectos Order By IdProyecto");
				if ($row=mysql_fetch_array($bdPr)){
					DO{
						if(isset($IdProyecto)){
							if($IdProyecto==$row['IdProyecto']){
			    				echo '<input type="radio" id="IdProyecto" name="IdProyecto" value="'.$row['IdProyecto'].'" checked>'.$row['IdProyecto'].'<br>';
							}else{
			    				echo '<input type="radio" Id="IdProyecto" name="IdProyecto" value="'.$row['IdProyecto'].'">'.$row['IdProyecto'].'<br>';
							}
						}else{
			    			echo '<input type="radio" Id="IdProyecto" name="IdProyecto" value="'.$row['IdProyecto'].'">'.$row['IdProyecto'].'<br>';
						}
					}WHILE ($row=mysql_fetch_array($bdPr));
				}
				mysql_close($link);
				echo '			</td>';
				echo '		</tr>';
				echo '	</table>';

			   	$newtext = wordwrap($Txt, 60, "<br />\n");
				echo '<span id="resultado"></span>';
				
			?>

		</div>
		</form>
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