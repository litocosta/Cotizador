<?php
require_once __DIR__ . '/config.php';
//include('contra.php');
session_start();
$sesion=$_SESSION["admin"];
/*echo $sesion;*/
$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
$query="select id, usuario, control from usuarios";
$control=array();
$resultado=$db->query($query);
$valor=$resultado->fetch_array();

$resultado="Update usuarios set control='' where control='$sesion'";
$db->query($resultado);
session_destroy();
clearstatcache();
header("location: index.php");
?>