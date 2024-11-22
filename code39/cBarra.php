<?php
	$Run 		= "";
	$nMat 		= "";
	$cBarra 	= "7501013100198";
	$cBarra 	= "7780123456001";
	
	// 780
	// Pais
	//$codBarra 	= "7805633004608";
	//			   123456789012
	$Pais	= '780';
	$cRAM	= 7000;
	if($cRAM<10000){
		$cRam = '0'.$cRAM;
	}
	$cLet = ord('T');
	
	$codBarra 	= "780999991401"; 
	$codBarra 	= "780070008401";
	$codBarra	= $Pais.$cRam.$cLet.'01';
	
	$cPais = array(
				'780' => 'Chile',
				'789' => 'Brazil',
				'805' => 'Italia'
					);

	if(isset($_POST['Run']))		{ $Run 	= $_POST['Run']; 			}
	if(isset($_POST['nMat']))		{ $nMat = $_POST['nMat']; 			}
	if(isset($_POST['Pais']))		{ $Pais = $_POST['Pais']; 			}
	if(isset($_POST['codBarra']))	{ $codBarra = $_POST['codBarra']; 	}

	if(isset($_POST['gBarra'])){ 
		$cBarra = digitoControl($Run,$nMat,$Pais);
		$codBarra = lectorBarra($codBarra);
	}
	
	function digitoControl($r, $m, $p){
		$cb = $p.substr($r,0,6).$m;
		$si = 0;
		$sp = 0;
		$bc = "";
		$lg = strlen($cb);
		for($i=$lg; $i>=0; $i--){
			$bc .= substr($cb,$i,1);
		}
		for($i=0; $i<=$lg; $i++){
			if($i==0){
				$si += substr($bc,$i,1);
			}else{
				if($i/2==(intval($i/2))){
					$si += substr($bc,$i,1);
				}else{
					$sp += substr($bc,$i,1);
				}
			}
		}
		
		$dc = (($si*3)+$sp);
		$f  = intval(($dc+10)/10)*10;
		$dc = $f-(($si*3)+$sp);
		if($dc==10){ $dc = 0; }
		$dc = $cb.$dc;
		return $dc;
	}

	function lectorBarra($c){
		$bc = $c;
		$si = 0;
		$sp = 0;
		for($i=0; $i<12; $i++){
			if($i==0){
				$si += substr($bc,$i,1);
			}else{
				if($i/2==(intval($i/2))){
					$si += substr($bc,$i,1);
				}else{
					$sp += substr($bc,$i,1);
				}
			}
		}
		
		$dc = (($sp*3)+$si);
		$f  = intval(($dc+10)/10)*10;
		$dc = $f-(($sp*3)+$si);
		if($dc==10){ $dc = 0; }
		if($dc == substr($bc,12,1)){
			$dc = $c;
		}else{
			$dc = 'Error';
		}
		return $dc;
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Code 39 barcodes</title>
<style type="text/css">
body {font-family:"Times New Roman",serif}
h1 {font:bold 135% Arial,sans-serif; color:#4000A0; margin-bottom:0.9em}
h2 {font:bold 95% Arial,sans-serif; color:#900000; margin-top:1.5em; margin-bottom:1em}
</style>
</head>
<body>
<form action="cBarra.php" method="post">
	<table border="1" cellpadding="0" cellspacing="0" width="100%">
		<tr>
		  <td>Cod.Pais</td>
		  <td>
				<input name="Pais" type="text" value="<?php echo $Pais; ?>">
				<?php echo $cPais[$Pais]; ?>
		  </td>
		<tr>
		  <td>RUN</td>
		  <td>
				<input name="Run" type="text" value="<?php echo $Run; ?>">      		
		  </td>
	  </tr>
		<tr>
	    	<td width="19%">Nº Mat.</td>
	  	    <td width="81%">
				<input name="nMat" type="text" value="<?php echo $nMat; ?>">      		
			</td>
		</tr>
		<tr>
	    	<td width="19%">Cód.Barra</td>
	  	    <td width="81%">
				<input name="codBarra" type="text" value="<?php echo $codBarra; ?>">
				<?php echo 'Pais... '.$cPais[substr($codBarra,1,3)]; ?>
			</td>
		</tr>
		<tr>
	    	<td colspan="2">
				<button name="gBarra">
					Generar Barra
				</button>
	    	</td>
	  	</tr>
		<tr>
	    	<td colspan="2">
	      		<?php echo '<img src="http://barcode.tec-it.com/barcode.ashx?code=EAN13&modulewidth=fit&data='.$cBarra.'&dpi=96&imagetype=png&rotation=0&color=&bgcolor=&fontcolor=&quiet=0&qunit=mm&download=true" alt="Generador de código de barras TEC-IT"/>'; ?>
	      		<?php 
					echo '<img width="120" src="http://barcode.tec-it.com/barcode.ashx?code=EAN13&modulewidth=fit&data='.$codBarra.'&dpi=96&imagetype=png&rotation=0&color=&bgcolor=&fontcolor=&quiet=0&qunit=mm&download=true" alt="Generador de código de barras TEC-IT"/><br>';
				?>
	    	</td>
	  	</tr>
	</table>
</form>
</body>
</html>
