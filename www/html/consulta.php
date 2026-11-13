<?php
require_once __DIR__ . '/config.php';
$servername = cotizador_config('DB_HOST');
$database = cotizador_config('DB_NAME');
$username = cotizador_config('DB_USER');
$password = cotizador_config('DB_PASSWORD');
$cod_prov=$_POST['idproveedor'];
$provi=$_POST['provi'];
//echo "Municipio: ".$provi;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Montironi</title>
	<link rel="icon" type="image/png" href="car3.png" />
	<link rel="icon" href="car.ico" type="image/x-icon">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <script src="jquery.min.js"></script>
    <script src="validar.js"></script>
    <script src="validarE.js"></script>
</head>
<script> 
 function selecciona(val)
        {
            document.getElementById("loca2").value = val;
            document.getElementById("productos").style.visibility = "hidden";
            document.getElementById("productos").size = "0";
        }
</script>
</html>
<?php
$conn = mysqli_connect($servername, $username, $password, $database);
$sql = "SELECT * FROM municipios WHERE provincia = '$cod_prov' AND localidad LIKE '$provi%' ORDER BY localidad";
//$sql = "SELECT * FROM municipios WHERE localidad LIKE '$provi'";
$resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
//$row = mysqli_fetch_array($resultado);
//echo '<option value="">Seleccionar</option>'.$provi;
while ($row=mysqli_fetch_array($resultado))
{
    $sel = $row['localidad'];
    echo ' <input type="text" name="sel" id="sel" value="'. $row['localidad'].'">';
    //echo '<option value="'.$row['id'].'" onclick="selecciona(this.value)">'.utf8_encode($row['localidad']).'</option>';
    echo '<option value="'.$row['localidad'].'" onclick="selecciona(this.value)">'.utf8_encode($row['localidad']).'</option>';
    //echo '<option value="'.$row['id'].'">'.mysqli_num_rows($resultado).'</option>';
}
                           

?>