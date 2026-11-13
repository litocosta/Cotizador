<?php
require_once __DIR__ . '/../config.php';
//include('../contra.php');
session_start();
if(empty($_SESSION["admin"]))
{
	header("location: acceso.php");
}
else
{
	$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
	$nombre=$_POST["nombre"];
	$apellido=$_POST["apellido"];
	$usuario=$_POST["usuario"];
	$cod=$_POST["cod"];
	$acc=$_POST["acceso"];
	$pass=$_POST["pass"];
	$pass=md5($pass);
	$control='';
	$query = "SELECT * FROM usuarios WHERE usuario=$usuario";
	echo $db->affected_rows;
	$res=$db->query($query);
	if($db->affected_rows < 1)
	{
		$query="insert into usuarios(nombre,apellido,usuario,pass,control,cod_personal,tipo) 
			values('$nombre','$apellido','$usuario','$pass','$control','$cod','$acc')";
		$db->query($query);
		header("location: index.php");	
	}
	else
	{
		echo '<script type="text/javascript">alert("El usuario ya existe"); window.location="index.php"</script>';
		
	}
	
		
}
?>