<?php
require_once __DIR__ . '/../config.php';
//include('../contra.php');
session_start();
if(empty($_SESSION["admin"]))
{
	header("location: acceso.php");
}else{
	include('Smarty/libs/Smarty.class.php');
    $db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
    $html=new Smarty;
	$id=$_GET["id"];
	$query="select id, usuario from usuarios where id='$id'";
	$res=$db->query($query);
	$valor=$res->fetch_array();
	if($db->affected_rows==1)
	{
		if($valor["usuario"]=="admin")
			{
				echo "NO se puede ELIMINAR el usuario admin";
			}
		else
		{
			$query="Delete from usuarios where id='$id'";
			$db->query($query);
			header("location: index.php");
			
		}

	}else{
		$html->display("error.html");
	}
}
	
?>