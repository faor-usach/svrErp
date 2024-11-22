<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$dato = json_decode(file_get_contents("php://input"));
include("../conexionli.php"); 
$link=Conectarse();

if($dato->Moneda == 'U'){
    $link->query("insert into dcotizacion    (
                                                CAM,
                                                nLin,
                                                nServicio,
                                                Cantidad,
                                                unitarioUF,
                                                NetoUF,
                                                IvaUF,
                                                TotalUF
                                            )    
                                  values    (   '$dato->CAM',
                                                '$dato->nLin',
                                                '$dato->nServicio',
                                                '$dato->Cantidad',
                                                '$dato->unitarioUF',
                                                '$dato->NetoUF',
                                                '$dato->IvaUF',
                                                '$dato->TotalUF'
                                            )");
}
if($dato->Moneda == 'P'){
    $link->query("insert into dcotizacion    (
                                                CAM,
                                                nLin,
                                                nServicio,
                                                Cantidad,
                                                unitarioP,
                                                Neto,
                                                Iva,
                                                Bruto
                                            )    
                                  values    (   '$dato->CAM',
                                                '$dato->nLin',
                                                '$dato->nServicio',
                                                '$dato->Cantidad',
                                                '$dato->unitarioP',
                                                '$dato->Neto',
                                                '$dato->Iva',
                                                '$dato->Bruto'
                                            )");
}
if($dato->Moneda == 'D'){
    $link->query("insert into dcotizacion    (
                                                CAM,
                                                nLin,
                                                nServicio,
                                                Cantidad,
                                                unitarioUS,
                                                NetoUS,
                                                IvaUS,
                                                TotalUS
                                            )    
                                  values    (   '$dato->CAM',
                                                '$dato->nLin',
                                                '$dato->nServicio',
                                                '$dato->Cantidad',
                                                '$dato->unitarioUS',
                                                '$dato->NetoUS',
                                                '$dato->IvaUS',
                                                '$dato->TotalUS'
                                            )");
}


$NetoUF     = 0;
$IvaUF      = 0;
$BrutoUF    = 0;
$Neto       = 0;
$Iva        = 0;
$Bruto      = 0;
$NetoUS     = 0;
$IvaUS      = 0;
$BrutoUS    = 0;
$vDscto     = 0;

$SQLc = "SELECT * FROM dcotizacion Where CAM = '$dato->CAM'";
$bdc=$link->query($SQLc);
while($rs=mysqli_fetch_array($bdc)){
    $NetoUF += $rs['NetoUF'];
    $IvaUF += $rs['IvaUF'];
    $BrutoUF += $rs['TotalUF'];
    $Neto += $rs['Neto'];
    $Iva += $rs['Iva'];
    $Bruto += $rs['Bruto'];
    $NetoUS += $rs['NetoUS'];
    $IvaUS += $rs['IvaUS'];
    $BrutoUS += $rs['TotalUS'];
}
if($dato->pDescuento){
    if($dato->Moneda == 'U'){
        $vDscto     = intval($NetoUF * $dato->pDescuento)/100;
        $NetoUF     = $NetoUF - $vDscto;
        $IvaUF      = round($NetoUF * 0.19,2);
        $BrutoUF    = $NetoUF + $IvaUF;
    }
    if($dato->Moneda == 'P'){
        $vDscto     = intval($Neto * $dato->pDescuento)/100;
        $Neto       = $Neto - $vDscto;
        $Iva        = round($Neto * 0.19,2);
        $Bruto       = $Neto + $Iva;
    }
    if($dato->Moneda == 'D'){
        $vDscto     = intval($NetoUS * $dato->pDescuento)/100;
        $NetoUS     = $NetoUS - $vDscto;
        $IvaUS      = round($NetoUS * 0.19,2);
        $BrutoUS    = $NetoUS + $IvaUS;
    }
}
if($dato->exentoIva == 'on'){
    $BrutoUF    = $NetoUF;
    $IvaUF      = 0;
    $Bruto      = $Neto;
    $Iva        = 0;
    $BrutoUS    = $NetoUS;
    $IvaUS      = 0;
}

$SQLcz = "SELECT * FROM cotizaciones Where CAM = '$dato->CAM'";
$bdcz=$link->query($SQLcz);
if($rsz=mysqli_fetch_array($bdcz)){
    $actSQL="UPDATE cotizaciones SET ";
    $actSQL.="exentoIva             = '".$dato->exentoIva.        "', ";
    $actSQL.="pDescuento            = '".$dato->pDescuento.           "', ";
    if($dato->Moneda == 'D'){
        $actSQL.="NetoUS                = '".$NetoUS.                 "', ";
        $actSQL.="IvaUS                 = '".$IvaUS.                  "', ";
        $actSQL.="BrutoUS               = '".$BrutoUS.                "', ";
    }
    if($dato->Moneda == 'U'){
        $actSQL.="NetoUF                = '".$NetoUF.                 "', ";
        $actSQL.="IvaUF                 = '".$IvaUF.                  "', ";
        $actSQL.="BrutoUF               = '".$BrutoUF.                "', ";
    }
    if($dato->Moneda == 'P'){
        $actSQL.="Iva                   = '".$Iva.                    "', ";
        $actSQL.="Neto                  = '".$Neto.                   "', ";
        $actSQL.="Bruto                 = '".$Bruto.                  "', ";
    }
    $actSQL.="Moneda                = '".$dato->Moneda.                "' ";
    $actSQL.="WHERE CAM             = '".$dato->CAM. "'";
    $bdAct=$link->query($actSQL); 
}

$link->close();
?>