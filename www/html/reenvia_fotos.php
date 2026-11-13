<?php
require_once __DIR__ . '/config.php';
// Abrimos la carpeta que nos pasan como parámetro
$servidor_ftp = cotizador_config('FTP_HOST');
$conexion_id = ftp_connect($servidor_ftp);
$ftp_usuario = cotizador_config('FTP_USER_2');
$ftp_clave = cotizador_config('FTP_PASSWORD');
//$dir = $coti;
$resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave);
echo "El directorio principal es: " . ftp_pwd($conexion_id) . "\n";
$path = "fotos/";
    $dir = opendir($path);
    // Leo todos los ficheros de la carpeta
    while ($elemento = readdir($dir)){
        // Tratamos los elementos . y .. que tienen todas las carpetas
        if( $elemento != "." && $elemento != ".."){
            // Si es una carpeta
            if( is_dir($path.$elemento) ){
                // Muestro la carpeta
                echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                $dir2 = opendir($path.$elemento);
               // $enumera = 1;
                while ($elemento2 = readdir($dir2)){
                    if( $elemento2 != "." && $elemento2 != ".."){
                        $extension = pathinfo($elemento2);
                        if ($extension['extension']=='jpg'){
                            //echo "<br /><strong>ARCHIVO:". $elemento2." es una foto"; 
                            $doble = strpos($elemento2,'__');
                            //echo $path.$elemento;
                            if ($doble === false){
                            //if ($doble === false and $path.$elemento=="fotos/97"){                                
                                //echo ", No fue enumerada";
                                //rename($path.$elemento.'/'.$elemento2, $path.$elemento.'/'. $enumera."__".$elemento2);
                                echo "copiara las nuevas fotos a: ".$path.$elemento.'/'.$elemento2;
                              
                                   //$enumera++;
                            }
                            else {
                                //echo ", Foto fue enumerada";
                                echo "copiara las nuevas fotos a: ".$elemento.'/'.$elemento2;
                                ftp_put($conexion_id, $elemento2, $path.$elemento.'/'.$elemento2, FTP_BINARY);
                            }

                        }
                        else {
                            echo "<br /><strong>ARCHIVO:". $elemento2." no es una foto";
                        }
                        
                    }
                   
                }
            // Si es un fichero
            } else {
                // Muestro el fichero
                echo "<br /><strong>ARCHIVO:". $elemento;
            }
        }
    }
?>