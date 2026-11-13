<?php
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
                               
                                $ruta='../indexfoto/';
                                //$destino='fotos/'.$coti.'/';
                                $destino = $coti.'/';
                                $archivos= glob($ruta.'*.*');
                                echo "Directorio Actual: ".getcwd() . "\n";
                                echo "Desde es:".$ruta."<br>";
                                echo "hasta es:".$destino."<br>";
                                //echo "archivos es:".$archivos[0]."<br>";
                                foreach ($archivos as $archivo){
                                $archivo_copiar = str_replace($ruta, $destino, $archivo);
                                    echo "<br>Arcxhivos es: ".$archivo;
                                copy($archivo, $archivo_copiar);
                                }
                                
                                echo "termino";

                            }
                            
                            $dir=opendir($directorio); //Abrimos el directorio de destino
                            $target_path = $directorio.'/'.$coti.'_'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                            
                            //Movemos y validamos que el archivo se haya cargado correctamente
                            //El primer campo es el origen y el segundo el destino
                            if(move_uploaded_file($source, $target_path)) {	
                                echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
                                                                    
                                //echo "Carpeta actual: ".getcwd() . "\n";
                                //chdir($coti."/");
                                echo "Carpeta actual: ".getcwd() . "\n";
                                //$foto_final = $coti.'_'.$filename.'_'.date("d-m-Y_H-i-s");
                                //$foto_final = '18_16002229029067656868862203266590.jpg';
                                //echo $foto_final;

                                //$achica = shell_exec('jpegoptim -S 200k fotos/51/"'.$foto_final.'"');
                                //$achica = shell_exec('jpegoptim -S 200k fotos/"'.$coti.'"/"'.$foto_final.'"');
                                $achica = shell_exec('jpegoptim -S 200k "'.$coti.'/'.$coti.'_'.$filename.'"');
                                //echo '<br>Achica es: '.$achica;
                                //echo '<br>Foto final es: '.$foto_final;
                                //chdir($coti);
                                chmod($coti."/".$coti.'_'.$filename, 0777);
                                rename($coti."/".$coti.'_'.$filename, $coti."/".$coti.'_'.date("d-m-Y_H-i-s").'_'.$filename);
                               
                                //chdir("/");
                                //shell_exec('jpegoptim -S 200k '.$filename);
                                } else {	
                                echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                            }
                            closedir($dir); //Cerramos el directorio de destino
                        }
                    }
                    
                   
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