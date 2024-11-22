<?php
$letraItem++;

$tituloOpcion = array(
							'font' 				=> 'Arial',
							'fontSize'			=> 10,
							'underline'			=> 'single',
							'bold'				=> true,
							//'spacingTop' 		=> 150,
							//'spacingBottom' 	=> 150,
							//'lineSpacing'		=> 450,
						);

$text = $letraItem.'.- Resultados de Análisis Químico:';
$docx->addText($text, $tituloOpcion);

$text = '';
$docx->addText($textSpace, $espacioOpcion);

$SubTituloOpcion = array(
							'font' 				=> 'Arial',
							'fontSize'			=> 10,
							//'spacingTop' 		=> 150,
							//'spacingBottom' 	=> 150,
							'lineSpacing'		=> 360,
						);

$text = "En la tabla $letraItem $i se muestran los valores resultantes del análisis químico, obtenido mediante espectrometría de emisión óptica.";
					
$docx->addText($text, $SubTituloOpcion);

// Tabla Químicos
$tQu = array('  ID ITEM','%C','%Si','%Mn','%P','%S','%Cr','%Ni','%Mo','%Al','%Cu');

$i = 0;
$bdOT=$link->query("SELECT * FROM otams Where CodInforme = '".$CodInforme."' and idEnsayo = 'Qu' Order By Otam");
if($rowOT=mysqli_fetch_array($bdOT)){
	do{
		$i++;
		if($rowOT['tpMuestra']=='Ac' and $rowTabEns['Ref']=='SR'){
			include('expTitQuiAc.php');
			//include('expDatQuiAc.php');
		}
	}while($rowOT=mysqli_fetch_array($bdOT));
}

// Fin
?>
