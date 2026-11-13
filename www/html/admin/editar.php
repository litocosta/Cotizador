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
	if(empty($_POST))
	{
		//echo "entro por empty";
		include('Smarty/libs/Smarty.class.php');
	    $html=new Smarty;
	    $id=$_GET["id"];
	    $query="select * from usuarios where id='$id'";
	    $res=$db->query($query);
	    if($db->affected_rows==1)
	    {
	    	$fila=$res->fetch_array();
			$usuario=array("usuario"=>$fila["usuario"], "nombre"=>$fila["nombre"], "apellido"=>$fila["apellido"], "ver"=>$fila["ver_valor"],
						   "tipo"=>$fila["tipo"], "cod"=>$fila["cod_personal"], "pass"=>$fila["pass"], "id"=>$fila["id"]);
	    	$html->assign("usuario",$usuario);
	    	$html->display("editar.html");
	    }else
	    {
	    	$html->display("error.html");
	    }
	}
	else
	{
		$id=$_POST["id"];
		$usuario=$_POST["usuario"];
		$passantigua=$_POST["passantigua"];
		$pass=$_POST["pass"];
		$codant=$_POST["codant"];
		$nombre=$_POST["nombre"];
		$apellido=$_POST["apellido"];
		$precio=$_POST["precio"];
		$acceso=$_POST["acceso"];
		$cod=$_POST["cod"];

		$query="Update usuarios set usuario='$usuario'";
		if(!empty($pass))
		{
			$pass=md5($pass);
			$query.=", pass='$pass'";
		}
		if(!empty($codant))
		{
			//$pass=md5($pass);
			$query.=", cod_personal='$codant'";
		}
		if(!empty($nombre))
		{
			//$pass=md5($pass);
			$query.=", nombre='$nombre'";
		}
		if(!empty($apellido))
		{
			//$pass=md5($pass);
			$query.=", apellido='$apellido'";
		}
		if(!empty($acceso))
		{
			//$pass=md5($pass);
			$query.=", tipo='$acceso'";
		}
		if(!empty($precio))
		{
			//$pass=md5($pass);
			$query.=", ver_valor='$precio'";
		}

		$query.="Where id='$id'";
		$db->query($query);
		header("location: index.php");
	}
}
?>