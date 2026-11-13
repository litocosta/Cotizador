

<?php
require_once __DIR__ . '/../../config.php'; 
$conexion=mysql_connect(cotizador_config('DB_HOST'),cotizador_config('DB_USER'),'') or die('No hay conexión a la base de datos');
$db=mysql_select_db(cotizador_config('DB_NAME_2'),$conexion)or die('no existe la base de datos.');

$consulta=mysql_query("select * from datos");
while($filas=mysql_fetch_array($consulta)){
	$ruta=$filas['ruta'];
	$desc=$filas['descripcion'];


?>

<?php echo $desc;?><br>
<img src="<?php echo $ruta; ?>" width="180" height="214"><br>

<?php }?>