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
		echo "entro por empty";
		include('Smarty/libs/Smarty.class.php');
	    $html=new Smarty;
	    $id=$_GET["id"];
	    $query="select * from parametros where id='$id'";
	    $res=$db->query($query);
	    if($db->affected_rows==1)
	    {
	    	$fila=$res->fetch_array();
	    	$cad=array("cad"=>$fila["cad"], "id"=>$fila["id"]);
	    	$html->assign("cad",$cad);
	    	$html->display("editar_cad.html");
	    }else
	    {
	    	$html->display("error.html");
	    }
	}
	else
	{
		$id=$_POST["id"];
		$cad=$_POST["cad"];
		$query="Update parametros set cad='$cad'";
		$db->query($query);
		header("location: index.php");
	}
}
?>