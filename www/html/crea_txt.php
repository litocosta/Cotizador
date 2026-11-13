<?php
require_once __DIR__ . '/config.php';
$servername = cotizador_config('DB_HOST');
$database = cotizador_config('DB_NAME');
$username = cotizador_config('DB_USER');
$password = cotizador_config('DB_PASSWORD');
$conn = mysqli_connect($servername, $username, $password, $database);
   // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo getdate();
//$time = time();
ini_set('date.timezone','America/Argentina/Buenos_Aires'); 
$hora = date("d-m-Y_H-i-s");
echo $hora;
$file = 'datos'.$hora.'.txt';
$sql = "SELECT nombre, apellido, email FROM cotizados ";
$resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
if( $resultado )
{

      //Ahora valida que la consuta haya traido registros
    if( mysqli_num_rows( $resultado ) > 0)
    {
        $jump = "\r\n";
        $separator = "\t";
        $fp = fopen($file, 'a');
        $tabla = "cotizados" . $jump;
        fwrite($fp, $tabla);
        $registro = 'nombre' . $separator . 'apellido' . $separator . 'email' . $separator . $jump;
        fwrite($fp, $registro);
        while($row = mysqli_fetch_array($resultado)) {
            $registro = $row['nombre'] . $separator . $row['apellido'] . $separator . $row['email'] . $jump;
            fwrite($fp, $registro);
        }
        fclose($fp);
        chmod($file, 0777);
    }
    
}

echo 'Se han guardado '.mysqli_num_rows($resultado).' registros en el txt!';
?>