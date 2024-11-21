<?php 
	session_start();
	set_time_limit(0);
	//include_once("Mobile-Detect-2.3/Mobile_Detect.php");
	date_default_timezone_set("America/Santiago");
 	//$Detect = new Mobile_Detect();

	$_SESSION['Grabado'] = "NO";
	
	$MsgUsr 	= "";	
	$ultUF		= 0;
	$mesInd 	= date('m');
	$agnoInd 	= date('Y');
	$Proceso 	= '';
	$mInd = '';

	$ins45		= '';
	$ins60		= '';
	$ins75		= '';
	$ins90		= '';
	
	if(isset($_GET['mesInd']))  { $mesInd  	= $_GET['mesInd'];  	};
	if(isset($_GET['agnoInd'])) { $agnoInd 	= $_GET['agnoInd']; 	};
	if(isset($_GET['rCot']))  	{ $rCot 	= $_GET['rCot']; 		};

	if(isset($_POST['mesInd']))  { $mesInd  = $_POST['mesInd'];  };
	if(isset($_POST['agnoInd'])) { $agnoInd = $_POST['agnoInd']; };
	if(isset($_POST['rCot']))  	 { $rCot 	= $_POST['rCot']; 	 };

	$fechaHoy = date('Y-m-d');
	$fd = explode('-', $fechaHoy);
	
	$mesAnt = false;
	
	include_once("conexionli.php");
	if (isset($_SESSION['usr'])){
		$link=Conectarse();
		$bdPer=$link->query("SELECT * FROM Perfiles WHERE IdPerfil = '".$_SESSION['IdPerfil']."'");
		if ($rowPer=mysqli_fetch_array($bdPer)){
			$_SESSION['Perfil']	= $rowPer['Perfil'];
		}

		$ultUF = 0;
		$mesAnt = false;
		$bdUfRef=$link->query("Select * From tablaRegForm");
		if($rowUfRef=mysqli_fetch_array($bdUfRef)){
			$ultUF = $rowUfRef['valorUFRef'];
		}
		if($agnoInd < $fd[0]){
			$mesAnt = true;
			$bdCli=$link->query("SELECT valorUF FROM SolFactura Where month(fechaSolicitud) = '".$mesInd."' and year(fechaSolicitud) = '".$agnoInd."' and valorUF > 0 and nFactura > 0 Order By fechaFactura Desc");
			if($rowCli=mysqli_fetch_array($bdCli)){
				$ultUF = $rowCli['valorUF'];
			}
		}else{
			if($mesInd < $fd[1]){
				$mesAnt = true;
				$bdCli=$link->query("SELECT valorUF FROM SolFactura Where month(fechaSolicitud) = '".$mesInd."' and year(fechaSolicitud) = '".$agnoInd."' and valorUF > 0 and nFactura > 0 Order By fechaFactura Desc");
				if($rowCli=mysqli_fetch_array($bdCli)){
					$ultUF = $rowCli['valorUF'];
				}
			}
		}
		$link->close();
	}else{
		header("Location: index.php");
	}

	/* Declaración de Variables */	
	$indMin		= 00.00;
	$indMeta 	= 00.00;
	$indDesc 	= 00.00;
	$indDesc2 	= 00.00;
	$indDesc3 	= 00.00;
	$descrDesc 	= '';
	$descrDesc2 = '';
	$descrDesc3 = '';
	$maxCpo 	= "100%";
	
	$Proceso 	= 1;
	
	$fechaHoy = date('Y-m-d');
	$fd = explode('-', $fechaHoy);
	
	$mesInd 	= $fd[1];
	$agnoInd	= $fd[0];

	if(isset($_GET['mesInd']))  { $mesInd  	= $_GET['mesInd'];  	}
	if(isset($_GET['agnoInd'])) { $agnoInd 	= $_GET['agnoInd']; 	}
	if(isset($_GET['rCot']))  	{ $rCot 	= $_GET['rCot']; 		}
	
	if(isset($_POST['mesInd']))  { $mesInd  = $_POST['mesInd'];  	}
	if(isset($_POST['agnoInd'])) { $agnoInd = $_POST['agnoInd']; 	}
	if(isset($_POST['rCot']))  	 { $rCot 	= $_POST['rCot']; 	 	}

	if(isset($_GET['Proceso']))	{ $Proceso  = $_GET['Proceso']; 	}
	
	$link=Conectarse();
	if(isset($_POST['Guardar'])){
		if(isset($_POST['mesInd'])) 	{ $mesInd		= $_POST['mesInd'];		}
		if(isset($_POST['agnoInd'])) 	{ $agnoInd		= $_POST['agnoInd'];	}
		if(isset($_POST['indMin'])) 	{ $indMin		= $_POST['indMin'];		}
		if(isset($_POST['indMeta'])) 	{ $indMeta 		= $_POST['indMeta'];	}
		if(isset($_POST['indDesc'])) 	{ $indDesc 		= $_POST['indDesc'];	}
		if(isset($_POST['descrDesc'])) 	{ $descrDesc 	= $_POST['descrDesc'];	}
		if(isset($_POST['indDesc2'])) 	{ $indDesc2 	= $_POST['indDesc2'];	}
		if(isset($_POST['descrDesc2'])) { $descrDesc2 	= $_POST['descrDesc2'];	}
		if(isset($_POST['indDesc3'])) 	{ $indDesc3 	= $_POST['indDesc3'];	}
		if(isset($_POST['descrDesc3'])) { $descrDesc3 	= $_POST['descrDesc3'];	}
		if(isset($_POST['rCot'])) 		{ $rCot 		= $_POST['rCot'];		}

		if(isset($_POST['ins45'])) 		{ $ins45 	= $_POST['ins45'];		}
		if(isset($_POST['ins60'])) 		{ $ins60 	= $_POST['ins60'];		}
		if(isset($_POST['ins75'])) 		{ $ins75 	= $_POST['ins75'];		}
		if(isset($_POST['ins90'])) 		{ $ins90 	= $_POST['ins90'];		}

		$actSQL="UPDATE tablaSegFacturas SET ";
		$actSQL.="Instrucciones	='".$ins45."'";
		$actSQL.="Where rangoDesde = '45'";
		$bd=$link->query($actSQL);

		$actSQL="UPDATE tablaSegFacturas SET ";
		$actSQL.="Instrucciones	='".$ins60."'";
		$actSQL.="Where rangoDesde = '60'";
		$bd=$link->query($actSQL);

		$actSQL="UPDATE tablaSegFacturas SET ";
		$actSQL.="Instrucciones	='".$ins75."'";
		$actSQL.="Where rangoDesde = '75'";
		$bd=$link->query($actSQL);

		$actSQL="UPDATE tablaSegFacturas SET ";
		$actSQL.="Instrucciones	='".$ins90."'";
		$actSQL.="Where rangoDesde = '90'";
		$bd=$link->query($actSQL);

		if(isset($_POST['valorUFRef'])){
			$valorUFRef 	= $_POST['valorUFRef'];
			$ultUF = $valorUFRef;
			$actSQL="UPDATE tablaRegForm SET ";
			$actSQL.="valorUFRef	='".$valorUFRef."'";
			$bd=$link->query($actSQL);
		}
		$bdUsr=$link->query("SELECT * FROM Usuarios");
		if($rowUsr=mysqli_fetch_array($bdUsr)){
			do{
				if(intval($rowUsr['nPerfil'])  === 1 or $rowUsr['nPerfil']  === '01' or $rowUsr['nPerfil']  === '02'){
					$varUsr 	= 'usr'.$rowUsr['usr'];
					$valorHH 	= 'valorHH'.$rowUsr['usr'];
					
					if(isset($_POST[$varUsr]))	{ $varUsr	= $_POST[$varUsr];	}
					if(isset($_POST[$valorHH]))	{ $valorHH	= $_POST[$valorHH];	}
					
					$bdHH=$link->query("SELECT * FROM HrsHombre Where usr = '".$rowUsr['usr']."' and Mes = '".$mesInd."' and Agno = '".$agnoInd."'");
					if($rowHH=mysqli_fetch_array($bdHH)){
						$actSQL="UPDATE HrsHombre SET ";
						$actSQL.="HorasMes 		='".$varUsr.	"',";
						$actSQL.="valorHH 		='".$valorHH.	"'";
						$actSQL.="Where 	usr = '".$rowUsr['usr']."' and Mes	= '".$mesInd."' and Agno = '".$agnoInd."'";
						$bdHH=$link->query($actSQL);
					}else{
						$usrVar = $rowUsr['usr'];
						$link->query("insert into HrsHombre		(	usr,
																	Mes,
																	Agno,
																	HorasMes,
																	valorHH
																) 
														values 	(	'$usrVar',
																	'$mesInd',
																	'$agnoInd',
																	'$varUsr',
																	'$valorHH'
						)");
					}
				}
			}while ($rowUsr=mysqli_fetch_array($bdUsr));
		}

		$bdInd=$link->query("Select * From tablaIndicadores Where mesInd	= '".$mesInd."' and agnoInd = '".$agnoInd."'");
		if($rowInd=mysqli_fetch_array($bdInd)){
			$actSQL="UPDATE tablaIndicadores SET ";
			$actSQL.="mesInd 		='".$mesInd.	"',";
			$actSQL.="agnoInd 		='".$agnoInd.	"',";
			$actSQL.="indMin 		='".$indMin.	"',";
			$actSQL.="indMeta		='".$indMeta.	"',";
			$actSQL.="indDesc		='".$indDesc.	"',";
			$actSQL.="descrDesc		='".$descrDesc.	"',";
			$actSQL.="indDesc2		='".$indDesc2.	"',";
			$actSQL.="descrDesc2	='".$descrDesc2."',";
			$actSQL.="indDesc3		='".$indDesc3.	"',";
			$actSQL.="descrDesc3	='".$descrDesc3."',";
			$actSQL.="rCot			='".$rCot.		"'";
			$actSQL.="WHERE mesInd	= '".$mesInd."' and agnoInd = '".$agnoInd."'";
			$bdInd=$link->query($actSQL);
		}else{
			$link->query("insert into tablaIndicadores(	mesInd,
														agnoInd,
														indMin,
														indMeta,
														indDesc,
														descrDesc,
														indDesc2,
														descrDesc2,
														indDesc3,
														descrDesc3
													) 
											values 	(	'$mesInd',
														'$agnoInd',
														'$indMin',
														'$indMeta',
														'$indDesc',
														'$descrDesc',
														'$indDesc2',
														'$descrDesc2',
														'$indDesc3',
														'$descrDesc3'
			)");
		}
	}
	$rCot = 0;
	$bdEmp=$link->query("SELECT * FROM tablaIndicadores Where mesInd	= '".$mesInd."' and agnoInd = '".$agnoInd."'");
	if($rowEmp=mysqli_fetch_array($bdEmp)){
		$mesInd 	= $rowEmp['mesInd'];
		$agnoInd 	= $rowEmp['agnoInd'];
		$indMin 	= $rowEmp['indMin'];
		$indMeta 	= $rowEmp['indMeta'];
		$indDesc 	= $rowEmp['indDesc'];
		$descrDesc 	= $rowEmp['descrDesc'];
		$indDesc2 	= $rowEmp['indDesc2'];
		$descrDesc2 = $rowEmp['descrDesc2'];
		$indDesc3 	= $rowEmp['indDesc3'];
		$descrDesc3 = $rowEmp['descrDesc3'];
		$rCot 		= $rowEmp['rCot'];
	}

	$link->close();

?>
<!doctype html>
 
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tabla de Rangos</title>
	
	<link href="css/tpv.css" 	rel="stylesheet" type="text/css">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	<link href="estilos.css" 	rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="cssboot/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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
	<script src="../jquery/jquery-1.6.4.js"></script>
	<script type="text/javascript" src="angular/angular.js"></script>

	<script language="javascript">
	function NoBack(){
	history.go(1)
	}
	</script>

</head>

<body ng-app="myApp" novalidate ng-controller="controlRangos" OnLoad="NoBack();">
	<?php include('head.php'); ?>
	<div id="linea"></div>

	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="imagenes/simet.png" alt="logo" style="width:40px;">
				</a>

	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav>
	<?php include_once('mRangos.php');?>
	<div style="clear:both; "></div>


	<script src="jsboot/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="rangos.js"></script>
	<script>
		$(document).ready(function() {
    		$('#usuarios').DataTable({
    			"order": [[ 0, "asc" ]]
    		});

		} );	
	</script>

</body>
</html>