<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr 	= "";	
	$TpDoc 		= "B";
	$Proceso 	= "1";
	$nGasto 	= 0;
	$tNetos		= 0;
	$IdAutoriza = '';
	$Concepto	= '';
	$NetoF		= 0;
	$IvaF		= 0;
	$nInforme	= '';
	$exento 	= 'off';
	$efectivo 	= 'off';
	$CalCosto		= 0;
	$CalCalidad		= 0;
	$CalPreVenta	= 0;
    $CalPostVenta	= 0;

    $nInforme = '';
    if(isset($_GET['nInforme'])){
        $nInforme = $_GET['nInforme'];
    }
	
	if(isset($_POST['exento'])){ $exento	= $_POST['exento']; }
	if($exento != 'on'){
		$exento 	= 'off';
	}
	if(isset($_POST['efectivo'])){ $efectivo	= $_POST['efectivo']; }
	if($efectivo != 'on'){
		$efectivo 	= 'off';
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

	$Proveedor 		= "";
	$nDoc			= "";
	$Bien_Servicio	= "";
	$exento			= 'off';
	$efectivo		= 'off';
	$Neto			= "";
	$Iva			= "";
	$Bruto			= "";
	$FechaGasto    	= date('Y-m-d');
	$Hora			= date("H:i:s");
	$Items 			= "";
	$TpGasto 		= "";
	$Recurso 		= "";
	$IdProyecto 	= "";
	$IdAutoriza		= "";
	$Guardado		= '';
	
	if(isset($_GET['Proceso'])) 	{ $Proceso   = $_GET['Proceso']; 	}
	if(isset($_GET['nGasto']))  	{ $nGasto 	 = $_GET['nGasto']; 	}
	if(isset($_GET['nInforme']))   	{ $nInforme	 = $_GET['nInforme']; 	}
	if(isset($_GET['TpDoc']))   	{ $TpDoc	 = $_GET['TpDoc']; 		}

	if(isset($_POST['Proceso'])) 	{ $Proceso   = $_POST['Proceso']; 	}
	if(isset($_POST['nGasto']))  	{ $nGasto 	 = $_POST['nGasto']; 	}
	if(isset($_POST['nInforme']))  	{ $nInforme	 = $_POST['nInforme']; 	}
	if(isset($_POST['Concepto']))  	{ $Concepto	 = $_POST['Concepto']; 	}

	
	$sw = false;
	if(isset($_POST['Borrar'])){
		if(isset($_POST['TpDoc'])){ 
			if($_POST['TpDoc'] == 'P'){ 
				$link=Conectarse();
				$bdGas=$link->query("DELETE FROM Facturas WHERE nMov = '".$nGasto."'");
				$link->close();
				header("Location: igastos.php");
			}else{
				$link=Conectarse();
				$bdGas=$link->query("DELETE FROM MovGastos WHERE nGasto = '".$nGasto."'");
				$link->close();
				header("Location: igastos.php");
			}
		};
	}
	if(isset($_POST['Grabar'])){
		$CalCosto		= 0;
		$CalCalidad		= 0;
		$CalPreVenta	= 0;
		$CalPostVenta	= 0;
		if(isset($_POST['CalCosto']))		{ $CalCosto 	  	= $_POST['CalCosto']; 	 	}
		if(isset($_POST['CalCalidad']))		{ $CalCalidad 	  	= $_POST['CalCalidad']; 	}
		if(isset($_POST['CalPreVenta']))	{ $CalPreVenta 	  	= $_POST['CalPreVenta']; 	}
		if(isset($_POST['CalPostVenta']))	{ $CalPostVenta 	= $_POST['CalPostVenta']; 	}
		$TpDoc 		= $_POST['TpDoc'];
		if(isset($_POST['Proveedor']))		{ $Proveedor 	  	= $_POST['Proveedor']; 	 	}
		if(isset($_POST['nDoc']))			{ $nDoc 		  	= $_POST['nDoc']; 	  	 	}
		if(isset($_POST['nFactura']))		{ $nFactura 		= $_POST['nFactura']; 	  	}
		if(isset($_POST['FechaFactura']))	{ $FechaFactura	  	= $_POST['FechaFactura'];  	}
		if(isset($_POST['FechaGasto']))		{ $FechaGasto 	  	= $_POST['FechaGasto']; $Hora = $_POST['Hora']; }
		if(isset($_POST['Bien_Servicio']))	{ $Bien_Servicio 	= $_POST['Bien_Servicio'];	}
		if(isset($_POST['Descripcion']))	{ $Descripcion 		= $_POST['Descripcion'];	}
		if(isset($_POST['IdAutoriza']))		{ $IdAutoriza 		= $_POST['IdAutoriza'];		}
		if(isset($_POST['IdProyecto']))		{ $IdProyecto 		= $_POST['IdProyecto'];		}
		if(isset($_POST['Bruto']))			{ $Bruto 		  	= $_POST['Bruto']; 		 	}
		if(isset($_POST['TpCosto']))		{ $TpCosto 			= $_POST['TpCosto'];		}
		
		$link=Conectarse();
		$bdPro = $link->query("SELECT * FROM Proveedores Where Proveedor = '".$Proveedor."'");
		if($rowPro=mysqli_fetch_array($bdPro)){
			$RutProv = $rowPro['RutProv'];
		}
		if($_POST['TpDoc']=="P"){
			$fdFf = explode('-', $FechaFactura);
			$PeriodoPago 	= $fdFf[1].'.'.$fdFf[0];
			$IdRecurso		= '5';
			$nMov 			= $nGasto;
			
			if($nGasto == 0){
				$bdFa = $link->query('SELECT * FROM Facturas Order By nMov Desc');
				if($rowFa=mysqli_fetch_array($bdFa)){
					$nMov = $rowFa['nMov'] + 1;
				}
			}
			$nGasto = $nMov;
			$bdFac=$link->query("SELECT * FROM Facturas WHERE nMov = '".$nMov."'");
			if($rowFac=mysqli_fetch_array($bdFac)){
				$nInforme = $rowFac['nInforme'];
				$actSQL="UPDATE Facturas SET ";
				$actSQL.="nMov	    	='".$nMov.			"',";
				$actSQL.="PeriodoPago   ='".$PeriodoPago.	"',";
				$actSQL.="RutProv	    ='".$RutProv.		"',";
				$actSQL.="nFactura	    ='".$nFactura.		"',";
				$actSQL.="FechaFactura 	='".$FechaFactura.	"',";
				$actSQL.="IdProyecto	='".$IdProyecto.	"',";
				$actSQL.="IdRecurso		='".$IdRecurso.		"',";
				$actSQL.="IdAutoriza	='".$IdAutoriza.	"',";
				$actSQL.="Descripcion	='".$Descripcion.	"',";
				$actSQL.="Bruto		    ='".$Bruto.			"',";
				$actSQL.="TpCosto	    ='".$TpCosto.		"',";
				$actSQL.="CalCosto		='".$CalCosto.		"',";
				$actSQL.="CalCalidad	='".$CalCalidad.	"',";
				$actSQL.="CalPreVenta	='".$CalPreVenta.	"',";
				$actSQL.="CalPostVenta	='".$CalPostVenta.	"'";
				$actSQL.="WHERE nMov  	= '".$nMov."'";
				$bdGto=$link->query($actSQL);
				$Guardado = 'Si';
			}else{
				$link->query("insert into Facturas	(	nMov			,
														PeriodoPago		,
														RutProv			,
														nFactura		,
														FechaFactura	,
														Descripcion		,
														Bruto			,
														IdProyecto		,
														IdRecurso		,
														IdAutoriza		,
														TpCosto			,
														CalCosto		,
														CalCalidad		,
														CalPreVenta		,
														CalPostVenta
													) 
										values 		(	'$nMov'			,
														'$PeriodoPago'	,
														'$RutProv'		,
														'$nFactura'		,
														'$FechaFactura'	,
														'$Descripcion'	,
														'$Bruto'		,
														'$IdProyecto'	,
														'$IdRecurso'	,
														'$IdAutoriza'	,
														'$TpCosto'		,
														'$CalCosto'		,
														'$CalCalidad'	,
														'$CalPreVenta'	,
														'$CalPostVenta'
														)");
				$Guardado = 'Si';
			}
		}else{
			if($_POST['TpDoc']=="F"){
				if(isset($_POST['exento']))			{ $exento 		  = $_POST['exento'];			}
				if(isset($_POST['Neto'])){
					$Neto 	= $_POST['Neto'];
					$Iva   	= 0;
					$Bruto 	= $Neto;
					if($exento == 'off'){
						$Iva	= intval(round(($Neto * 0.19)));
						$Bruto	= $Neto + $Iva;
					}
				}
			}
			if(isset($_POST['efectivo']))		{ $efectivo 	  = $_POST['efectivo']; 	 }
			if(isset($_POST['Items']))			{ $Items 		  = $_POST['Items']; 		 }
			if(isset($_POST['TpGasto']))		{ $TpGasto 		  = $_POST['TpGasto']; 		 }
			if(isset($_POST['Recurso']))		{ $Recurso 		  = $_POST['Recurso']; 		 }
			if(isset($_POST['IdProyecto']))		{ $IdProyecto 	  = $_POST['IdProyecto']; 	 }
			if(isset($_POST['IdAutoriza']))		{ $IdAutoriza 	  = $_POST['IdAutoriza']; 	 }

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

			$bdGto=$link->query("SELECT * FROM MovGastos WHERE nGasto = '".$nGasto."'");
			if ($rowGto=mysqli_fetch_array($bdGto)){
				$nInforme = $rowGto ['nInforme'];
				$actSQL="UPDATE MovGastos SET ";
				$actSQL.="Proveedor	    ='".$Proveedor.		"',";
				$actSQL.="nDoc	    	='".$nDoc.			"',";
				$actSQL.="FechaGasto   	='".$FechaGasto.	"',";
				$actSQL.="Hora   		='".$Hora.			"',";
				$actSQL.="Bien_Servicio	='".$Bien_Servicio.	"',";
				$actSQL.="exento	    ='".$exento.		"',";
				$actSQL.="efectivo	    ='".$efectivo.		"',";
				$actSQL.="Neto		    ='".$Neto.			"',";
				$actSQL.="Iva		    ='".$Iva.			"',";
				$actSQL.="Bruto		    ='".$Bruto.			"',";
				$actSQL.="nItem		    ='".$nItem.			"',";
				$actSQL.="IdGasto	    ='".$IdGasto.		"',";
				$actSQL.="IdRecurso		='".$IdRecurso.		"',";
				$actSQL.="IdProyecto	='".$IdProyecto.	"',";
				$actSQL.="IdAutoriza	='".$IdAutoriza.	"',";
				$actSQL.="CalCosto		='".$CalCosto.		"',";
				$actSQL.="CalCalidad	='".$CalCalidad.	"',";
				$actSQL.="CalPreVenta	='".$CalPreVenta.	"',";
				$actSQL.="CalPostVenta	='".$CalPostVenta.	"'";
				$actSQL.="WHERE nGasto  = '".$nGasto."'";
				$bdGto=$link->query($actSQL);
				$Guardado = 'Si';
			}else{
				$bdGt = $link->query('SELECT * FROM MovGastos Order By nGasto Desc');
				if($rowGt=mysqli_fetch_array($bdGt)){
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
														efectivo,
														Neto,
														Iva,
														Bruto,
														nItem,
														IdGasto,
														IdRecurso,
														IdProyecto,
														IdAutoriza,
														CalCosto,
														CalCalidad,
														CalPreVenta,
														CalPostVenta) 
										values 		(	'$nGasto',
														'$Modulo',
														'$FechaGasto',
														'$Hora',
														'$TpDoc',
														'$Proveedor',
														'$nDoc',
														'$Bien_Servicio',
														'$exento',
														'$efectivo',
														'$Neto',
														'$Iva',
														'$Bruto',
														'$nItem',
														'$IdGasto',
														'$IdRecurso',
														'$IdProyecto',
														'$IdAutoriza',
														'$CalCosto',
														'$CalCalidad',
														'$CalPreVenta',
														'$CalPostVenta'
														)");
				$Guardado = 'Si';
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
		$link->close();
		if($sw==false){
   			$MsgUsr = 'Error de Ingreso: Debe ingresar todos los campos ...';
		}
	}
	

	if($nGasto){
		if($TpDoc == 'P'){
			$link=Conectarse();
			$bdGas=$link->query("SELECT * FROM Facturas WHERE nMov = '".$nGasto."'");
			if ($row=mysqli_fetch_array($bdGas)){
				$TpDoc			= 'P';
			}
			$link->close();
		}else{
			$link=Conectarse();
			$bdGas=$link->query("SELECT * FROM MovGastos WHERE nGasto = '".$nGasto."'");
			if ($row=mysqli_fetch_array($bdGas)){
				$TpDoc			= $row['TpDoc'];
			}
			$link->close();
		}
		if(isset($_GET['Proceso']) == 3){
			$MsgUsr = "Se eliminara Registro...";
		}
	}

if($Guardado == 'Si'){
	//header("Location: igastos.php");
	header("Location: registragastos.php");
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

	<script type="text/javascript" src="../angular/angular.js"></script>

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
	function regDoc(TpDoc, nGasto, nInforme, Proceso){
		var parametros = {
			"TpDoc" 	: TpDoc,
			"nGasto" 	: nGasto,
			"nInforme" 	: nInforme,
			"Proceso" 	: Proceso
		};
		//alert(nGasto);
		$.ajax({
			data: parametros,
			url: 'registraMovimientoAdd.php',
			type: 'get',
			success: function (response) {
				$("#resultado").html(response);
			}
		});
	}

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

<body ng-app="myApp" ng-controller="TodoCtrl">
	<?php include('head.php'); ?>
	<div id="linea"></div>
	<div id="Cuerpo">
		<form name="form" action="registragastosAdd.php" method="post">
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<?php 
					$nomModulo = 'Registra Gastos SOLICITUD '.$nInforme;
					include('menuIconos.php'); 
				?>
			</div>
			<?php include('barraOpciones.php'); ?>
			
			<!-- Fin Caja Cuerpo -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">
					<tr>
						<td>
							<span style="font-size:20px;">Registro de Gastos</span>
								<div id="ImagenBarra">
									<?php if($Proceso == 1 || $Proceso == 2){?>
										<button name="Grabar" id="Grabar">
											<img src="imagenes/save_32.png" width="28" height="28" title="Guardar Gastos">
										</button>
									<?php }else{ ?>
										<button name="Borrar" id="Borrar">
											<img src="imagenes/inspektion.png" width="28" height="28" title="Borrar">
										</button>
									<?php } ?>
								</div>
						</td>
					</tr>
				</table>
				<div id="CajaListadoGastos">
                    <?php //echo $TpDoc; ?>
					<?php if($TpDoc==""){?>
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" onclick='regDoc("B",0,<?php echo $nInforme; ?>, 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" onclick='regDoc("F",0,<?php echo $nInforme; ?>, 1)'>Factura
					<?php } ?>
					<?php if($TpDoc=="B"){?>
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" checked onclick='regDoc("B",0,<?php echo $nInforme; ?>, 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" onclick='regDoc("F",0,<?php echo $nInforme; ?>, 1)'>Factura
					<?php } ?>
					<?php if($TpDoc=="F"){?>
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" onclick='regDoc("B",0, , 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" checked onclick='regDoc("F",0, , 1)'checked>Factura
					<?php } ?>
					<?php if($TpDoc=="P"){?>
							<input name="TpDoc" id="dBoleta"  type="radio" value="B" onclick='regDoc("B",0, , 1)'>Boleta
							<input name="TpDoc" id="dFactura" type="radio" value="F" onclick='regDoc("F",0, , 1)'checked>Factura
							<input name="TpDoc" id="pFactura" type="radio" value="P" checked onclick='regDoc("P",0, , 1)'>Factura Pagos
					<?php } ?>
				</div>
				<?php
					if($TpDoc){?>
						<script>
							regDoc("<?php echo $TpDoc; ?>","<?php echo $nGasto; ?>",<?php echo $nInforme; ?>, 1);
						</script>
						<?php
					}
				?>
				<div id="resultado"></div>
		</form>
	</div>
	<div style="clear:both; "></div>
	<br>

    <script>
	    var app = angular.module('myApp', []);
	    app.controller('TodoCtrl', function($scope, $http) {
		    $scope.total = function(){
		        if($scope.Cantidad > 0 && $scope.valorUnitario > 0){
		            $scope.valorTotal = $scope.Cantidad * $scope.valorUnitario;
		            return $scope.valorTotal;
		        }
		    };
	    });
    </script>


</body>
</html>