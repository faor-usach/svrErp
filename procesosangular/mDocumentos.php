<?php
	session_start();
	$_SESSION['Grabado'] = "NO";
	$MsgUsr ="";	
	
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

	$CAM = '';
    $RAM = '';
    $pdf = '';
	if(isset($_GET['CAM'])){ $CAM = $_GET['CAM']; }
	if(isset($_GET['RAM'])){ $RAM = $_GET['RAM']; }
    if(isset($_GET['accion'])){ $accion = $_GET['accion']; }

	if(isset($_POST['CAM'])){ $CAM = $_POST['CAM']; }
	if(isset($_POST['RAM'])){ $RAM = $_POST['RAM']; }
    if(isset($_POST['accion'])){ $accion = $_POST['accion']; }
    
	if(isset($_POST['SubirDocumentos'])){

		/* Documento PDF */
        if(isset($_FILES['pdfOC']['name'])){
            $nom_PdfOC 	= $_FILES['pdfOC']['name'];
            $tip_PdfOC 	= $_FILES['pdfOC']['type'];
            $tam_PdfOC 	= $_FILES['pdfOC']['size'];
            $des_PdfOC	= $_FILES['pdfOC']['tmp_name'];

            /*
            $directorioDoc="Y://AAA/Archivador/CAM-".$CAM;
            if(!file_exists($directorioDoc)){
                mkdir($directorioDoc,0755);
            }
            */
            $directorioDoc="DOC/CAM-".$CAM;
            if(!file_exists($directorioDoc)){
                mkdir($directorioDoc,0755);
            }

            $agnoActual = date('Y');
            // $directorioDocOC="Y://AAA/Archivador/CAM-".$CAM."/OC";
            $directorioDocOC="Y://AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM;
            if(!file_exists($directorioDocOC)){
                mkdir($directorioDocOC);
            }
            
            if($tip_PdfOC == "application/pdf") {
                $newPdfOC = 'OC-'.$CAM.'.pdf';
                if(move_uploaded_file($des_PdfOC, $directorioDocOC."/".$newPdfOC)) {

                }
                
            }
            $directorioDocOCPr="DOC/CAM-".$CAM."/OC";
            if(!file_exists($directorioDocOCPr)){
                mkdir($directorioDocOCPr);
            }

            // $vDir = "Y://AAA/LE/LABORATORIO/".$agnoActual.'/'.$RAM.'/';
            // copy($directorioDocOC."/".$newPdfOC, $vDir.$newPdfOC);

            if($tip_PdfOC == "application/pdf") {
                if(copy($directorioDocOC."/".$newPdfOC, $directorioDocOCPr."/".$newPdfOC)) {

                }
                
            }
        }
        if(isset($_FILES['pdfHES']['name'])){
            $nom_PdfHES 	= $_FILES['pdfHES']['name'];
            $tip_PdfHES 	= $_FILES['pdfHES']['type'];
            $tam_PdfHES 	= $_FILES['pdfHES']['size'];
            $des_PdfHES	    = $_FILES['pdfHES']['tmp_name'];

            $directorioDoc="Y://AAA/Archivador/CAM-".$CAM;
            if(!file_exists($directorioDoc)){
                mkdir($directorioDoc,0755);
            }
            $directorioDoc="DOC/CAM-".$CAM;
            if(!file_exists($directorioDoc)){
                mkdir($directorioDoc,0755);
            }

            $directorioDocHES="Y://AAA/Archivador/CAM-".$CAM."/HES";
            if(!file_exists($directorioDocHES)){
                mkdir($directorioDocHES,0755);
            }
            if($tip_PdfHES == "application/pdf") {
                $newPdfHES = 'HES-'.$CAM.'.pdf';
                if(move_uploaded_file($des_PdfHES, $directorioDocHES."/".$newPdfHES)) {

                }
            }
            $directorioDocHESPr="DOC/CAM-".$CAM."/HES";
            if(!file_exists($directorioDocHESPr)){
                mkdir($directorioDocHESPr,0755);
            }


            if($tip_PdfHES == "application/pdf") {
                if(copy($directorioDocHES."/".$newPdfHES, $directorioDocHESPr."/".$newPdfHES)) {

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
	<title>Mantención de Documentos <?php echo $CAM; ?></title>

	<link href="styles.css" rel="stylesheet" type="text/css">
	<link href="../css/tpv.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../cssboot/bootstrap.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
input.mayusculas{text-transform:uppercase;}
</style>
<script src="../jquery/jquery-1.6.4.js"></script>
</head>

<body ng-app="myApp" ng-controller="CtrlCotizaciones">
	<?php include('head.php'); ?>
	<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-danger static-top">
		<div class="container-fluid">
  	    	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	    	<div class="collapse navbar-collapse" id="navbarResponsive">

				<a class="navbar-brand" href="#">
					<img src="../imagenes/simet.png" alt="logo" style="width:40px;">
				</a>
	      		<ul class="navbar-nav ml-auto">
	        		<li class="nav-item active">
	          			<a class="nav-link fa fa-home" href="../plataformaErp.php"> Principal
	                	<span class="sr-only">(current)</span>
	              		</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-paste" href="plataformaCotizaciones.php"> Procesos</a>
	        		</li>
	        		<li class="nav-item">
	          			<a class="nav-link fas fa-power-off" href="../cerrarsesion.php"> Cerrar</a>
	        		</li>

	      		</ul>
	    	</div>
	  	</div>
	</nav> 
	<div class="row bg-info text-white" style="padding: 10px;">
		<div class="col-12">
			<h5>SUBIR DOCUMENTOS <?php echo $CAM; ?></h5>
		</div>
	</div>

<style type="text/css">
	.uppercase { text-transform: uppercase; }
</style>

	<div class="container">
        <form name="myForm" enctype="multipart/form-data" action="mDocumentos.php" method="post">

		<div class="card" style="margin: 10px; margin: 10px 50px 50px;">
			<div class="card-header">Identificación de Documentos Asociados</div>
		  	<div class="card-body">
		  		<div class="row">
		  			<div class="col-md-1">
				    	<label for="CAM">CAM:  </label>
				    </div>
		  			<div class="col-md-2">
                        <div class="form-group">
					    	<input 	ng-model="CAM" 
					    			name="CAM"
                                    id="CAM"
                                    value='<?php echo $CAM; ?>'
					    			ng-init="loadRegistro('<?php echo $CAM; ?>')"
					    			type="hidden">
                            <h4>{{CAM}}</h4>
                        </div>
					</div>
                        <div class="col-md-1" ng-show="muestraRAM">
                            <label for="Lote">RAM:  </label>
                        </div>
                        <div class="col-md-8" ng-show="muestraRAM">
                            <div class="form-group">
                                <input 	ng-model="RAM" 
                                        name="RAM"
                                        id="RAM"
                                        value='<?php echo $RAM; ?>'
                                        ng-init="RAM='<?php echo $RAM; ?>'"
                                        type="hidden">
                                <h4>{{RAM}}</h4>
                            </div>
                        </div>
				</div>


		  		<div class="row">
		  			<div class="col-md-1">
				    	<label for="Cliente">Cliente:  </label> 
				    </div>
		  			<div class="col-md-6">
                        <div class="form-group">
                            {{Cliente}}
                        </div>
					</div>
				</div>
		  		<div class="row">
		  			<div class="col-md-1">
				    	<label for="pdf">PDF OC:  </label>
				    </div>
		  			<div class="col-md-6">
                        <div class="form-group">
                            <input name="pdfOC" type="file" id="pdfOC" class="form-control">
                        </div>
					</div>
                    <div class="col-md-5">
                        <?php
                                $directorioDocOC="Y://AAA/Archivador/CAM-".$CAM."/OC";
                                if(file_exists($directorioDocOC)){
                                    $doc = 'DOC/CAM-'.$CAM.'/OC/OC-'.$CAM.'.pdf';
                                    if(file_exists($doc)){
                                        echo "<a href='$doc' target='_blank' class='btn btn-primary btn-block'>Orden de Compra</a>";
                                    }
                                }
                            ?>

                    </div>
				</div>
		  		<div class="row" ng-if="HES == 'on'">
		  			<div class="col-md-1">
				    	<label for="pdfHES">PDF HES:  </label>
				    </div>
		  			<div class="col-md-6">
                        <div class="form-group">
                            <input id="pdfHES" name="pdfHES"  type="file" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-5">
                            <?php
                                $directorioDocHES="Y://AAA/Archivador/CAM-".$CAM."/HES";
                                if(file_exists($directorioDocHES)){
                                    $doc = 'DOC/CAM-'.$CAM.'/HES/HES-'.$CAM.'.pdf';
                                    if(file_exists($doc)){
                                        echo "<a href='$doc' target='_blank' class='btn btn-primary btn-block'>HES</a>";
                                    }
                                }
                            ?>
					</div>
				</div>

				
		  	</div>
		  	<div class="card-footer">
		  		
		  		<button type="submit" 
                        name="SubirDocumentos"
		  				class="btn btn-info">
		  				Subir Documentos
		  		</button>

                  <a class="btn btn-primary" href="plataformaCotizaciones.php"> Volver</a>

		  	</div>
		</div>
        </form>
	</div>


	<script src="cotizaciones.js"></script>
</body>
</html>