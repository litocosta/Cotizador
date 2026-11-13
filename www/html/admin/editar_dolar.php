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
	    	$dolar=array("dolar"=>$fila["dolar"], "id"=>$fila["id"]);
	    	$html->assign("dolar",$dolar);
	    	$html->display("editar_dolar.html");
	    }else
	    {
	    	$html->display("error.html");
	    }
	}
	else
	{
		$id=$_POST["id"];
		$dolar=$_POST["dolar"];
		$query="Update parametros set dolar='$dolar'";
		$db->query($query);
		header("location: index.php");
	}
}
?>