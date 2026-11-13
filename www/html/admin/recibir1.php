<?php
require_once __DIR__ . '/../config.php'; 
/*$conexion=mysql_connect(cotizador_config('DB_HOST'),cotizador_config('DB_USER'),'') or die('No hay conexión a la base de datos');
$db=mysql_select_db(cotizador_config('DB_NAME_2'),$conexion)or die('no existe la base de datos.');*/
include('Smarty/libs/Smarty.class.php');
$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER_2'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME_3'));
$html=new Smarty;
$rutaEnServidor='imagenes';
$rutaTemporal=$_FILES['imagen']['tmp_name'];
$nombreImagen=$_FILES['imagen']['name'];
$rutaDestino=$rutaEnServidor.'/'.$nombreImagen;
move_uploaded_file($rutaTemporal,$rutaDestino);

$desc=$_POST['descripcion'];
echo $nombreImagen;
if($nombreImagen=="")
{
	$html->display("error2.html");

}
else
{
	$sql="INSERT INTO datos (ruta,descripcion) values('".$rutaDestino."','".$desc."')";
	$res=$db->query($sql);
	if($Res)
	{
		print '<script language="JavaScript">'; 
		print 'alert("mensaje");'; 
		print '</script>';
	}
	 header("location: index.php");	
}


/*if ($res){
	
	/*sleep(2);
	echo 'inserción con exito';
	header("location: index.php");
}
else
{
    echo 'no se puedo insertar';
    header("location: index.php");
} */

?>