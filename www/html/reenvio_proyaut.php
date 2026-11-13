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
            <form action="" method="post" enctype="multipart/form-data">
                <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Reenvío de cotizaciones</strong></h4><br><br>
                <label>Ingrese la patente del vehículo</label>

                <input type="text" name="pat" id="patente" required pattern="([A-Za-z]{3}[0-9]{3})*([A-Za-z]{2}[0-9]{3}[A-Za-z]{2})*" placeholder="XX000XX o XXX000"><br><br>
                <input id="mySubmit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Reenviar"/>
            </form>
            <?php
require_once __DIR__ . '/config.php';
                
                if (isset($_POST["pat"]))
                {
                    session_start();
                
                    if(empty($_SESSION["admin"]))
                    {
                        header("location: acceso.php");
                    }
                    ini_set('date.timezone','America/Argentina/Buenos_Aires'); 
                    
                    $pat  = $_POST['pat'];
                    if ($pat==="")
                    {
                        //echo "entor por todas";
                    ?>
                    <!--    <script>
                           
                                var mensaje;
                                var opcion = confirm("Desea reenviar todas las cotizaciones?");
                                if (opcion == true) {
                                    location.href = ("envia_todas.php")
                                } else {
                                    location.href = ("index.php")
                                }
                                document.getElementById("ejemplo").innerHTML = mensaje;
                          
                        </script>
                         <button type="button" onclick="window.location.href='index.php'" style="background:#83CA88;color:white" class="btn btn-light" data_but="btn-xs">
                            <i class='fa fa-automobile'></i>Finalizar
                        </button>
                    <?php
                    }
                    else 
                    {
                        $servername = cotizador_config('DB_HOST');
                        $database = cotizador_config('DB_NAME');
                        $username = cotizador_config('DB_USER');
                        $password = cotizador_config('DB_PASSWORD');
                        $conn = mysqli_connect($servername, $username, $password, $database);
                        $sql = "SELECT * FROM cotizados WHERE patente='$pat'";
                        $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');    

                        if (mysqli_num_rows($resultado) > 0 )
                        {
                            $fila = mysqli_fetch_array( $resultado );
                            $usuario = $fila['usuario'];
                            $id = $fila['id'];
                            $chapa = $fila['patente'];
                            $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
                            $result = mysqli_query($conn, $sql) or die ('Error en el query database');
                            $row = mysqli_fetch_array($result);
                            $cod = $row['cod_personal'];
                        
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
                            $mi_nombredearchivo=$usuario."_datos.txt";
                            //$mi_nombredearchivo=rename($_SESSION["admin"].'_datos.txt',$_SESSION["admin"].'_datos_'.date("d-m-Y_H-i-s").'.txt');

                            $nombre_archivo = $ftp_carpeta_local.$mi_nombredearchivo;
                            $archivo_destino = $ftp_carpeta_remota.$id.'_'.$fila["usuario"].'_'.$cod.'_'.date("d-m-Y_H-i-s").'_'.$chapa.'.txt';
                            $resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave);
                            if ((!$conexion_id) || (!$resultado_login)) 
                            {
                                echo  "La conexion ha fallado! al conectar con  $servidor_ftp para usuario $usuario";
                                exit;
                            } 
                            else
                            {
                                echo "Conectado con $servidor_ftp, para usuario $usuario";
                            }

                            ftp_pasv($conexion_id, true);

                            $upload = ftp_put($conexion_id, $archivo_destino, $nombre_archivo, FTP_BINARY);
                            if (!$upload) 
                            {
                                echo "Ha ocurrido un error al subir el archivo";
                            } 
                            else 
                            {
                                //echo "<h1>Subido $nombre_archivo a $servidor_ftp as $archivo_destino</H1>";
                                echo "<h5>Archivo ". $archivo_destino." Enviado  </H5>";
                            }
                            ftp_close($conexion_id);
                        }
                        else 
                        {
                            echo '<br><h5 style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">No se encontraró el automovil solicitado</h5><br>'  ;   
                        }
                    ?>
                    <button type="button" onclick="window.location.href='index.php'" style="background:#83CA88;color:white" class="btn btn-light" data_but="btn-xs">
                        <i class='fa fa-automobile'></i>Finalizar
                    </button>
                    <?php
                    }
                    
                }
                
                ?>
                
            </div>
      
    </div>
    
	</section>