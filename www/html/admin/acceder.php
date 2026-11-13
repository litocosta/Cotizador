<?php
require_once __DIR__ . '/../config.php';
//include('../contra.php');
session_start();
include('Smarty/libs/Smarty.class.php');
$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
$html=new Smarty;
$usuario=$_POST["usuario"];
$pass=$_POST["pass"];
$pass=md5($pass);
if($usuario=="admin")
{
	$query="select usuario from usuarios where usuario='$usuario' and pass='$pass'";
	$resultado="Update usuarios set control='1' where usuario='$usuario'";
	$db->query($resultado);
	$db->query($query);
	/*echo "El usuario es Admin";*/
	if($db->affected_rows==1)
	{
		$_SESSION["admin"]=1;
		$cola="select * from usuarios";
		$cola_res="Update usuarios set control='0' where usuario!='$usuario'";
		$db->query($cola);
		$db->query($cola_res);
		/*echo "La pass de admin es correcta";*/
		/*sleep(10);*/
		header("location: index.php");
	}
	else
	{
		$html->display("error.html");
		/*echo "Contraseña incorrecta";*/
	}
}
else
{
	/*$total = mysql_num_rows(mysql_query("select usuario from usuarios where usuario='$usuario' and pass='$pass'"));
	echo $total;
	if($total==0)*/
	$query="select usuario from usuarios where usuario='$usuario' and pass='$pass'";
	$resultado="Update usuarios set control='1' where usuario='$usuario'";
	$db->query($resultado);
	$db->query($query);
	if($db->affected_rows<>1)
	{
		$html->display("error.html");	
		/*echo "No existe el usuario o la contraseña es incorecta";*/
	}
	else
	{
		$_SESSION["admin"]=1;
		$cola="select * from usuarios";
		$cola_res="Update usuarios set control='0' where usuario!='$usuario'";
		$db->query($cola);
		$db->query($cola_res);
		header("location: index.php");
	}
}
?>