<?php
	$Excepcion 	= 'off';
	$Contactos	= '';
	if(isset($_GET['Proceso']) == 4){ 

		$nItems 			= 0;
		$valorUnitarioUF 	= 0;
		$Departamento 		= '';
		$Contacto			= '';
		$Proyecto 			= '';
		$nOrden				= '';
		
		if(isset($_GET['nSolicitud'])) 	{ $nSolicitud   = $_GET['nSolicitud']; 	}
		if(isset($_GET['nItems'])) 		{ $nItems   	= $_GET['nItems']; 		}
					
		$link=Conectarse();
		$bdDet=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
		if($rowDet=mysqli_fetch_array($bdDet)){
			$bdDet=$link->query("DELETE FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
		}
		$link->close();
	}

	$Mes = array(
					'Enero', 
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				);

	$RutCli 		= "";
	$Cliente 		= "";
	$Giro 			= "";
	$Direccion		= "";
	$Telefono		= "";
	$Celular		= "";
	$Contacto		= "";
	$Atencion		= '';
	$Email			= "";
	$correosFactura	= '';
	$nSolicitud		= "";
	$nItems			= 1;
	$tipoValor		= 'U';
	$Exenta			= "";
	$fechaSolicitud	= date('Y-m-d');
	$CAM			= 0;
	$RAM			= 0;
	$Proceso 		= '';
	
	$valorUnitarioUF 	= 0;
	$valorTotalUF 		= 0;
	$Redondear 			= 0;
	$Fotocopia 			= '';
	$Factura 			= 0;
	$fechaFactura 		= date('Y-m-d');
	$pagoFactura 		= '';
	$fechaPago 			= date('Y-m-d');
	$Especificacion 	= '';
	$fechaFotocopia 	= '0000-00-00';
	$FechaOrden 		= '0000-00-00';
	$ivaUF 				= 0;
	$brutoUF 			= 0;
	$Iva 				= 0;
	$Bruto 				= 0;
	$informesAM 		= '';
	$cotizacionesCAM 	= '';
	$Observa 			= '';
	$enviarFactura 		= '';
	$valorUnitario 		= 0;
	$valorTotal 		= 0;
	
	$Proceso = 1;
	if(isset($_GET['Proceso']) == 4){ 
		$Proceso = 2;
	}else{
		if(isset($_GET['Proceso'])) 	{ $Proceso  	= $_GET['Proceso']; 	}
	}
	
	if(isset($_GET['RutCli']))			{ $RutCli   	= $_GET['RutCli']; 		}
	if(isset($_GET['Contacto']))		{ $Contacto  	= $_GET['Contacto']; 	}
	if(isset($_GET['nSolicitud'])) 		{ $nSolicitud   = $_GET['nSolicitud']; 	}
	if(isset($_GET['CAM']))  			{ $CAM   		= $_GET['CAM']; 		}

	if(isset($_POST['Proceso'])) 	 	{ $Proceso  	 	= $_POST['Proceso']; 		}
	if(isset($_POST['RutCli']))  	 	{ $RutCli   	 	= $_POST['RutCli']; 		}
	if(isset($_POST['Contacto']))	 	{ $Contacto  	 	= $_POST['Contacto']; 		}
	if(isset($_POST['nSolicitud'])) 	{ $nSolicitud   	= $_POST['nSolicitud']; 	}
	if(isset($_POST['CAM']))  		 	{ $CAM   		 	= $_POST['CAM']; 			}
	if(isset($_POST['fechaSolicitud']))	{ $fechaSolicitud 	= $_POST['fechaSolicitud']; }

	if($RutCli){
		$link=Conectarse();
		$bdProv=$link->query("SELECT * FROM clientes WHERE RutCli = '".$RutCli."'");
		if($row=mysqli_fetch_array($bdProv)){
   			$Cliente 		= $row['Cliente'];
			$Giro			= $row['Giro'];
			$Direccion		= $row['Direccion'];
   			$Telefono  		= $row['Telefono'];
   			$Celular  		= $row['Celular'];
			$Email 			= $row['Email'];
			$Sitio 			= $row['Sitio'];
			$Publicar		= $row['Publicar'];
		}
		$link->close();
	}
	
		//echo 'CAM '.$_POST['CAM'];
	if(isset($_GET['accionCAM'])){
		if($_GET['accionCAM']=="Quitar"){
			$Facturacion 		= '';
			$fechaFacturacion	= '0000-00-00';
			$nSolicitudCero			= 0;
			$link=Conectarse();
			$fechaFacturacion = date('Y-m-d');
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="nSolicitud		='".$nSolicitudCero.	"',";
			$actSQL.="Facturacion		='".$Facturacion."'";
			$actSQL.="WHERE CAM		= '".$_GET['CAM']."'";
			$bddSol=$link->query($actSQL);

			$cotizacionesCAM 	= '';
			$informesAM			= '';
			$bdSol=$link->query("SELECT * FROM Cotizaciones WHERE nSolicitud = '".$nSolicitud."'");
			while($rowSol=mysqli_fetch_array($bdSol)){
				if(!$cotizacionesCAM){
					$cotizacionesCAM 	= $rowSol['CAM'];
					$informesAM			= $rowSol['RAM'];
				}else{
					$cotizacionesCAM 	.= '-'.$rowSol['CAM'];
					$informesAM			.= '-'.$rowSol['RAM'];
				}
			}
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="informesAM		='".$informesAM.		"',";
			$actSQL.="cotizacionesCAM	='".$cotizacionesCAM.	"'";
			$actSQL.="WHERE nSolicitud	= '".$nSolicitud."'";
			$bddSol=$link->query($actSQL);
			$link->close();
		}
		if($_GET['accionCAM']=="Agregar"){
			$Facturacion = 'on';
			$link=Conectarse();
			$fechaFacturacion = date('Y-m-d');
			$actSQL="UPDATE Cotizaciones SET ";
			$actSQL.="fechaFacturacion	='".$fechaFacturacion.	"',";
			$actSQL.="nSolicitud		='".$nSolicitud.		"',";
			$actSQL.="Facturacion		='".$Facturacion."'";
			$actSQL.="WHERE CAM		= '".$_GET['CAM']."'";
			$bddSol=$link->query($actSQL);

			$cotizacionesCAM 	= '';
			$informesAM			= '';
			$bdSol=$link->query("SELECT * FROM Cotizaciones WHERE nSolicitud = '".$nSolicitud."'");
			while($rowSol=mysqli_fetch_array($bdSol)){
				if(!$cotizacionesCAM){
					$cotizacionesCAM 	= $rowSol['CAM'];
					$informesAM			= $rowSol['RAM'];
				}else{
					$cotizacionesCAM 	.= '-'.$rowSol['CAM'];
					$informesAM			.= '-'.$rowSol['RAM'];
				}
			}
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="informesAM		='".$informesAM.		"',";
			$actSQL.="cotizacionesCAM	='".$cotizacionesCAM.	"'";
			$actSQL.="WHERE nSolicitud	= '".$nSolicitud."'";
			$bddSol=$link->query($actSQL);

			$link->close();
/*			
			if($nSolicitud){
				$link=Conectarse();
				$bdSol=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."'");
				if($rowSol=mysqli_fetch_array($bdSol)){
					if($rowSol['cotizacionesCAM']){
						$cotizacionesCAM = $rowSol['cotizacionesCAM'].'-'.$CAM;
					}else{
						$cotizacionesCAM = $CAM;
					}
					$bdCAM=$link->query("SELECT * FROM Cotizaciones WHERE CAM = '".$CAM."'");
					if($rowCAM=mysqli_fetch_array($bdCAM)){
						$RAM = $rowCAM['RAM'];
					}
					if($rowSol['informesAM']){
						$informesAM = $rowSol['informesAM'].'-'.$RAM;
					}else{
						$informesAM = $RAM;
					}
					$actSQL="UPDATE SolFactura SET ";
					$actSQL.="informesAM		='".$informesAM.		"',";
					$actSQL.="cotizacionesCAM	='".$cotizacionesCAM.	"'";
					$actSQL.="WHERE nSolicitud	= '".$nSolicitud."'";
					$bddSol=$link->query($actSQL);
				}
				$link->close();
			}
*/			
		}
	}	

	if(isset($_POST['GuardarFacturacion'])){
		$nSolicitud = 0;		
		if(isset($_POST['nSolicitud']))	{ $nSolicitud 	= $_POST['nSolicitud']; }
		$link=Conectarse();
		if($nSolicitud == 0){
			$bdPr=$link->query("SELECT * FROM tablaRegForm");
				if ($row=mysqli_fetch_array($bdPr)){
					$nSolicitud = $row['nSolFactura'] + 1;
				}
		}
		$Contacto  = '';
		$Contacto2 = '';
		$Contacto3 = '';
		$Contacto4 = '';
		$link->close();
		if(isset($_POST['fechaSolicitud']))			{ $fechaSolicitud 		= $_POST['fechaSolicitud']; 		}
		if(isset($_POST['Proyecto']))				{ $Proyecto 			= $_POST['Proyecto']; 				}
		if(isset($_POST['vencimientoSolicitud']))	{ $vencimientoSolicitud = $_POST['vencimientoSolicitud']; 	}
		if(isset($_POST['valorUF']))				{ $valorUF 				= $_POST['valorUF']; 				}
		if(isset($_POST['fechaUF']))				{ $fechaUF 				= $_POST['fechaUF']; 				}
		if(isset($_POST['nOrden']))					{ $nOrden 				= $_POST['nOrden']; 				}
		if(isset($_POST['Fotocopia']))				{ $Fotocopia 			= $_POST['Fotocopia']; 				}
		if(isset($_POST['fechaFotocopia']))			{ $fechaFotocopia 		= $_POST['fechaFotocopia']; 		}
		if(isset($_POST['Factura']))				{ $Factura 				= $_POST['Factura']; 				}
		if(isset($_POST['fechaFactura']))			{ $fechaFactura 		= $_POST['fechaFactura']; 			}
		if(isset($_POST['pagoFactura']))			{ $pagoFactura 			= $_POST['pagoFactura']; 			}
		if(isset($_POST['fechaPago']))				{ $fechaPago 			= $_POST['fechaPago']; 				}
		if(isset($_POST['enviarFactura']))			{ $enviarFactura		= $_POST['enviarFactura']; 			}
		if(isset($_POST['informesAM']))				{ $informesAM			= $_POST['informesAM']; 			}
		if(isset($_POST['cotizacionesCAM']))		{ $cotizacionesCAM		= $_POST['cotizacionesCAM']; 		}
		if(isset($_POST['Neto']))					{ $Neto					= $_POST['Neto']; 					}
		if(isset($_POST['Iva']))					{ $Iva					= $_POST['Iva']; 					}
		if(isset($_POST['Bruto']))					{ $Bruto				= $_POST['Bruto']; 					}
		if(isset($_POST['Observa']))				{ $Observa				= $_POST['Observa']; 				}
		if(isset($_POST['Contacto']))				{ $Contacto				= $_POST['Contacto']; 				}
		if(isset($_POST['Contacto2']))				{ $Contacto2			= $_POST['Contacto2']; 				}
		if(isset($_POST['Contacto3']))				{ $Contacto3			= $_POST['Contacto3']; 				}
		if(isset($_POST['Contacto4']))				{ $Contacto4			= $_POST['Contacto4']; 				}
		if(isset($_POST['Contactos']))				{ $Contactos			= $_POST['Contactos']; 				}
		if(isset($_POST['Exenta']))					{ $Exenta				= $_POST['Exenta']; 				}

		if(isset($_POST['nItems']))					{ $nItems				= $_POST['nItems']; 				}
		if(isset($_POST['Cantidad']))				{ $Cantidad				= $_POST['Cantidad']; 				}
		if(isset($_POST['Especificacion']))			{ $Especificacion		= $_POST['Especificacion']; 		}
		if(isset($_POST['Excepcion']))				{ $Excepcion			= $_POST['Excepcion']; 				}
		if(isset($_POST['Email']))					{ $correosFactura		= $_POST['Email']; 					}
		if(isset($_POST['valorUnitario']))			{ $valorUnitario		= $_POST['valorUnitario']; 			}
		if(isset($_POST['valorTotal']))				{ $valorTotal			= $_POST['valorTotal']; 			}
		
		if(isset($_POST['tipoValor']))				{ $tipoValor 			= $_POST['tipoValor']; 				}
		if(isset($_POST['valorUnitarioUF']))		{ $valorUnitarioUF		= $_POST['valorUnitarioUF']; 			}
		if(isset($_POST['valorTotalUF']))			{ $valorTotalUF			= $_POST['valorTotalUF']; 
		if(isset($_POST['netoUF']))					{ $netoUF				= $_POST['netoUF']; 				}
		if(isset($_POST['ivaUF']))					{ $ivaUF				= $_POST['ivaUF']; 					}
		if(isset($_POST['brutoUF']))				{ $brutoUF				= $_POST['brutoUF']; 				}
					}
		if(isset($_POST['Redondear']))				{ $Redondear			= $_POST['Redondear']; 			}

		$link=Conectarse();
		if($Especificacion){
			if($Excepcion != 'on'){
				if($tipoValor=='U'){
					$valorTotalUF 	= $Cantidad * $valorUnitarioUF;
				}else{
					$valorTotal 	= $Cantidad * $valorUnitario;
				}
			}
			$bddSol=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."' && nItems = '".$nItems."'");
			if ($rowdSol=mysqli_fetch_array($bddSol)){
				$actSQL="UPDATE detSolFact SET ";
				$actSQL.="Cantidad		 	='".$Cantidad."',";
				$actSQL.="RutCli 			='".$RutCli."',";
				$actSQL.="Especificacion 	='".$Especificacion."',";
				$actSQL.="valorUnitarioUF  	='".$valorUnitarioUF."',";
				$actSQL.="valorTotalUF     	='".$valorTotalUF."'";
				$actSQL.="valorUnitario  	='".$valorUnitario."',";
				$actSQL.="valorTotal     	='".$valorTotal."'";
				$actSQL.="WHERE nSolicitud	= '".$nSolicitud."' && nItems = '".$nItems."'";
				$bddSol=$link->query($actSQL);
			}else{
				$link->query("insert into detSolFact(	nSolicitud,
														nItems,
														RutCli,
														Cantidad,
														Especificacion,
														valorUnitario,
														valorTotal,
														valorUnitarioUF,
														valorTotalUF
													) 
											values 	(	'$nSolicitud',
														'$nItems',
														'$RutCli',
														'$Cantidad',
														'$Especificacion',
														'$valorUnitario',
														'$valorTotal',
														'$valorUnitarioUF',
														'$valorTotalUF'
				)");
			}
		}		
		$Neto   = 0;
		$netoUF = 0;
		$bddSol=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
		if ($rowdSol=mysqli_fetch_array($bddSol)){
			do{
				if($tipoValor=='U'){
					$Neto		= 0;
					$Iva		= 0;
					$Bruto		= 0;
					if($Exenta=='on'){
						$netoUF  	+= $rowdSol['valorTotalUF'];
						$ivaUF		 = 0;
						$brutoUF 	= $netoUF;
					}else{
						$netoUF  	+= $rowdSol['valorTotalUF'];
						$ivaUF		 = $netoUF * 0.19;
						$brutoUF	 = $netoUF * 1.19;
						if($Redondear=='on'){
							$ivaUF		= round(($netoUF * 0.19),0);
							$brutoUF	= round(($netoUF * 1.19),0);
						}
					}
				}else{
					$netoUF		= 0;
					$ivaUF		= 0;
					$brutoUF	= 0;

					if($Exenta=='on'){
						$Neto  += $rowdSol['valorTotal'];
						$Iva	= 0;
						$Bruto = $Neto;
					}else{
						$Neto  += $rowdSol['valorTotal'];
						$Iva	= intval($Neto * 0.19);
						$Bruto	= intval($Neto * 1.19);
						if($Redondear=='on'){
							$Iva	= round(($Neto * 0.19),0);
							$Bruto	= round(($Neto * 1.19),0);
						}
					}
				}
			}while ($rowdSol=mysqli_fetch_array($bddSol));
		}
		if($Excepcion == 'on'){
			if(isset($_POST['Neto']))					{ $Neto					= $_POST['Neto']; 					}
			if(isset($_POST['Iva']))					{ $Iva					= $_POST['Iva']; 					}
			if(isset($_POST['Bruto']))					{ $Bruto				= $_POST['Bruto']; 					}
		}
		$bdProv=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."' && RutCli = '".$RutCli."'");
		if ($row=mysqli_fetch_array($bdProv)){
			if($valorUF > 0){
				$actSQL="UPDATE tablaRegForm SET ";
				$actSQL.="valorUFRef	='".$valorUF."'";
				$bd=$link->query($actSQL);
			}
			if($Contacto)  { $Contactos = $Contacto; 		}
			if($Contacto2) { $Contactos .= ','.$Contacto2; 	}
			if($Contacto3) { $Contactos .= ','.$Contacto3; 	}
			if($Contacto4) { $Contactos .= ','.$Contacto4; 	}
			$actSQL="UPDATE SolFactura SET ";
			$actSQL.="fechaSolicitud		='".$fechaSolicitud.		"',";
			$actSQL.="IdProyecto			='".$Proyecto.				"',";
			$actSQL.="Contacto				='".$Contacto.				"',";
			$actSQL.="Atencion				='".$Contactos.				"',";
			$actSQL.="correosFactura		='".$correosFactura.		"',";
			$actSQL.="vencimientoSolicitud 	='".$vencimientoSolicitud.	"',";
			$actSQL.="valorUF 				='".$valorUF.				"',";
			$actSQL.="fechaUF 				='".$fechaUF.				"',";
			$actSQL.="nOrden				='".$nOrden.				"',";
			$actSQL.="Fotocopia				='".$Fotocopia.				"',";
			if($Fotocopia=='on'){
				$actSQL.="fechaFotocopia	='".$fechaFotocopia.		"',";
			}else{
				$fechaFotocopia = "0000-00-00";
				$actSQL.="fechaFotocopia	='".$fechaFotocopia.		"',";
			}
			$actSQL.="tipoValor				= '".$tipoValor.			"',";
			$actSQL.="Exenta				= '".$Exenta.				"',";
			$actSQL.="Factura				= '".$Factura.				"',";
			$actSQL.="fechaFactura	    	= '".$fechaFactura.			"',";
			$actSQL.="pagoFactura	    	= '".$pagoFactura.			"',";
			$actSQL.="fechaPago				= '".$fechaPago.			"',";
			$actSQL.="enviarFactura			= '".$enviarFactura.		"',";
			$actSQL.="informesAM	    	= '".$informesAM.			"',";
			$actSQL.="cotizacionesCAM		= '".$cotizacionesCAM.		"',";
			$actSQL.="Observa				= '".$Observa.				"',";
			$actSQL.="Redondear				= '".$Redondear.			"',";
			$actSQL.="Excepcion				= '".$Excepcion.			"',";
			$actSQL.="Neto					= '".$Neto.					"',";
			$actSQL.="Iva	    			= '".$Iva.					"',";
			$actSQL.="Bruto					= '".$Bruto.				"',";
			$actSQL.="netoUF				= '".$netoUF.				"',";
			$actSQL.="ivaUF	    			= '".$ivaUF.				"',";
			$actSQL.="brutoUF				= '".$brutoUF.				"'";
			$actSQL.="WHERE nSolicitud		= '".$nSolicitud."' && RutCli = '".$RutCli."'";
			$bdProv=$link->query($actSQL);
		}else{
				$bdTab=$link->query("SELECT * FROM tablaRegForm");
				if ($row=mysqli_fetch_array($bdTab)){
					$actSQL="UPDATE tablaRegForm SET ";
					$actSQL.="nSolFactura	='".$nSolicitud."'";
					$bdTab=$link->query($actSQL);
				}
				if($Contacto)  { $Contactos = $Contacto; 		}
				if($Contacto2) { $Contactos .= ','.$Contacto2; 	}
				if($Contacto3) { $Contactos .= ','.$Contacto3; 	}
				if($Contacto4) { $Contactos .= ','.$Contacto4; 	}
				$link->query("insert into SolFactura(	nSolicitud,
														RutCli,
														fechaSolicitud,
														IdProyecto,
														Contacto,
														Atencion,
														correosFactura,
														Fotocopia,
														fechaFotocopia,
														nOrden,
														FechaOrden,
														Factura,
														fechaFactura,
														pagoFactura,
														fechaPago,
														vencimientoSolicitud,
														valorUF,
														fechaUF,
														tipoValor,
														Exenta,
														netoUF,
														ivaUF,
														brutoUF,
														Neto,
														Iva,
														Bruto,
														informesAM,
														cotizacionesCAM,
														Observa,
														Redondear,
														Excepcion,
														enviarFactura
														) 
										values 		(	'$nSolicitud',
														'$RutCli',
														'$fechaSolicitud',
														'$Proyecto',
														'$Contacto',
														'$Contactos',
														'$Email',
														'$Fotocopia',
														'$fechaFotocopia',
														'$nOrden',
														'$FechaOrden',
														'$Factura',
														'$fechaFactura',
														'$pagoFactura',
														'$fechaPago',
														'$vencimientoSolicitud',
														'$valorUF',
														'$fechaUF',
														'$tipoValor',
														'$Exenta',
														'$netoUF',
														'$ivaUF',
														'$brutoUF',
														'$Neto',
														'$Iva',
														'$Bruto',
														'$informesAM',
														'$cotizacionesCAM',
														'$Observa',
														'$Redondear',
														'$Excepcion',
														'$enviarFactura'
														)");
   				$MsgUsr = 'Se ha registrado un nueva Solicitud de Facturación ...';
		}
		$link->close();
	}
//	if($Proceso==2){
		$nOrden		= '';
		$vencimientoSolicitud = 0;
		$valorUF = 0;
		$fechaUF = '0000-00-00';
		$enviarFactura = '';
		
		$link=Conectarse();
		$bdSol=$link->query("SELECT * FROM SolFactura WHERE nSolicitud = '".$nSolicitud."' && RutCli = '".$RutCli."'");
		if ($rowSol=mysqli_fetch_array($bdSol)){
   			$fechaSolicitud 		= $rowSol['fechaSolicitud'];
   			$Proyecto 				= $rowSol['IdProyecto'];
   			$Fotocopia 				= $rowSol['Fotocopia'];
   			$fechaFotocopia 		= $rowSol['fechaFotocopia'];
   			$nOrden 				= $rowSol['nOrden'];
   			$FechaOrden 			= $rowSol['FechaOrden'];
   			$Contacto				= $rowSol['Contacto'];
   			$Atencion				= $rowSol['Atencion'];
   			$Contactos				= $rowSol['Atencion'];
   			$correosFactura			= $rowSol['correosFactura'];
   			//$ContactoSol			= $rowSol['Contacto'];
   			$Factura				= $rowSol['Factura'];
   			$fechaFactura			= $rowSol['fechaFactura'];
   			$pagoFactura			= $rowSol['pagoFactura'];
   			$fechaPago				= $rowSol['fechaPago'];
   			$vencimientoSolicitud	= $rowSol['vencimientoSolicitud'];
   			$valorUF				= $rowSol['valorUF'];
   			$fechaUF				= $rowSol['fechaUF'];
   			$tipoValor				= $rowSol['tipoValor'];
   			$Exenta					= $rowSol['Exenta'];
   			$netoUF					= $rowSol['netoUF'];
   			$ivaUF					= $rowSol['ivaUF'];
   			$brutoUF				= $rowSol['brutoUF'];
   			$Neto					= $rowSol['Neto'];
   			$Iva					= $rowSol['Iva'];
   			$Bruto					= $rowSol['Bruto'];
   			$informesAM				= $rowSol['informesAM'];
   			$cotizacionesCAM		= $rowSol['cotizacionesCAM'];
   			$Observa				= $rowSol['Observa'];
   			$Redondear				= $rowSol['Redondear'];
   			$enviarFactura			= $rowSol['enviarFactura'];
		}
		$link->close();
//	}
?>

<script>
function myFunction()
{
	var x=document.getElementById("Observa");
	x.value=x.value.toUpperCase();
	var x=document.getElementById("Especificacion");
	x.value=x.value.toUpperCase();
	var x=document.getElementById("valorUnitario");
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitario").val();
		var vNet	= $("#Neto").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
		var vTotal	= vCan * vUni;
		
		//document.form.valorTotal.value 	= vCan * vUni;
		document.form.valorTotal.value 	= vTotal;
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;
}
</script>

<script>
$(document).ready(function(){
	$("#tpValor").change(function() {
		var vtValor	= $("#tpValor").val();
		document.form.tipoValor.value 	= vtValor;
	});
	
	$("#Redondear").change(function() {
		var vRed	= $("#Redondear").val();
		var vNet	= $("#Neto").val();
		var vIva	= parseInt(vNet * 0.19);
		var vBru	= parseInt(vNet * 1.19);
		if (vRed == 'on')
		{
			var vIva	= Math.round((vNet * 0.19));
			var vBru	= Math.round((vNet * 1.19));
		}
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;
		return;
	});
	$("#Cantidad").change(function() {
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitario").val();
		var vNet	= $("#Neto").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
				
		document.form.valorTotal.value 	= vCan * vUni;
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;

		return;
	});
	$("#valorUnitario").change(function() {
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitario").val();
		var vNet	= $("#Neto").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
				
		document.form.valorTotal.value 	= vCan * vUni;
		document.form.Iva.value 		= vIva;
		document.form.Bruto.value 		= vBru;

		return;
	});
	$("#valorUnitarioUF").change(function() {
		var vCan	= $("#Cantidad").val();
		var vUni	= $("#valorUnitarioUF").val();
		var vNet	= $("#netoUF").val();
		var vIva	= vNet * 0.19;
		var vBru	= vNet * 1.19;
				
		document.form.valorTotalUF.value 	= vCan * vUni;
		document.form.ivaUF.value 			= vIva;
		document.form.brutoUF.value 		= vBru;

		return;
	});
	
	$("#Can").bind('keydown', function(event)
	{
	alert(event.keyCode);
	if (event.keyCode == '13')
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
<form name="form" action="formSolicitaFacturaNew.php" method="post">
	<div class="container-fluid" style="margin-top: 5px;">
		<div class="card">
			<div class="card-header bg-secondary text-white"><h5>FORMULARIO N° 4 - SOLICITUD DE FACTURA</h5></div>
		  	<div class="card-body">
		  		<div class="row">
		  			<div class="col-lg-1">
		  				<label for="nSolicitud">Solicitud:</label>
		  			</div>
		  			<div class="col-lg-2">
		  				<?php
							$link=Conectarse();
							$bdDepto=$link->query("SELECT * FROM Departamentos");
							if ($rowDepto=mysqli_fetch_array($bdDepto)){
								$EmailDepto = $rowDepto['EmailDepto'];
							}
							$link->close();
						?>
						<input  name="nSolicitud" id="nSolicitud" class="form-control" style="font-size:24px; "	type="text" size="5" maxlength="5" value="<?php echo $nSolicitud; ?>" >
		  			</div>
		  			<div class="col-lg-4">
		  			</div>
		  			<div class="col-lg-1">
		  				Fecha Solicitud:
		  			</div>
		  			<div class="col-lg-2">
						<?php 
							$fd 	= explode('-', $fechaSolicitud);
							echo $fd[2].' de '.$Mes[$fd[1]-1].' de '.$fd[0];
						?>
		  			</div>
		  			<div class="col-lg-2">
						<input name="fechaSolicitud" id="fechaSolicitud" class="form-control" type="date" size="10" maxlength="10" value="<?php echo $fechaSolicitud; ?>">
		  			</div>
		  		</div>
		  	</div> 
		</div>
	</div>

	<div class="container-fluid" style="margin-top: 5px;">
		<div class="row">
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header bg-secondary text-white"><h5>Datos del Cliente</h5></div>
				  	<div class="card-body">
				  		<div class="row">
				  			<div class="col-2">
				  				Cliente:
				  			</div>
				  			<div class="col-3">
				  				<input name="RutCli" class="form-control" type="text" size="15" maxlength="10" value="<?php echo $RutCli; ?>">
				  			</div>
				  			<div class="col-7">
								<input name="Proceso"  	type="hidden" value="<?php echo $Proceso; ?>">
								<select name="Cliente" class="form-control" id="Cliente" onChange="window.location = this.options[this.selectedIndex].value; return true;">
								<?php 
									echo "<option value='formSolicitaFacturaNew.php?RutCli=&Proceso=".$Proceso."&nSolicitud=".$nSolicitud."'>Cliente</option>";
									$link=Conectarse();
									$bdPr=$link->query("SELECT * FROM Clientes Order By Cliente");
									while ($row=mysqli_fetch_array($bdPr)){
											$bdAM=$link->query("SELECT * FROM Cotizaciones Where RutCli = '".$row['RutCli']."' and informeUP = 'on' and Facturacion != 'on' and Archivo != 'on'");
											if($rowAM=mysqli_fetch_array($bdAM)){
												if($RutCli == $row['RutCli']){
													echo "	<option selected 	value='formSolicitaFacturaNew.php?RutCli=".$row['RutCli']."&Proceso=".$Proceso."&nSolicitud=".$nSolicitud."'>".$row['Cliente']."</option>";
												}else{
													echo "	<option  			value='formSolicitaFacturaNew.php?RutCli=".$row['RutCli']."&Proceso=".$Proceso."&nSolicitud=".$nSolicitud."'>".$row['Cliente']."</option>";
												}
											}
									}
									$link->close();
								?>
								</select>

				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Razon Social:
				  			</div>
				  			<div class="col-10">
								<input name="Cliente" class="form-control" type="text" size="50" maxlength="50" value="<?php echo $Cliente; ?>">								
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Giro:
				  			</div>
				  			<div class="col-10">
				  				<input name="Giro" class="form-control"	type="text" size="80" maxlength="100" value="<?php echo $Giro; ?>">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Atención:
				  			</div>
				  			<div class="col-10">
								<?php
									$cContacto1			= '';
									$cContacto2			= '';
									$cContacto3			= '';
									$cContacto4			= '';
									if($Atencion){
										$fdAt = explode(',', $Atencion);
										for($i=0; $i < count($fdAt); $i++){
											if($i == 0) { $cContacto1 = $fdAt[$i]; }
											if($i == 1) { $cContacto2 = $fdAt[$i]; }
											if($i == 2) { $cContacto3 = $fdAt[$i]; }
											if($i == 3) { $cContacto4 = $fdAt[$i]; }
										}
									}
								?>
								<div class="row">
									<div class="col-3">
										<select name="Contacto" id="Contacto" class="form-control">
											<?php
												$Departamento 	= '';
												$pagosEmail 	= '';
												$nContactos 	= 0;
												$Email 			= '';
												$link=Conectarse();
												$bdCC=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'");
												if($rowCC=mysqli_fetch_array($bdCC)){
													do{
														if(strtoupper($rowCC['Contacto'])==='PAGOS'){
															$pagosEmail = $rowCC['Email'];
														}else{
															$nContactos++;
															if($rowCC['Contacto']===$cContacto1){
																$cContacto1 = $rowCC['Contacto'];
																echo "<option selected 	value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
																if($rowCC['Email']) {
																	$Email = $rowCC['Email'];
																}
																//$Email 			= $rowCC['Email'].', '.$EmailDepto;
																$Departamento 	= $rowCC['Depto'];
																$Telefono 		= $rowCC['Telefono'];
																//$Contacto 	= $rowCC['Contacto'];
															}else{
																echo "<option  			value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
																//$Email 			= $rowCC[Email].', '.$EmailDepto;
																//$Departamento 	= $rowCC[Depto];
																//$Contacto 	= $rowCC[Contacto];
															}
														}
													}while ($rowCC=mysqli_fetch_array($bdCC));
												}

												$link->close();
											?>
										</select>
									</div>
									<div class="col-3">
										<?php if($nContactos >= 2){?>
										<select name="Contacto2" id="Contacto2" class="form-control">
											<option></option>
											<?php
											
												$link=Conectarse();
												$bdCC=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'");
												if($rowCC=mysqli_fetch_array($bdCC)){
													do{
														if(strtoupper($rowCC['Contacto'])=='PAGOS' or $rowCC['Contacto'] === $cContacto1 or $rowCC['Contacto'] === $cContacto3 or $rowCC['Contacto'] === $cContacto4){
															//$pagosEmail = $rowCC['Email'];
														}else{
															if($rowCC['Contacto']===$cContacto2){
																echo "<option selected 	value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
																if($rowCC['Email']) {
																	if($Email){
																		$Email .= ', '.$rowCC['Email'];
																	}else{
																		$Email = $rowCC['Email'];
																	}
																}
																//$Email 			= $rowCC['Email'].', '.$EmailDepto;
																$Departamento 	= $rowCC['Depto'];
																$Telefono 		= $rowCC['Telefono'];
															}else{
																echo "<option  			value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
															}
														}
													}while ($rowCC=mysqli_fetch_array($bdCC));
												}

												$link->close();
											?>
										</select>
										<?php } ?>
									</div>
									<div class="col-3">
										<?php if($nContactos >= 3){?>
										<select name="Contacto3" id="Contacto3" class="form-control">
											<option></option>
											<?php
												$link=Conectarse();
												$bdCC=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'");
												while($rowCC=mysqli_fetch_array($bdCC)){
														if(strtoupper($rowCC['Contacto'])=='PAGOS' or $rowCC['Contacto'] === $cContacto1 or $rowCC['Contacto'] === $cContacto2 or $rowCC['Contacto'] === $cContacto4){
															//$pagosEmail = $rowCC['Email'];
														}else{
															if($rowCC['Contacto']===$cContacto3){
																echo "<option selected 	value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
																if($rowCC['Email']) {
																	if($Email){
																		$Email .= ', '.$rowCC['Email'];
																	}else{
																		$Email = $rowCC['Email'];
																	}
																}
																//$Email 			= $rowCC['Email'].', '.$EmailDepto;
																$Departamento 	= $rowCC['Depto'];
																$Telefono 		= $rowCC['Telefono'];
																//$Contacto 	= $rowCC['Contacto'];
															}else{
																echo "<option  			value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
																//$Email 			= $rowCC[Email].', '.$EmailDepto;
																//$Departamento 	= $rowCC[Depto];
																//$Contacto 	= $rowCC[Contacto];
															}
														}
												}

												$link->close();
											?>
										</select>
										<?php } ?>
									</div>
									<div class="col-3">
										<?php if($nContactos >= 4){?>
										<select name="Contacto4" id="Contacto4" class="form-control">
											<option></option>
											<?php
												$link=Conectarse();
												$bdCC=$link->query("SELECT * FROM contactosCli Where RutCli = '".$RutCli."'");
												while($rowCC=mysqli_fetch_array($bdCC)){
														if(strtoupper($rowCC['Contacto'])=='PAGOS' or $rowCC['Contacto'] === $cContacto1 or $rowCC['Contacto'] === $cContacto2 or $rowCC['Contacto'] === $cContacto3){
															//$pagosEmail = $rowCC['Email'];
														}else{
															if($rowCC['Contacto']===$cContacto4){
																echo "<option selected 	value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
																if($rowCC['Email']) {
																	if($Email){
																		$Email .= ', '.$rowCC['Email'];
																	}else{
																		$Email = $rowCC['Email'];
																	}
																}
																//$Email 			= $rowCC['Email'].', '.$EmailDepto;
																$Departamento 	= $rowCC['Depto'];
																$Telefono 		= $rowCC['Telefono'];
																//$Contacto 	= $rowCC['Contacto'];
															}else{
																echo "<option  			value='".$rowCC['Contacto']."'>".$rowCC['Contacto']."</option>";
																//$Email 			= $rowCC[Email].', '.$EmailDepto;
																//$Departamento 	= $rowCC[Depto];
																//$Contacto 	= $rowCC[Contacto];
															}
														}
												}

												$link->close();
											?>
										</select>
										<?php } ?>
									</div>
								</div>
								<?php 
									$Email = $Email.', '.$EmailDepto;
									if($pagosEmail){
										$Email = $pagosEmail.', '.$Email;
									}
									if($cContacto1) { $Atencion = $cContacto1; }
									if($cContacto2) { $Atencion .= ','.$cContacto2; }
									if($cContacto3) { $Atencion .= ','.$cContacto3; }
									if($cContacto4) { $Atencion .= ','.$cContacto4; }
								?>
								<div class="input-group mb-3">
									<input name="Contactos" class="form-control" type="text" size="100" maxlength="100" value="<?php echo $Contactos; ?>"> 
								</div>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Departamento:
				  			</div>
				  			<div class="col-10">
				  				<input name="Departamento" class="form-control" 	type="text" size="50" maxlength="50" value="<?php echo $Departamento; ?>">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Dirección:
				  			</div>
				  			<div class="col-10">
				  				<input name="Direccion" class="form-control" 	type="text" size="50" maxlength="50" value="<?php echo $Direccion; ?>">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Teléfono:
				  			</div>
				  			<div class="col-10">
				  				<input name="Telefono" class="form-control" type="text" size="50" maxlength="50" value="<?php echo $Telefono; ?>">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-2">
				  				Correo:
				  			</div>
				  			<div class="col-10">
								<input name="Email" class="form-control" type="text" size="100" maxlength="100" value="<?php echo $Email; ?>">	
				  			</div>
				  		</div>

					</div>
				</div>
			</div>
			<?php
			if($Cliente){?>

			<div class="col-lg-6">
				<div class="card">
					<div class="card-header bg-secondary text-white"><h5>Datos para Facturación</h5></div>
				  	<div class="card-body">
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Proyecto:
				  			</div>
				  			<div class="col-9">
								<select name="Proyecto" class="form-control" id="Proyecto">
									<?php 
										$Proyecto = '';
										$link=Conectarse();
										$bdPr=$link->query("SELECT * FROM Proyectos");
										while ($row=mysqli_fetch_array($bdPr)){
												if($row['IdProyecto'] == $rowSol['IdProyecto']){ 
													echo "<option selected>".$row['IdProyecto']."</option>";
												}else{
													echo "<option>".$row['IdProyecto']."</option>";
												}
										}
										$link->close();
									?>
							  </select>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Orden de Compra:
				  			</div>
				  			<div class="col-9">
				  				<input name="nOrden" class="form-control" type="text" id="nOrden" value="<?php echo $nOrden; ?>" size="50" maxlength="50">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Vencimiento:
				  			</div>
				  			<div class="col-9">
				  				<div class="row">
				  					<div class="col-3">
										<?php if($nSolicitud){?>
											<input name="vencimientoSolicitud" class="form-control"	type="text" size="5" maxlength="5" value="<?php echo $vencimientoSolicitud; ?>" />
										<?php }else{ ?>
											<input name="vencimientoSolicitud" class="form-control"	type="text" size="5" maxlength="5" value="<?php echo $vencimientoSolicitud; ?>" autofocus />
										<?php } ?>
									</div>
									<div class="col-9">
										Días
									</div>
								</div>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Exenta:
				  			</div>
				  			<div class="col-9">
								<?php
									if($Exenta=='on'){
										echo '<input name="Exenta" class="form-control" type="checkbox" checked>';
									}else{
										echo '<input name="Exenta" class="form-control" type="checkbox">';
									}
								?>
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Valores en:
				  			</div>
				  			<div class="col-9">
								<select name="tpValor" id="tpValor" class="form-control">
									<?php
										switch ($tipoValor) {
											case 'U':
												echo '<option selected 	value="U">UF</option>';
												echo '<option 			value="P">Pesos</option>';
												break;
											case 'P':
												echo '<option 			value="U">UF</option>';
												echo '<option selected  value="P">Pesos</option>';
												break;
											default:
												echo '<option selected 	value="U">UF</option>';
												echo '<option  			value="P">Pesos</option>';
												break;
										}								
										?>
								</select>
								<input name="tipoValor" type="hidden" id="tipoValor" value="<?php echo $tipoValor; ?>">

				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				UF Referencial:
				  			</div>
				  			<div class="col-9">
				  				<input name="valorUF" class="form-control" type="text" size="10" maxlength="10" value="<?php echo $valorUF; ?>">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Fecha Referencia:
				  			</div>
				  			<div class="col-9">
				  				<input name="fechaUF" class="form-control" type="date" id="fechaUF" value="<?php echo $fechaUF; ?>" size="10" maxlength="10">
				  			</div>
				  		</div>
				  		<div class="row" style="margin-top: 2px;">
				  			<div class="col-3">
				  				Enviar Factura:
				  			</div>
				  			<div class="col-9">
				  				<div class="row">
				  					<div class="col-4 text-center">
				  						<div class="form-group">
  											<label for="enviarFactura">USACH:</label>
					  						<?php
											if($enviarFactura==1){
												echo '<input name="enviarFactura" class="form-control" type="radio" value="1" checked>';
											}else{
												echo '<input name="enviarFactura" class="form-control" type="radio" value="1">';
											}
											?>
										</div>
				  					</div>
				  					<div class="col-4 text-center">
				  						EMPRESA
				  						<?php
										if($enviarFactura==2){
											echo '<input name="enviarFactura" class="form-control" type="radio" value="2" checked>';
										}else{
											echo '<input name="enviarFactura" class="form-control" type="radio" value="2">';
										}
										?>
				  					</div>
				  					<div class="col-4 text-center">
				  						OTRA
				  						<?php
										if($enviarFactura==3){
											echo '<input name="enviarFactura" class="form-control" type="radio" value="2" checked>';
										}else{
											echo '<input name="enviarFactura" class="form-control" type="radio" value="2">';
										}
										?>
				  					</div>

				  				</div>
				  			</div>
				  		</div>

					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php
	if($Cliente){?>
		<table class="table table-dark">
			<thead>
			<tr class="table-success">
				<th>
					<span class="tituloFormulario"><strong>Grabar Datos</strong></span>
					<button class="btn btn-primary" name="GuardarFacturacion" title="Guardar datos de Facturación" style="float:right; ">
						<img src="../gastos/imagenes/guardar.png" width="50" height="50">
					</button>
				</th>
			</tr>
		</table>
		<?php
	}
	?>

	<?php
		if($Cliente){
			if($nSolicitud > 0){?>
				<div class="container-fluid" style="margin-top: 5px;">
					<div class="card">
						<div class="card-header bg-secondary text-white"><h5>Asociar CAMs y RAMs</h5></div>
							<div class="card-body">
								Registro de Trabajos Terminados para Facturar (AM) <?php echo $RAM; ?>
								<div class="row">
									<div class="col-6">
						                <table id="usuarios" class="display" style="width:100%">
						                    <thead>
						                        <tr>
						                            <th>Disponibles     </th>
						                            <th>Monto       	</th>
						                            <th>Acciones    </th>
						                        </tr>
						                    </thead>
						                    <tbody>
												<?php
													$link=Conectarse();
													$bdPr=$link->query("SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and informeUP = 'on' and Facturacion != 'on' and Archivo != 'on'");
													while ($row=mysqli_fetch_array($bdPr)){?>
															<tr>
																<td style="padding:10px; border-bottom:1px solid #000;">
																	<?php 
																		echo 'RAM-'.$row['RAM'].' CAM-'.$row['CAM'];
																		if($row['Fan'] > 0){
																			echo '<br><img src="../imagenes/extra_column.png" align="left" width="32" title="CLON" style="padding:10px;">';
																		}
																	?>
																</td>
																<td style="border-bottom:1px solid #000;">
																	<strong style="font-size:12px;">
																		<?php echo 			number_format($row['BrutoUF'], 2, ',', '.'); ?>
																	</strong>
																</td>
																<td style="border-bottom:1px solid #000;">
																		<a href="formSolicitaFactura.php?RutCli=<?php echo $RutCli;?>&Proceso=<?php echo $Proceso; ?>&accionCAM=Agregar&nSolicitud=<?php echo $nSolicitud; ?>&CAM=<?php echo $row['CAM'];?>"><img src="../imagenes/add_32.png"></a>
																</td>
															</tr>
															<?php
													}
													$link->close();
												?>

						                    </tbody>
						                </table>
						            </div>
									<div class="col-6">
						                <table id="usuarios" class="display" style="width:100%">
						                    <thead>
						                        <tr>
						                            <th>Incluidos     </th>
						                            <th>Monto       	</th>
						                            <th>Acciones    </th>
						                        </tr>
						                    </thead>
						                    <tbody>
												<?php
													$link=Conectarse();
													$bdPr=$link->query("SELECT * FROM Cotizaciones Where RutCli = '".$RutCli."' and nSolicitud = '$nSolicitud'");
													while ($row=mysqli_fetch_array($bdPr)){?>
															<tr>
																<td style="padding:10px; border-bottom:1px solid #000;">
																	<?php 
																		echo 'RAM-'.$row['RAM'].' CAM-'.$row['CAM'];
																		if($row['Fan'] > 0){
																			echo '<br><img src="../imagenes/extra_column.png" align="left" width="32" title="CLON" style="padding:10px;">';
																		}
																	?>
																</td>
																<td style="border-bottom:1px solid #000;">
																	<strong style="font-size:12px;">
																		<?php echo 			number_format($row['BrutoUF'], 2, ',', '.'); ?>
																	</strong>
																</td>
																<td style="border-bottom:1px solid #000;">
																		<a href="formSolicitaFactura.php?RutCli=<?php echo $RutCli;?>&Proceso=<?php echo $Proceso; ?>&accionCAM=Quitar&nSolicitud=<?php echo $nSolicitud; ?>&CAM=<?php echo $row['CAM'];?>"><img src="../imagenes/delete_32.png"></a>
																</td>
															</tr>
															<?php
													}
													$link->close();
												?>
						                    </tbody>
						                </table>
						            </div>

						       	</div>
							</div>


							<div class="card">
								<div class="card-header bg-secondary text-white"><h5>Detalle Facturación</h5></div>
									<div class="card-body">
									
										<table  class="table table-bordered">
											<thead>
												<tr>
											  		<th>ITEMS</td>
											  		<th>CANTIDAD</td>
											  		<th>ESPECIFICACION</td>
											  		<th>Valor Unitario</td>
											  		<th>VALOR TOTAL</td>
											  		<th>Acciones</td>
												</tr>
											</thead>
											<tbody>
											<?php
											$nItems = 0;
											$NetoExcepcion = $Neto;
											$Neto 	= 0;
											$netoUF = 0;
											$link=Conectarse();
											$bddSol=$link->query("SELECT * FROM detSolFact WHERE nSolicitud = '".$nSolicitud."'");
											if ($rowdSol=mysqli_fetch_array($bddSol)){
												do{?>
													<tr>
														<td  height="30" align="center">
															<?php 
																echo $rowdSol['nItems'];
																$nItems = $rowdSol['nItems'];
															?>
														</td>
														<td  height="30" align="center">
															<?php echo $rowdSol['Cantidad'];?>
														</td>
														<td>
															<?php echo $rowdSol['Especificacion'];?>
														</td>
														<td align="right">
															<?php 
																if($tipoValor=='U'){
																	echo $rowdSol['valorUnitarioUF'];
																}else{
																	echo $rowdSol['valorUnitario'];
																}
															?>
														<td align="right">
															<?php 
																if($tipoValor=='U'){
																	echo $rowdSol['valorTotalUF'];
																	if($Exenta=='on'){
																		$netoUF 	+= $rowdSol['valorTotalUF'];
																		$ivaUF		= 0;
																		$brutoUF	= $netoUF;
																	}else{
																		$netoUF 	+= $rowdSol['valorTotalUF'];
																		$ivaUF		= $netoUF * 0.19;
																		$brutoUF	= $netoUF * 1.19;
																	}
																	if($Redondear=='on'){
																		$ivaUF		= round(($netoUF * 0.19),0);
																		$brutoUF	= round(($netoUF * 1.19),0);
																	}	
																}else{
																	echo $rowdSol['valorTotal'];
																	if($Exenta=='on'){
																		$Neto 	+= $rowdSol['valorTotal'];
																		$Iva	= 0;
																		$Bruto	= $Neto;
																	}else{
																		if($Excepcion != 'on'){
																			$Neto 	+= $rowdSol['valorTotal'];
																			//$Iva	= intval($Neto * 0.19);
																			//$Bruto	= intval($Neto * 1.19);
																			if($Redondear=='on'){
																				//$Iva	= round(($Neto * 0.19),0);
																				//$Bruto	= round(($Neto * 1.19),0);
																			}
																		}else{
																			$Neto = 1000;
																		}
																	}
																}
																$Neto = $NetoExcepcion;
															?>
														</td>
														<td align="center">
															<?php
																echo '<a href="formSolicitaFactura.php?Proceso=4&RutCli='.$rowdSol['RutCli'].'&nSolicitud='.$rowdSol['nSolicitud'].'&nItems='.$rowdSol['nItems'].'"><img src="../gastos/imagenes/delete_32.png" width="32" height="32" title="Eliminar Items">	</a>';
															?>
														</td>
													</tr>
													<?php
												}while ($rowdSol=mysqli_fetch_array($bddSol));
											}
											$link->close();
											?>
											<tr>
												<td  height="30" align="center">
													<?php 
														$nItems++;
														echo $nItems;
														$Cantidad 		= "";
														$Especificacion = "";
														$valorUnitarioUF= "";
														$valorTotalUF	= "";
														$valorUnitario	= "";
														$valorTotal		= "";
													?>
													<input name="nItems" 	type="hidden" id="nItems" value="<?php echo $nItems;?>" size="3" maxlength="3">
												</td>
												<td  height="30" align="center">
													<input name="Cantidad" tabindex="1"	type="text" id="Cantidad" value="<?php echo $Cantidad;?>" size="4" maxlength="4" autofocus />
												</td>
												<td>
													<input name="Especificacion" type="text" id="Cantidad" value="<?php echo $Especificacion;?>" size="88" maxlength="88">
												</td>
												<td align="right">
													<?php if($tipoValor=='U'){ ?>
														<input name="valorUnitarioUF" tabindex="3"	type="text" id="valorUnitarioUF" value="<?php echo $valorUnitarioUF;?>" size="10" maxlength="10"></td>
													<?php }else{?>
														<input name="valorUnitario" tabindex="3"	type="text" id="valorUnitario" value="<?php echo $valorUnitario;?>" size="10" maxlength="10"></td>
													<?php } ?>
												<td align="right">
													<?php if($tipoValor=='U'){?>
														<input name="valorTotalUF" tabindex="4"	type="text" id="valorTotalUF" value="<?php echo $valorTotalUF;?>" size="10" maxlength="10">
													<?php }else{?>
														<input name="valorTotal" tabindex="4"	type="text" id="valorTotal" value="<?php echo $valorTotal;?>" size="10" maxlength="10">
													<?php } ?>
												</td>
												<td width="2%" align="center">
												Excepción
												<?php
												if($Excepcion=='on'){
													echo '<input name="Excepcion" type="checkbox" checked>';
												}else{
													echo '<input name="Excepcion" type="checkbox">';
												}
												?>
												
													<?php
													//echo '<a href="registrafacturas.php?Proceso=2&RutProv='.$row['RutProv'].'&nFactura='.$row['nFactura'].'&Periodo='.$row['PeriodoPago'].'"><img src="../gastos/imagenes/corel_draw_128.png"   	width="32" height="32" title="Editar Items"></a>&nbsp;';
													//echo '<a href="registrafacturas.php?Proceso=3&RutProv='.$row['RutProv'].'&nFactura='.$row['nFactura'].'&Periodo='.$row['PeriodoPago'].'"><img src="../gastos/imagenes/delete_32.png" 			width="32" height="32" title="Eliminar">	</a>';
													?>
												</td>
											</tr>
											<tr>
											  <td  height="30" colspan="2" align="right">Informe(s) AM </td>
											  <td><textarea name="informesAM" rows="5" cols="100"><?php echo $informesAM; ?></textarea>
											  </td>
											  <td align="right">MONTO NETO </td>
											  <td align="right">
													Redondear
													<?php
														if($Redondear=='on'){
															echo '<input name="Redondear" type="checkbox" checked title="Redondeado" id="Redondear">';
														}else{
															echo '<input name="Redondear" type="checkbox" title="Sin Redondear" id="Redondear">';
														}
														$colorValor = '';
														if($Excepcion == 'on'){
															$colorValor = "background-color:#DC143C; color:#fff;";
														}
													?>
													<?php if($tipoValor=='U'){?>
														<input name="netoUF" 	tabindex="5" 	type="text" id="netoUF" value="<?php echo $netoUF; ?>" size="10" maxlength="10">
													<?php }else{ ?>
														<input name="Neto" style="<?php echo $colorValor; ?>" 		tabindex="5"	type="text" id="Neto" value="<?php echo $Neto; ?>" size="10" maxlength="10">
													<?php } ?>
											  </td>
												<td width="17%" rowspan="3" align="center">
													<div id="ImagenBarra" style="float:none; display:inline;">
														<a href="formularios/iFormulario4.php?nSolicitud=<?php echo $nSolicitud;?>" title="Imprimir Formulario N° 4">
															<img src="../gastos/imagenes/printer_128_hot.png">
														</a>
													</div>
												</td>
											</tr>
											<tr>
												<td  height="30" colspan="2" align="right">Cotización(es) CAM </td>
												<td><textarea name="cotizacionesCAM" rows="5" cols="100"><?php echo $cotizacionesCAM; ?></textarea>
												</td>
												<td align="right">IVA</td>
												<td align="right">
													<?php if($tipoValor=='U'){?>
														<input name="ivaUF" tabindex="6" 	type="text" id="ivaUF" value="<?php echo $ivaUF; ?>" size="10" maxlength="10">
													<?php }else{ ?>
														<input name="Iva" style="<?php echo $colorValor; ?>" 	tabindex="6"	type="text" id="Iva" value="<?php echo $Iva; ?>" size="10" maxlength="10">
													<?php } ?>
												</td>
											</tr>
											<tr>
											  <td  height="30" colspan="3" valign="top">
											  <br>
											  </td>
											  <td width="11%" align="right">TOTAL</td>
												<td width="18%" align="right">
													<?php if($tipoValor=='U'){?>
														<input name="brutoUF" 	tabindex="7"	type="text" id="brutoUF" value="<?php echo $brutoUF; ?>" size="10" maxlength="10">
													<?php }else{ ?>
														<input name="Bruto" style="<?php echo $colorValor; ?>" 	tabindex="7"	type="text" id="Bruto" value="<?php echo $Bruto; ?>" size="10" maxlength="10">
													<?php } ?>
											  </td>
											</tr>
											<tr>
												<td height="30" colspan="6">
													Observaciones:<br>
													<textarea class="form-control" onchange="myFunction()" name="Observa" id="Observa" cols="110" rows="5"><?php echo $Observa; ?></textarea>
													<!--
													<textarea name="Observa" id="editor" cols="110" rows="5"><?php echo $Observa; ?></textarea> -->
												</td>
											</tr>
											</tbody>
										</table>
										<?php 
									}
								}
								?>
									</div>
									<div class="card-footer bg-secondary text-white">
									<button name="GuardarFacturacion" class="btn btn-primary"  style="float:right; ">
										Grabar
									</button>										
									</div>
								</div>
							</div>







						</div>
					</div>
				</div>



		</form>

		<script>
			initSample();
		</script>
