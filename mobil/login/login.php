<?php
session_start();
include_once("conexion.php");
$username = $_POST['name'];
$password = $_POST['pwd'];
$link=Conectarse();
$bdusr=mysql_query("SELECT * FROM Usuarios Where usr Like '".$username."'");
if($row=mysql_fetch_array($bdusr)){
	echo 'true';
	$_SESSION['user_name']=$row['usr'];
}else{
	echo 'false';
}
?>