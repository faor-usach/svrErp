<?php

	$Estado = array(
					1 => 'Estado', 
					2 => 'Fotocopia',
					3 => 'Factura',
					4 => 'Canceladas'
				);

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

	$fd 	= explode('-', date('Y-m-d'));

	$Agno     	= date('Y');
	
	$dBuscado = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"><br>
					</a>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="plataformaCotizaciones.php" title="Cotizaciones">
						<img src="../imagenes/other_48.png"><br>
					</a>
					Proceso
				</div>
				<div id="ImagenBarraLeft" title="Ir a Muestras...">
					<a href="../registroMat" title="Ir a Registrar Muestras...">
						<img src="../imagenes/inventarioMuestras.png"></a><br>
<!--					<a href="../registroMat/recepcionMuestras.php" title="Ir a Registrar Muestras...">
						<img src="../imagenes/inventarioMuestras.png"></a><br>
-->						
					<span>Muestras</span>
				</div>
				<div id="ImagenBarraLeft" title="Servicios">
					<a href="Servicios.php" title="Servicios">
						<img src="../imagenes/Taller.png"></a><br>
					<span>Servicios</span>
				</div>

				<!-- Crear Ventana Modal Modal -->
				<div id="ImagenBarraLeft" title="Procesos">
					<a 	href="modCotizacion.php?CAM=0&Rev=0&Cta=0&accion=Crear" 
						title="Crear Cotización">
						<img src="../imagenes/cotizacion.png"></a><br>
					<span>+Cot.</span>
				</div>

<!--
		        		data-toggle="modal" 
		        		data-target="#modal_CreaCot" 
						ng-click="crearCotizacion()">
-->

				<div id="ImagenBarraLeft" title="Descarga Ensayos en PROCESOS PAM" style="text-align:center;">
					<a href="exportarCotizaciones2.php"><img src="../gastos/imagenes/excel_icon.png"></a><br>
					<span>PAM</span>
				</div>
						
				<?php if($_SESSION['usr']=='Alfredo.Artigas' or $_SESSION['usr'] == '10074437' or substr($_SESSION['IdPerfil'],0,1) == 0){?>
						<div id="ImagenBarraLeft" title="Descargar AM...">
							<a href="exportarAM.php"><img src="../imagenes/AM.png"></a><br>
							<span>AM</span>
						</div>
						<div id="ImagenBarraLeft" title="Descarga Cotizaciones Premium">
							<a href="formularios/iPremium.php"><img src="../imagenes/icono-descargas.png"></a><br>
							<span>Premium</span>
						</div>
				<?php } ?>
				<div id="ImagenBarraLeft" title="PreCAM" style="text-align:center;">
					<a href="../precam/preCAM.php"><img src="../imagenes/consulta.png"></a><br>
					<span>PRECAM</span>
				</div>
			</div>

			<div class="row bg-secondary text-white p-2">
					<div class="col-5">
						<div class="btn-group">
							<a ng-repeat="reg in Ingenieros" ng-click="filtroUsr(reg.usr)" class="btn btn-primary" title="{{reg.usuario}}"> 
								{{reg.usr}} 
							</a>
							<a class="btn btn-primary" ng-click="filtroUsr('Baja')"		title="Dadas de Baja">De Baja</a>
							<a class="btn btn-primary" ng-click="muestraTodos()" title="Todos">Todos</a>
							<!--
							<a class="btn btn-primary" href="historial.php?usrFiltro=Historial" 				title="Historial">Historial</a>
							-->
						</div>
					</div>
					<div class="col-1">
						<b>Filtro:</b>
					</div>
					<div class="col-6">
						<!--
						<input type="text" class="form-control" ng-model="filtroClientes" ng-init="filtroClientes='<?php echo $_SESSION['usr']; ?>'">
						-->
						<input type="text" class="form-control" ng-model="filtroClientes" ng-init="filtroClientes = '<?php echo $CAM; ?>'" autofocus />
					</div>
			</div>
