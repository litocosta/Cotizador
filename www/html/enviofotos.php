<?php
session_start();
if(empty($_SESSION["admin"]))
{
    header("location: acceso.php");
}
function sube() 
{
ini_set('date.timezone','America/Argentina/Buenos_Aires'); 
//$cod = $_GET['cod'];
//$id = $_GET['id'];
$usuario = $_SESSION["admin"];
//echo "usuario es ".$usuario;
$coti = $_POST['id_coti'];
//echo '<br>'.$coti;
//$fotos = $_POST['imagen'];
//echo '<br>'.$fotos;

 
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
                                /*$from = 'fotos/';
                                $to = 'fotos/'.$coti.'/';
                                echo "Desde es:".$from."<br>";
                                echo "hasta es:".$to."<br>";

                                $archivos = glob($from.'index.php');
                                foreach ($archivos as $archivo){
                                echo "Archivo:".$archivo."<br>";

                                    $archivo_copiar = str_replace($from, $to, $archivo);
                                    copy($archivo, $archivo_copiar);
                                }*/
                                
                                //copy($from, $to);
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
                                                              

                                 $foto_final = $coti.'_'.$filename;
                                //$foto_final = '18_16002229029067656868862203266590.jpg';
                                echo $foto_final;

                                //$achica = shell_exec('jpegoptim -S 200k fotos/51/"'.$foto_final.'"');
                                //$achica = shell_exec('jpegoptim -S 200k fotos/"'.$coti.'"/"'.$foto_final.'"');
                                $achica = shell_exec('jpegoptim -S 200k "'.$coti.'"/"'.$foto_final.'"');
                                echo '<br>Achica es: '.$achica;
                                echo '<br>Foto final es: '.$foto_final;
                                //chdir($coti);
                                chmod($coti."/".$foto_final, 0777);
                                //chdir("/");
                                //shell_exec('jpegoptim -S 200k '.$filename);
                                } else {	
                                echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                            }
                            closedir($dir); //Cerramos el directorio de destino
                        }
}
}
?>