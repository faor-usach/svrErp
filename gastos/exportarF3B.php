<?php
//Exportar datos de php a Excel
$nForm = "F3B-1.xls";
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reportes.xls");
?>
<HTML LANG="es">
<TITLE>::. Exportacion de Datos .::</TITLE>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="14%" rowspan="4"><img src="logos/sdt.png" width="180" height="90"></td>
    <td width="71%">&nbsp;</td>
    <td width="15%" rowspan="4"><img src="logos/logousach.png" width="91" height="138"></td>
  </tr>
  <tr>
    <td><div align="center" class="botongrabar">UNIVERSIDAD DE SANTIAGO DE CHILE</div></td>
  </tr>
  <tr>
    <td><div align="center" class="botongrabar">SOCIEDAD DE DESARROLLO TECNOL&Oacute;GICO</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="2" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="36%"><div align="center" class="botongrabar">FORMULARIO N&ordm; 3B</div></td>
    <td width="64%" class="botongrabar">SOLICITUD DE REEMBOLSO</td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="1" cellspacing="0" cellpadding="0">
  <td width="80">CODIGO</td>
      <td width="61">MARCA</td>
      <td width="209">DESCRIPCION</td>
      <td width="107">MODELO</td>
      <td width="86">NRO_ORIGINAL</td>
      <td width="76">FABRICANTE</td>
      <td width="36">ANO</td>
      <td width="52">PRECIO</td>
      <td width="44">STOCK</td>
      <td width="46">cod</td>
</table>
<p>&nbsp;</p>
</body>
</html>