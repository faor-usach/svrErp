<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$dato = json_decode(file_get_contents("php://input"));

include("../conexionli.php");  
$res = '';

if($dato->accion == "EstadoOff"){
    $link=Conectarse();
    $newCotizacion = 'off';

    $SQL = "SELECT * FROM controltablas Where newCotizacion != ''";
    $bd=$link->query($SQL);
    if($rs=mysqli_fetch_array($bd)){
        $actSQL  ="UPDATE controltablas SET ";
        $actSQL .= "newCotizacion 	= '".$newCotizacion.	"'";
        $bd=$link->query($actSQL);
    }
    $link->close();
}

if($dato->accion == "ConsultaEstado"){
    $link=Conectarse();

    $SQL = "SELECT * FROM controltablas";
    $res = '';
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){
        if ($res != "") {$res .= ",";}
        $res.= '{"newCotizacion":"'.$rs["newCotizacion"].'"}';
    }
    $link->close();
    /*
    $res ='{"records":['.$res.']}';
    echo ($res);
    */
    echo $res;
}
?>