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
</head>
<body id="page-top">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><strong>MONTIRONI</strong></a>
      
    </div> 
  </nav>
	<section class="bg-primary text-white">
    <div class="container text-center">
		<div class="row">
			<div class="col-lg-8 mx-auto" style="margin-top:-4em">
            <?php
require_once __DIR__ . '/config.php';
                session_start();
                
                    if(empty($_SESSION["admin"]))
                    {
                        header("location: acceso.php");
                    }
                    ini_set('date.timezone','America/Argentina/Buenos_Aires'); 
                $cod = $_GET['cod'];
                $id = $_GET['id'];
                $usuario = $_SESSION["admin"];
                $chapa  = $_GET['chapa'];
                //echo "COD es ".$cod;
                $servidor_ftp = cotizador_config('FTP_HOST');
                $conexion_id = ftp_connect($servidor_ftp);
                $ftp_usuario = cotizador_config('FTP_USER');
                $ftp_clave = cotizador_config('FTP_PASSWORD');
                //$ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/tu_carpeta/local/";// ORIGINAL

                ///FTP LOCAl
                //$ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/info/";   //capeta el SELVA
                $ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/"; //Carpeta en Montoriniusados

                ///FTP SELVA
                //$ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/var/www/html/info/";
                //$ftp_carpeta_remota= "/tu_carpeta/remota/";//ORIGINAL
                $ftp_carpeta_remota= "/";
                $mi_nombredearchivo=$_SESSION["admin"]."_datos.txt";
                //$mi_nombredearchivo=rename($_SESSION["admin"].'_datos.txt',$_SESSION["admin"].'_datos_'.date("d-m-Y_H-i-s").'.txt');

                $nombre_archivo = $ftp_carpeta_local.$mi_nombredearchivo;
                $archivo_destino = $ftp_carpeta_remota.$id.'_'.$_SESSION["admin"].'_'.$cod.'_'.date("d-m-Y_H-i-s").'_'.$chapa.'.txt';
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
                    //echo "<h1>Subido $nombre_archivo a $servidor_ftp as $archivo_destino</H1>";
                    echo "<h5>Archivo ". $archivo_destino." Enviado  </H5>";
                }
                ftp_close($conexion_id);
                ?>
                <h3>Desea subir fotos ahora?</h3>
                <form action="envio_fotos.php" method="post" enctype="multipart/form-data">
                    <?php
                     $servername = cotizador_config('DB_HOST');
                     $database = cotizador_config('DB_NAME');
                     $username = cotizador_config('DB_USER');
                     $password = cotizador_config('DB_PASSWORD');
                     $conn = mysqli_connect($servername, $username, $password, $database);
                    $sql = "SELECT * FROM cotizados WHERE id='$id'";
                
                    $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
                    //header("Content-Type: text/html;charset=utf-8");

                    $fila = mysqli_fetch_array( $resultado );
                    ?>   
                    
                    <div id="esconder" class="row">
                        
                    
                        <div class="col-lg-8 mx-auto">
                        <input type="file" name="imagen[]" id="imagen[]" multiple=""/><br><br>
                        <input type="text" hidden name="id_coti" id="id_coti" value="<?php echo $id;?>"/><br><br>
                        <input style="font-size:1.5em;" class="btn btn-light" type="submit" value="subir fotos" />
                        </div>
                    </div>
                </form>
                <br><br>
                <button type="button" onclick="window.location.href='index.php'" style="background:#83CA88;color:white" class="btn btn-light" data_but="btn-xs"><i class='fa fa-automobile'></i>Finalizar
                </button>
                    
            </div>
      
    </div>
    
	</section>