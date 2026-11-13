<?php
require_once __DIR__ . '/config.php';
session_start();
if(empty($_SESSION["admin"]))
{
    header("location: acceso.php");
}
ini_set('date.timezone','America/Argentina/Buenos_Aires'); 
$usuario = $_SESSION["admin"];
$servername = cotizador_config('DB_HOST');
$database = cotizador_config('DB_NAME');
$username = cotizador_config('DB_USER');
$password = cotizador_config('DB_PASSWORD');
$file = $usuario.'_datos.txt';
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
$resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
$row = mysqli_fetch_array($resultado);
$nombre_usuario = $row["nombre"].' '.$row['apellido'];
$cod = $row['cod_personal'];

$id = $_POST['id_borra'];
$chapa = $_POST['pat'];

echo "La ID es: ".$id;
echo"<br>";
$sql = "DELETE  FROM cotizados WHERE id = '$id'";
mysqli_query($conn, $sql);

$sql = "DELETE  FROM funcionamiento  WHERE  id_cliente='$id' ";
mysqli_query($conn, $sql);


$sql = "DELETE  FROM aspecto_exterior WHERE id_cliente='$id'";
mysqli_query($conn, $sql);
$id_exterior = mysqli_insert_id($conn);

mysqli_query($conn, "DELETE FROM chapa_pintura WHERE id_exterior='$id_exterior");

mysqli_query($conn, "DELETE FROM chapa_rayada WHERE id_exterior='$id_exterior");


$sql = "DELETE  FROM interior WHERE id_cliente='$id'";
mysqli_query($conn, $sql);

$sql = "DELETE  FROM cub_accesorios WHERE id_cliente='$id'";
mysqli_query($conn, $sql);

                $servidor_ftp = cotizador_config('FTP_HOST');
                $conexion_id = ftp_connect($servidor_ftp);
                $ftp_usuario = cotizador_config('FTP_USER');
                $ftp_clave = cotizador_config('FTP_PASSWORD');
               
                $ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/"; //Carpeta en Montoriniusados

                ///FTP SELVA
                //$ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/var/www/html/info/";
                //$ftp_carpeta_remota= "/tu_carpeta/remota/";//ORIGINAL
                $ftp_carpeta_remota= "/";
                $mi_nombredearchivo=$_SESSION["admin"]."_datos.txt";
           
                $nombre_archivo = $ftp_carpeta_local.$mi_nombredearchivo;
                $archivo_destino = $ftp_carpeta_remota.$id.'_'.$_SESSION["admin"].'_'.$cod.'_'.date("d-m-Y_H-i-s").'_'.$chapa.'_del.txt';
                $resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave);
                if ((!$conexion_id) || (!$resultado_login)) {
                    echo  "La conexion ha fallado! al conectar con  $servidor_ftp para usuario $usuario";
                    exit;
                } else {
                    echo "Conectado con $servidor_ftp, para usuario $usuario";
                }

                ftp_pasv($conexion_id, true);

                $upload = ftp_put($conexion_id, $archivo_destino, $nombre_archivo, FTP_BINARY);
                if (!$upload) {
                    echo "Ha ocurrido un error al subir el archivo";
                } else {
                    
                    //echo "<h5>Archivo ". $archivo_destino." Enviado  </H5>";
                }
                ftp_close($conexion_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="view port" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Montironi</title>
	<link rel="icon" type="image/png" href="car3.png" />
	<link rel="icon" href="car.ico" type="image/x-icon">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
</head>
<body id="page-top">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><strong>MONTIRONI</strong></a>
      <h6 style="color:white">Usuario:<?php echo ' '.$nombre_usuario; ?>
			<a id="salir" style="margin-left:1em;"  href="salir.php">Cerrar Sesión</a></h6>
    </div> 
  </nav>
	<section class="bg-primary text-white">
    <div class="container text-center">
		<div class="row">
			<div class="col-lg-8 mx-auto" style="margin-top:-4em">
         
                         
                <?php
                echo "<h5>Archivo ". $archivo_destino." Enviado  </H5>";
                ?>
                                 
            </div>
        </div><br>
             <a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
        <?php
      
        ?>
       
        
    
    </div>
    
	</section>