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
$coti = $_POST['coti'];
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
              // chdir('fotos');
            foreach($_FILES["imagen"]['tmp_name'] as $key => $tmp_name)
                    {
                        //Validamos que el archivo exista
                        if($_FILES["imagen"]["name"][$key]) {
                            $filename = $_FILES["imagen"]["name"][$key]; //Obtenemos el nombre original del archivo
                            $source = $_FILES["imagen"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                            
                            $directorio = 'fotos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                            
                            //Validamos si la ruta de destino existe, en caso de no existir la creamos
                            if(!file_exists($directorio)){
                                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                            }
                            
                            $dir=opendir($directorio); //Abrimos el directorio de destino
                            $target_path = $directorio.'/'.$coti.'_'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                            
                            //Movemos y validamos que el archivo se haya cargado correctamente
                            //El primer campo es el origen y el segundo el destino
                            if(move_uploaded_file($source, $target_path)) {	
                                echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
                                 $foto_final = $coti.'_'.$filename;
                                //$foto_final = '18_16002229029067656868862203266590.jpg';
                                echo $foto_final;

                                $achica = shell_exec('jpegoptim -S 200k fotos/"'.$foto_final.'"');
                                echo 'Achica es: '.$achica;
                                //shell_exec('jpegoptim -S 200k '.$filename);
                                } else {	
                                echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                            }
                            closedir($dir); //Cerramos el directorio de destino
                        }
                    }
                    //Creamos Nuestra Función
                    /*function lista_archivos($carpeta){ //La función recibira como parametro un carpeta
                    if (is_dir($carpeta)) { //Comprovamos que sea un carpeta Valido
                    if ($dir = opendir($carpeta)) {//Abrimos el carpeta
                    echo '<ul>';
                    while (($archivo = readdir($dir)) !== false){ //Comenzamos a leer archivo por archivo
                    if ($archivo != '.' && $archivo != '..'){ 
                    $nuevaRuta = $carpeta.$archivo.'/';
                    echo '<li>'; //Abrimos un elemento de lista 
                    if (is_dir($nuevaRuta)) { //Si la ruta que creamos es un carpeta entonces:
                    echo '<b>'.$nuevaRuta.'</b>'; //Imprimimos la ruta completa resaltandola en negrita
                    lista_archivos($nuevaRuta);//Volvemos a llamar a este metodo para que explore ese carpeta.
                    } else { //si no es un carpeta:
                    echo 'Archivo: '.$archivo; //simplemente imprimimos el nombre del archivo actual
                    }
                    '</li>'; //Cerramos el item actual y se inicia la llamada al siguiente archivo
                    }
                    }//finaliza 
                    echo '</ul>';//Se cierra la lista
                    closedir($dir);//Se cierra el archivo
                    }
                    }else{//Finaliza el If de la linea 12, si no es un carpeta valido, muestra el siguiente mensaje
                    echo 'No Existe la carpeta';
                    }				
                    }//Fin de la Función	 
                    //Llamamos a la función
                    lista_archivos("fotos/");*/
                    //chdir('fotos');
                    //$salida = shell_exec('ls *.jpg');
                    //$foto = '18_16002187800217966485382654930759.jpg';
                   // echo "<pre><H5>$salida</h5></pre>";
                   
                ?>
                <button type="button" onclick="window.location.href='index.php'" style="background:#83CA88;color:white" class="btn btn-light" data_but="btn-xs"><i class='fa fa-automobile'></i>Finalizar
                </button>
            </div>
        </div>      
    </div>
    
	</section>