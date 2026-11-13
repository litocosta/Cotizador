<?php
require_once __DIR__ . '/../config.php'; 

include('Smarty/libs/Smarty.class.php');
$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER_2'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME_3'));
$html=new Smarty;
$rutaEnServidor='imagenes';
$rutaTemporal=$_FILES['imagen']['tmp_name'];
$nombreImagen=$_FILES['imagen']['name'];
$rutaDestino=$rutaEnServidor.'/'.$nombreImagen;
move_uploaded_file($rutaTemporal,$rutaDestino);

$desc=$_POST['descripcion'];
$altura=$_POST['altura'];
$fondo=$_POST['fondo'];
$dos=$_POST['dos'];
$tres=$_POST['tres'];
$sillon=$_POST['sillon'];
$pie_l=$_POST['pie_l'];
$pie_a=$_POST['pie_a'];
$pie_f=$_POST['pie_f'];
$puff_l=$_POST['puff_l'];
$puff_a=$_POST['puff_a'];
$puff_f=$_POST['puff_f'];
$izq=$_POST['izq'];
$der=$_POST['der'];
$l_pie=$_POST['l_pie'];

/*echo $nombreImagen;*/
if($nombreImagen=="")
{
	$html->display("error2.html");

}
else
{
	$sql="INSERT INTO datos 
	(ruta,descripcion,altura,fondo,dos_cuerpos,tres_cuerpos,sillon,pie_f,pie_l,pie_a,puff_f,puff_l,puff_a,Izq,der,l_pie) 
	values
	('".$rutaDestino."','".$desc."','".$altura."','".$fondo."','".$dos."','".$tres."','".$sillon."'
	,'".$pie_f."','".$pie_l."','".$pie_a."','".$puff_f."','".$puff_l."','".$puff_a."','".$izq."','".$der."','".$l_pie."')";
	$res=$db->query($sql);
	if($Res)
	{
		print '<script language="JavaScript">'; 
		print 'alert("mensaje");'; 
		print '</script>';
	}
	 header("location: index.php");	
}
?>