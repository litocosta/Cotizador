<?php
require_once __DIR__ . '/config.php';
//include('contra.php');
session_start();
$usuario=$_POST["usuario"];
$pass=$_POST["pass"];
$pass=md5($pass);
include('Smarty/libs/Smarty.class.php');
$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
$html=new Smarty;
$query="select id, usuario, control from usuarios where usuario='$usuario' and pass='$pass'";
$control=array();
$resultado=$db->query($query);
$valor=$resultado->fetch_array();
$control[$valor["usuario"]]=array("id"=>$valor["id"], "usuario"=>$valor["usuario"], "control"=>$valor["control"]);
/*echo "El usuario es: ".$usuario;*/
$user=$valor["usuario"];
/*echo "el user es: ".$user;
echo "columnas:".$db->affected_rows;
echo "control: ".$valor["control"];*/
if($db->affected_rows==1)
{
	$_SESSION["admin"]=$usuario;
	$sesion=$_SESSION["admin"];
	$cola="select * from usuarios";
	$cola_res="Update usuarios set control='$sesion' where usuario='$usuario'";
	$db->query($cola);
	$db->query($cola_res);
	/*echo "La pass de admin es correcta";
	/*sleep(10);*/
	header("location: index.php");
	//}
}
else
{
	$html->display("error.html");
	/*echo "Contraseña incorrecta";*/
}

?>