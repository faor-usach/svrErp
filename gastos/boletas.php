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

	$nRegistros = 18;
	if(!isset($inicio)){
		$inicio = 0;
		$limite = 18;
	}
	if(isset($_GET['limite'])){
		$inicio = $_GET['limite']-1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['inicio'])){
		$inicio = ($_GET['inicio']-$nRegistros)+1;
		$limite = $inicio+$nRegistros;
	}
	if(isset($_GET['ultimo'])){
		$link=Conectarse();
		$bdGto	=	$link->query("SELECT * FROM MovGastos");
		$inicio	=	mysql_num_rows($bdGto) - $nRegistros;
		$limite	=	mysql_num_rows($bdGto);
		$link->close();
	}
	
?>
<!doctype html>
 
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Intranet Simet</title>

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
</head>

<body>
	<?php include('head.php'); ?>
	<div id="linea"></div>
<!--
	<div id="MenuSuperior">
        <div>
            <ul id="menudrop">                                                                  
            	<li class="selected">
					<a href="#" title="Configuración">	Configuracion</a>	
            		<ul>                                        
            			<li><a href="#" title="Perfiles">	Perfiles</a>	</li>
            			<li><a href="#" title="Usurios">	Usuarios</a>	</li>
					</ul>
				</li>
				
            	<li><a href="#"	title="Módulos">		Módulos</a>		
            		<ul>                                        
            			<li><a href="#" title="Personal">			Personal</a>			</li>
            			<li><a href="#" title="Proyectos">			Proyectos</a>			</li>
            			<li><a href="#" title="Items de Cuentas">	Items de Cuentas</a>	</li>
            			<li><a href="#" title="Proveedores">		Proveedores</a>			</li>
            			<li><a href="#" title="Clientes">			Clientes</a>			</li>
            			<li><a href="#" title="Informes">			Iformes</a>				</li>
            			<li><a href="#" title="Gastos">				Gastos</a>				</li>
					</ul>
				</li>
            	<li><a href="#"	title="Informes">		Informes</a>
            		<ul>                                        
            			<li><a href="#" title="Total Año">			Total Año</a>			</li>
            			<li><a href="#" title="Inversiones">		Inversiones</a>			</li>
            			<li><a href="#" title="Ranking">			Ranking</a>				</li>
					</ul>
				</li>
            	<li><a href="#"	title="Ranking">		Ranking</a>		</li>
            	<li><a href="#"	title="Cerrar Sesión">	Cerrar Sesión</a>	</li>
			</ul>
		</div>

	</div>
-->	
	<div id="Cuerpo">
		<?php //include('menulateral.php'); ?>
		<div id="CajaCpo">
			<div id="CuerpoTitulo">
				<span style="color:#FFFFFF; font-size:24px; ">Boletas</span>
				<div id="ImagenBarra">
					<a href="cerrarsesion.php" title="Cerrar SesiÃ³n">
						<img src="imagenes/preview_exit_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="../plataformaErp.php" title="MenÃº Principal">
						<img src="imagenes/Menu.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="registragastos.php" title="Registrar Gasto">
						<img src="imagenes/add_32.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="facturas.php" title="Facturas">
						<img src="imagenes/crear_certificado.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="eformularios.php" title="Emitir Formulario">
						<img src="imagenes/printer_128_hot.png" width="28" height="28">
					</a>
				</div>
				<div id="ImagenBarra">
					<a href="plataformaintranet.php" title="Inicio">
						<img src="imagenes/room_32.png" width="28" height="28">
					</a>
				</div>
				
			</div>
			<div id="BarraFiltro">
				<img src="imagenes/data_filter_128.png" width="28" height="28">

					<!-- Fitra por Proyecto -->
	  				<select name="Proyecto" id="Proyecto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){ 		$Items = $_GET['Items'];	 }else{ $Items 		= "Gastos"; }
							if(isset($_GET['Recurso'])){ 	$Recurso = $_GET['Recurso']; }else { $Recurso 	= "Recursos"; }

							$Proyecto = "Proyectos";
							if(isset($_GET['Proyecto'])){
								$Proyecto = $_GET['Proyecto'];
								echo "<option selected value='boletas.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."'>".$Proyecto."</option>";
							}else{
								echo "<option selected value='boletas.php?Proyecto=".$Proyecto."&Items=".$Items."&Recurso=".$Recurso."'>".$Proyecto."</option>";
							}
							echo "<option value='boletas.php?Proyecto=Proyectos&Items=".$Items."&Recurso=".$Recurso."'>Proyectos</option>";
							$link=Conectarse();
							$bdPr=$link->query("SELECT * FROM Proyectos");
							if ($row=mysqli_fetch_array($bdPr)){
								DO{
			    					echo "	<option value='boletas.php?Proyecto=".$row['IdProyecto']."&Items=".$Items."&Recurso=".$Recurso."'>".$row['IdProyecto']."</option>";
								}WHILE ($row=mysqli_fetch_array($bdPr));
							}
							$link->close();
						?>
					</select>

					<!-- Fitra por Tipo de Gasto -->
	  				<select name="TpGasto" id="TpGasto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							if(isset($_GET['Items'])){
								$Items = $_GET['Items'];
								echo "<option selected value='boletas.php?Items=".$Items."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$Items."</option>";
							}else{
								echo "<option selected value='boletas.php?Items=".$Items."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$Items."</option>";
							}
							echo "<option value='boletas.php?Items=Gastos&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>Gastos</option>";
							$link=Conectarse();
							$bdIt=$link->query("SELECT * FROM ItemsGastos Order By Items");
							if ($row=mysqli_fetch_array($bdIt)){
								DO{
			    					echo "	<option value='boletas.php?Items=".$row['Items']."&Proyecto=".$Proyecto."&Recurso=".$Recurso."'>".$row['Items']."</option>";
								}WHILE ($row=mysqli_fetch_array($bdIt));
							}
							$link->close();
						?>
					</select>
					<!-- Fin Filtro -->

					<!-- Fitra por Recurso -->
	  				<select name="TpGasto" id="TpGasto" onChange="window.location = this.options[this.selectedIndex].value; return true;">
						<?php 
							$Recurso = "Recursos";
							if(isset($_GET['Recurso'])){
								$Recurso = $_GET['Recurso'];
								echo "<option selected value='boletas.php?Recurso=".$Recurso."&Proyecto=".$Proyecto."&Items=".$Items."'>".$Recurso."</option>";
							}else{
								echo "<option selected value='boletas.php?Recurso=".$Recurso."&Proyecto=".$Proyecto."&Items=".$Items."'>".$Recurso."</option>";
							}
							echo "<option value='boletas.php?Recurso=Recursos&Proyecto=".$Proyecto."&Items=".$Items."'>Recursos</option>";
							$link=Conectarse();
							$bdRec=$link->query("SELECT * FROM Recursos");
							if ($row=mysqli_fetch_array($bdRec)){
								DO{
			    					echo "	<option value='boletas.php?Recurso=".$row['Recurso']."&Proyecto=".$Proyecto."&Items=".$Items."'>".$row['Recurso']."</option>";
								}WHILE ($row=mysqli_fetch_array($bdRec));
							}
							$link->close();
						?>
					</select>
					<!-- Fin Filtro -->

			</div>
			<?php
				echo '<div align="center">';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaTilulo">';
				echo '		<tr>';
				echo '			<td  width=" 5%"><strong>NÂ°				</strong></td>';
				echo '			<td  width=" 8%"><strong>Fecha 			</strong></td>';
				echo '			<td  width="15%"><strong>Proveedor		</strong></td>';
				echo '			<td  width="10%"><strong>Tip.Doc.		</strong></td>';
				echo '			<td  width=" 7%"><strong>NÂ° Doc.		</strong></td>';
				echo '			<td  width="15%"><strong>Bien o Servicio</strong></td>';
				echo '			<td  width="10%"><strong>Neto			</strong></td>';
				echo '			<td  width="10%"><strong>IVA			</strong></td>';
				echo '			<td  width="10%"><strong>Bruto			</strong></td>';
				echo '			<td colspan="2"  width="10%"><strong>Procesos</strong></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaListado">';
				$n = 0;

				$filtroSQL = "Where Estado != 'I' && TpDoc = 'B'";
				$IdProyecto = "";
				$link=Conectarse();
				$bdPr=$link->query("SELECT * FROM Proyectos Where IdProyecto = '".$Proyecto."'");
				if($row=mysqli_fetch_array($bdPr)){
			    	$IdProyecto = $row['IdProyecto'];
					if($filtroSQL==""){
						$filtroSQL .= "&&IdProyecto='".$row['IdProyecto']."'"; 
					}else{
						$filtroSQL .= "&&IdProyecto='".$row['IdProyecto']."'"; 
					}
				}

				$bdIt=$link->query("SELECT * FROM ItemsGastos Where Items = '".$Items."'");
				if($row=mysqli_fetch_array($bdIt)){
					if($filtroSQL==""){
						$filtroSQL = "Where nItem ='".$row['nItem']."'"; 
					}else{
						$filtroSQL .= "&&nItem ='".$row['nItem']."'"; 
					}
				}

				$bdRec=$link->query("SELECT * FROM Recursos Where Recurso = '".$Recurso."'");
				if($row=mysqli_fetch_array($bdRec)){
					if($filtroSQL==""){
						$filtroSQL = "Where IdRecurso ='".$row['IdRecurso']."'"; 
					}else{
						$filtroSQL .= "&&IdRecurso ='".$row['IdRecurso']."'"; 
					}
				}

				$link->close();
				// echo "Consulta SQL = ".$filtroSQL;

				
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
					DO{
						$n++;
						$tNeto	+= $row['Neto'];
						$tIva	+= $row['Iva'];
						$tBruto	+= $row['Bruto'];
						echo '		<tr>';
						echo '			<td width=" 5%">'.$row['nGasto'].'			</td>';
						$fd 	= explode('-', $row['FechaGasto']);
						$Fecha 	= "{$fd[2]}-{$fd[1]}-{$fd[0]}";
						echo '			<td width=" 8%">'.$Fecha.'		</td>';
						echo '			<td width="15%">'.$row['Proveedor'].'		</td>';
						echo '			<td width="10%">'.$row['TpDoc'].'			</td>';
						echo '			<td width=" 7%">'.$row['nDoc'].'			</td>';
						echo '			<td width="15%">'.$row['Bien_Servicio'].'	</td>';
						echo '			<td width="10%">'.number_format($row['Neto'] , 0, ',', '.').'			</td>';
						echo '			<td width="10%">'.number_format($row['Iva']	 , 0, ',', '.').'				</td>';
						echo '			<td width="10%">'.number_format($row['Bruto'], 0, ',', '.').'			</td>';
    					echo '			<td><a href="registragastos.php?Proceso=2&nGasto='.$row['nGasto'].'"><img src="imagenes/corel_draw_128.png"   width="22" height="22" title="Editar Ficha"     ></a></td>';
    					echo '			<td><a href="registragastos.php?Proceso=3&nGasto='.$row['nGasto'].'"><img src="imagenes/delete_32.png" 		width="22" height="22" title="Eliminar Personal"></a></td>';
						echo '		</tr>';
					}WHILE ($row=mysqli_fetch_array($bdGto));
				}
				$link->close();
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

				if($n > $nRegistros){
					echo '	<table width="100%"  border="0" cellspacing="0" cellpadding="0" id="CajaFinal">';
					echo '		<tr>';
					echo '			<td align="center">';
					echo '				<a href="lclientes.php">Inicio</a> |';
					echo '				<a href="lclientes.php?inicio='.$inicio.'">Anterior</a> |';
					echo '				<a href="lclientes.php?limite='.$limite.'">Siguiente</a> |';
					echo '				<a href="lclientes.php?ultimo=fin">Final</a>';
					echo '			</td>';
					echo '		</tr>';
					echo '	</table>';
				}else{
					for ($i = $n; $i <= $nRegistros; $i++) {
				    	echo '<br>';
					}				
				}
				echo '</div>';
			?>


		</div>
	</div>
	<div style="clear:both; "></div>
	<br>
	<div id="CajaPie" class="degradadoNegro">
		Laboratorio Simet
	</div>

</body>
</html>
