<?php
require_once __DIR__ . '/config.php';
$servername = cotizador_config('DB_HOST');
$database = cotizador_config('DB_NAME');
$username = cotizador_config('DB_USER');
$password = cotizador_config('DB_PASSWORD');
$cod_prov=$_POST['idproveedor'];
$conn = mysqli_connect($servername, $username, $password, $database);
$sql = "SELECT * FROM municipios WHERE provincia = '$cod_prov' ORDER BY localidad";
$resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
//$row = mysqli_fetch_array($resultado);
echo '<option value="">Seleccionar</option>';
while ($row=mysqli_fetch_array($resultado))
{
    echo '<option value="'.$row['id'].'">'.utf8_encode($row['localidad']).'</option>';
    //echo '<option value="'.$row['id'].'">'.mysqli_num_rows($resultado).'</option>';
}
                           

?>