<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once("../conexionli.php");
	date_default_timezone_set("America/Santiago");
	
	$nContacto = 0;
	$Contacto = '';
	
	if(isset($_GET['Cliente'])) 	{ $Cliente  	= $_GET['Cliente']; 	}
	if(isset($_GET['nContacto']))	{ $nContacto	= $_GET['nContacto']; 	}
	if(isset($_GET['Atencion']))	{ $Contacto		= $_GET['Atencion']; 	}
	if(isset($_GET['CAM'])) 		{ $CAM  		= $_GET['CAM']; 		}
	if(isset($_GET['Rev'])) 		{ $Rev  		= $_GET['Rev']; 		}
	if(isset($_GET['Cta'])) 		{ $Cta  		= $_GET['Cta']; 		}
	//echo $Cliente.' '.$nContacto;
	$link=Conectarse();
	if($Contacto == ''){
		$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$Cliente."' and nContacto = '".$nContacto."'");
		if($rowCon=mysqli_fetch_array($bdCon)){
			$Contacto  = $rowCon['Contacto'];
			$nContacto = $rowCon['nContacto'];
		}
	}
	?>
	<input name="nContacto" id="nContacto" type="hidden" value="<?php echo $nContacto;?>">
	<select name="nContacto" id="nContacto"  style="font-size:12px; font-weight:700;" onChange="datosContactos($('#Cliente').val(), $('#Contacto').val(), $('#nContacto').val())">
		<option></option>
	<?php
	$bdCon=$link->query("SELECT * FROM contactosCli Where RutCli = '".$Cliente."'");
	if($rowCon=mysqli_fetch_array($bdCon)){
		do{
			if($rowCon['nContacto'] == $nContacto){
				echo '	<option selected 	value="'.$rowCon['nContacto'].'">'.$rowCon['Contacto'].'</option>';
			}else{
				echo '	<option  			value="'.$rowCon['nContacto'].'">'.$rowCon['Contacto'].'</option>';
			}
		}while ($rowCon=mysqli_fetch_array($bdCon));
		
	}
	?>
	</select>
	<?php
	$link->close();
	?>