<?php
require_once __DIR__ . '/config.php';
session_start();
if(empty($_SESSION["admin"]))
{
    header("location: acceso.php");
}
ini_set('date.timezone','America/Argentina/Buenos_Aires'); 
//$cod = $_GET['cod'];
//$id = $_GET['id'];
$usuario = $_SESSION["admin"];
//echo "usuario es ".$usuario;


$coti = $_POST['id_coti'];
//$coti = 51;

//echo '<br>'.$coti;
//$fotos = $_POST['imagen'];
//echo '<br>'.$fotos;
$servidor_ftp = cotizador_config('FTP_HOST');
$conexion_id = ftp_connect($servidor_ftp);
$ftp_usuario = cotizador_config('FTP_USER_2');
$ftp_clave = cotizador_config('FTP_PASSWORD');
$dir = $coti;
$resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave);
echo "El directorio principal es: " . ftp_pwd($conexion_id) . "\n";
               
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
             
            chdir('fotos');
            if ((!$conexion_id) || (!$resultado_login)) 
            {
                echo  "La conexion ha fallado! al conectar con  $servidor_ftp para usuario $usuario";
                exit;
            } 
            else 
            {
                echo "Conectado con $servidor_ftp, para usuario $ftp_usuario"."<br>";
                echo "estoy en la carpeta: ".getcwd()." y voy a crear el directorio".$dir." si no existe";
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0777) or die("No se puede crear el directorio de extracci&oacute;n");
                //echo "La carpeta $nombre_fichero existe";
                echo "<br>nuevo directorio creado con éxito $dir\n";
                echo "<br>Ahora estoy en la carpeta: ".getcwd();
                //chdir($dir);
                $ruta='../indexfoto/';
                //$destino='fotos/'.$coti.'/';
                $destino = $coti.'/';
                $archivos= glob($ruta.'*.*');
                echo "Directorio Actual: ".getcwd() . "\n";
                echo "Desde es:".$ruta."<br>";
                echo "hasta es:".$destino."<br>";
                echo "archivos es:".$archivos[0]."<br>";
                foreach ($archivos as $archivo)
                {
                    $archivo_copiar = str_replace($ruta, $destino, $archivo);
                    // echo "<br>Arcxhivos es: ".$archivo;
                    copy($archivo, $archivo_copiar);
                }

            } 
           /* else 
            {
                chdir($dir);
            }*/
            
            /*if (ftp_chdir($conexion_id, $dir)) //ANDA
            {
                //echo "encontro el directorio primera vez<br>";
                //ftp_chdir($conexion_id, $dir);
                 
            }
            else
            { 
                echo "No se pudo cambiar al directorio porque no existe\n"."<br>";
                if (ftp_mkdir($conexion_id, $dir)) 
                {
                    echo "nuevo directorio creado con éxito $dir\n";
                    ftp_chdir($conexion_id, $dir);
                }
                else 
                {
                    echo "Ha habido un problema durante la creación del directorio $dir\n";
                }
            }*/

            ftp_pasv($conexion_id, true);
            $cuenta_archivos = 0;
            foreach($_FILES["imagen"]['tmp_name'] as $key => $tmp_name)
                    {
                        //Validamos que el archivo exista
                        
                        if($_FILES["imagen"]["name"][$key]) {
                            $filename = $_FILES["imagen"]["name"][$key]; //Obtenemos el nombre original del archivo
                            $source = $_FILES["imagen"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                            
                            //$directorio = 'fotos/'.$coti; //Declaramos un  variable con la ruta donde guardaremos los archivos
                            $directorio = $coti; //Declaramos un  variable con la ruta donde guardaremos los archivos
                            //Validamos si la ruta de destino existe, en caso de no existir la creamos
                            if(!file_exists($directorio)){
                                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                                 //CREAMOS LA CARPETA EN PROYAUT
                                
                                $ruta='../indexfoto/';
                                //$destino='fotos/'.$coti.'/';
                                $destino = $coti.'/';
                                $archivos= glob($ruta.'*.*');
                                //echo "Directorio Actual: ".getcwd() . "\n";
                                //echo "Desde es:".$ruta."<br>";
                                //echo "hasta es:".$destino."<br>";
                                //echo "archivos es:".$archivos[0]."<br>";
                                foreach ($archivos as $archivo){
                                $archivo_copiar = str_replace($ruta, $destino, $archivo);
                                   // echo "<br>Arcxhivos es: ".$archivo;
                                copy($archivo, $archivo_copiar);
                                }
                                
                                //echo "termino";

                            }
                            
                            $dir=opendir($directorio); //Abrimos el directorio de destino
                            $target_path = $directorio.'/'.$coti.'_'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                            
                            //Movemos y validamos que el archivo se haya cargado correctamente
                            //El primer campo es el origen y el segundo el destino
                            if(move_uploaded_file($source, $target_path)) 
                            {	
                                //echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
                                                                    
                                //echo "Carpeta actual: ".getcwd() . "\n";
                                //chdir($coti."/");
                                //echo "Carpeta actual: ".getcwd() . "\n";
                                //$foto_final = $coti.'_'.$filename.'_'.date("d-m-Y_H-i-s");
                                //$foto_final = '18_16002229029067656868862203266590.jpg';
                                //echo $foto_final;

                                //$achica = shell_exec('jpegoptim -S 200k fotos/51/"'.$foto_final.'"');
                                //$achica = shell_exec('jpegoptim -S 200k fotos/"'.$coti.'"/"'.$foto_final.'"');
                                shell_exec('mogrify -resize 50% '.$coti.'/'.$coti.'_'.$filename);
                                $achica = shell_exec('jpegoptim -S 200k "'.$coti.'/'.$coti.'_'.$filename.'"');
                               
                                //echo '<br>Achica es: '.$achica;
                                //echo '<br>Foto final es: '.$foto_final;
                                //chdir($coti);
                                $enumera = 1;
                                chmod($coti."/".$coti.'_'.$filename, 0777);
                                $busco_numero = opendir($coti."/");

                                while ($busco_foto = readdir($busco_numero))
                                {
                                    $doble = strpos($busco_foto,'__');
                                    $extension = pathinfo($busco_foto);
                                    if( $busco_foto != "." && $busco_foto != ".." && $extension['extension']=='jpg')
                                    {
                                        //echo "Foto encontrada: ".$busco_foto."<br>";
                                        //echo "posision: ".$doble."<br>";
                                       
                                        if ($doble === false)
                                        {
                                            //echo "posision: ".$doble."<br>";
                                        }
                                        else 
                                        {
                                           // echo "posision: ".$doble."<br>";
                                            $nuevo_numero = substr($busco_foto,0,$doble);
                                           // echo "nuevo numero es:".$nuevo_numero;
                                            if ($nuevo_numero >= $enumera)
                                            {
                                                $enumera = $nuevo_numero+1;
                                            }

                                        }
                                    }
                                }
                                rename($coti."/".$coti.'_'.$filename, $coti."/".$enumera."__".$coti.'_'.date("d-m-Y_H-i-s").'_'.$filename);
                                $archivo_destino = $enumera."__".$coti.'_'.date("d-m-Y_H-i-s").'_'.$filename;
                                $nombre_archivo = $coti."/".$enumera."__".$coti.'_'.date("d-m-Y_H-i-s").'_'.$filename;
                                $info = new SplFileInfo($nombre_archivo);
                                if (!ftp_chdir($conexion_id, $coti))
                                {
                                echo "<br>No encontro la carpeta en proyaut";
                                    ftp_mkdir($conexion_id, $coti);
                                    ftp_chdir($conexion_id, $coti);      
                                }
                                if ($info->getExtension()=="jpeg" OR $info->getExtension()=="JPEG")
                                {
                                    //echo "nombre archivo:".$nombre_archivo;
                                    $posi = strpos($nombre_archivo,".");
                                    $nombre_nuevo = substr($nombre_archivo,0,$posi);
                                    $nombre_nuevo = $nombre_nuevo.".jpg";
                                    rename($nombre_archivo,$nombre_nuevo);
                                    $upload = ftp_put($conexion_id, $archivo_destino, $nombre_nuevo, FTP_BINARY);
                                    if (!$upload) 
                                    {
                                        echo "Ha ocurrido un error al subir el archivo ".$archivo_destino;
                                    } 
                                    else 
                                    {
                                        //echo "<h1>Subido $nombre_archivo a $servidor_ftp as $archivo_destino</H1>";
                                        //echo "<h5>Archivo ". $archivo_destino." Enviado a proyaut </H5>";
                                        $cuenta_archivos++;
                                    }
                                }
                                else
                                {
                                    $upload = ftp_put($conexion_id, $archivo_destino, $nombre_archivo, FTP_BINARY);
                                    if (!$upload) 
                                    {
                                        echo "Ha ocurrido un error al subir el archivo ".$archivo_destino;
                                    } 
                                    else 
                                    {
                                        //echo "<h1>Subido $nombre_archivo a $servidor_ftp as $archivo_destino</H1>";
                                        //echo "<h5>Archivo ". $archivo_destino." Enviado a proyaut </H5>";
                                        $cuenta_archivos++;
                                    }
                                }
                                //echo "El archivo $archivo_destino se ha almacenado en forma exitosa.<br>";
                                //echo "<br>El nuevamente  directorio existe y es: " . ftp_pwd($conexion_id) . "\n"."<br>";
                                //ftp_pasv($conexion_id, true);
                              
                               
                                //chdir("/");
                                //shell_exec('jpegoptim -S 200k '.$filename);
                            } 
                            else 
                            {	
                                echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                            }
                            closedir($dir); //Cerramos el directorio de destino
                            // close the connection
                           
                        }
                    }
                echo "Se ha/n subido ".$cuenta_archivos." archivos exitosamente";
                ftp_close($conexion_id);   
                ?>
                 <br><a href="#" onclick="window.history.go(-1); return false;">
                        <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Subir mas fotos
                        </button>
                    </a><br><br>
                <button type="button" onclick="window.location.href='index.php'" style="background:#83CA88;color:white" class="btn btn-light" data_but="btn-xs"><i class='fa fa-automobile'></i>Finalizar
                </button>
            </div>
        </div>      
    </div>
    
	</section>