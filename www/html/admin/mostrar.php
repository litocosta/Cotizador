

<?php
require_once __DIR__ . '/../config.php'; 
/*$conexion=mysql_connect(cotizador_config('DB_HOST'),cotizador_config('DB_USER'),'') or die('No hay conexión a la base de datos');
$db=mysql_select_db(cotizador_config('DB_NAME_2'),$conexion)or die('no existe la base de datos.');*/

include('Smarty/libs/Smarty.class.php');
$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER_2'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME_3'));
$html=new Smarty;

/*$consulta=mysql_query("select * from datos");*/

$query="select ruta, descripcion from datos";
$res=$db->query($query);

while($filas=$res->fetch_array())
{
	$ruta=$filas['ruta'];
	$desc=$filas['descripcion'];
	?>
	<?php echo $desc;?><br>
 	<a class='gallery' href='<?php echo $ruta; ?>'><img src='<?php echo $ruta; ?>' width='150'></a>
	<!--<img src="<?php echo $ruta; ?>" width="180" height="214"><br>-->
<?php 

}?>