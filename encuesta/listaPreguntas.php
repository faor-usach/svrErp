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
	$titItem  = '';
	if(isset($_GET['dBuscado'])) 	{ $dBuscado  = $_GET['dBuscado']; 	}
	
?>

			<div id="BarraFiltro">
				<img src="../gastos/imagenes/data_filter_128.png" width="28" height="28">

				<!-- Fin Filtro -->
				Consulta
				<!-- <input name="dBuscado" id="dBuscar" onKeyUp="realizaProceso($('#dBuscar').val())" align="right" maxlength="20" size="20" title="Ingrese RUT del Cliente a buscar..."> -->
				<input name="dBuscado" id="dBuscar" align="right" maxlength="40" size="40" placeholder="Consulta a Buscar" title="Ingrese Consulta...">
				<button name="Buscar" onClick="realizaProceso($('#dBuscar').val())">
					<img src="../gastos/imagenes/buscar.png"  width="32" height="32">
				</button>
					
			</div>
			<div id="BarraOpciones">
				<div id="ImagenBarraLeft">
					<a href="plataformaEncuesta.php" title="Nominas de Encuestas">
						<img src="../imagenes/consulta.png">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Men� Items">
					<a href="ItemsEncuesta.php?nEnc=<?php echo $nEnc; ?>" title="Items de Encuestas">
						<img src="../imagenes/subjects_bystudent.png">
					</a>
				</div>
				<div id="ImagenBarraLeft" title="Men� Items">
					<a href="#" title="Preguntas de Items">
						<img src="../imagenes/consultas1.png">
					</a>
				</div>
					<?php 
						echo $titItem; 
					?>
					
			</div>
			<?php
			if($dBuscado==''){?>
				<script>
					var nEnc 	= "<?php echo $nEnc; ?>" ;
					var nItem 	= "<?php echo $nItem; ?>" ;
					var dBuscar = '';
					realizaProceso(nEnc, nItem, dBuscar);
				</script>					
			<?php
			}
			?>
			<span id="resultado"></span>
			<span id="resultadoRegistro"></span>