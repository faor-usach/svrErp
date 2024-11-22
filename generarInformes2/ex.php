<?
// Lee la plantilla
$plantilla = file_get_contents('plan.rtf');

// Agregamos los escapes necesarios
$plantilla = addslashes($plantilla);
$plantilla = str_replace('r','\r',$plantilla);
$plantilla = str_replace('t','\t',$plantilla);

// Datos de la plantilla
$nombre = "Juan";
$apellido = "Perez";
$prefijo = "Sr.";
$curso = "Programacion Web con PHP";
//$fecha = date("d-m-Y", time() – 7 * 24 * 60 * 60); // de esta manera el codigo no envejece :P

// Procesa la plantilla
eval( '$rtf = <<<EOF_RTF' . $plantilla . 'EOF_RTF;' );

// Guarda el RTF generado
file_put_contents("salida.rtf",$rtf);
$salida = "salida.rtf";
$salida = "<a href='$salida'>Obtener</a>";
echo "<p>$salida</p>";
?>
