<?php

	$Estado = array(
					1 => 'Todos', 
					2 => 'Pendientes',
					3 => 'Terminados',
					4 => 'Sin Informe'
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
	if(isset($_GET['Mm'])) { 
		$Mm = $_GET['Mm']; 
		$PeriodoPago = $MesNum[$Mm].".".$fd[0];
	}else{
		$Mm = $Mes[ intval($fd[1]) ];
		$PeriodoPago = $fd[1].".".$fd[0];
	}

	$pPago = $Mm.'.'.$fd[0];

	//$MesHon 	= $Mm;
	$Proyecto 	= "Proyectos";
	$Situacion 	= "Estado";
	$CAM		= '';
	//$MesFiltro  = "Mes";
	$Agno     	= date('Y');
	
	$MesFiltro = $Mes[intval($fd[1])];
	if(isset($_GET['Proyecto']))  	{ $Proyecto  = $_GET['Proyecto']; 	}
	if(isset($_GET['MesFiltro'])) 	{ $MesFiltro = $_GET['MesFiltro']; 	}
	if(isset($_GET['Estado'])) 		{ $Situacion = $_GET['Estado']; 	}
	if(isset($_GET['Agno'])) 		{ $Agno 	 = $_GET['Agno']; 		}
	
	$dBuscado = '';
	if(isset($_POST['dBuscado'])) 	{ $dBuscado  = $_POST['dBuscado']; 	}
	if(isset($_GET['CodInforme']))  { $CodInforme= $_GET['CodInforme']; }
	$cRam = explode('-',$CodInforme);
	$vRam = $cRam[1];
	
?>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="../plataformaErp.php" title="Menú Principal">
						<img src="../gastos/imagenes/Menu.png"></a>
					<br>
					Principal
				</div>
				<div id="ImagenBarraLeft">
					<a href="plataformaGenInf.php" title="Informes">
						<img src="../imagenes/Tablas.png"></a>
					<br>
					PAMs
				</div>
				<div id="ImagenBarraLeft">
					<a href="../otams/idMuestras.php?accion=Ver&RAM=<?php echo $vRam; ?>&CAM=<?php echo $CAM; ?>" title="Informes">
						<img src="../imagenes/consulta.png"></a>
					<br>
					Muestras
				</div>
				<div id="ImagenBarraLeft">
					<a href="nominaInformes.php?accion=ReEditar&CodInforme=<?php echo $CodInforme; ?>&RAM=<?php echo $RAM; ?>&RutCli=<?php echo $RutCli; ?>"	>
						<img src="../imagenes/actividades.png" 	width="50" title="Generar/Editar Informes AM"	></a>
					<br>
					Editar
				</div>
			</div>

			
			<?php
			if($dBuscado==''){?>
				<script>
					var CodInforme 	= '<?php echo $CodInforme; ?>';
					var RAM 		= '<?php echo $RAM; ?>';
					var dBuscar = '';
					realizaProceso(CodInforme, RAM);
				</script>					
			<?php
			}
			?>
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>
			<span id="resultadoSubir"></span>
