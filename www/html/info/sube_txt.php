<?php
require_once __DIR__ . '/../config.php';
 /*            
                $servidor_ftp = cotizador_config('FTP_HOST');
                $conexion_id = ftp_connect($servidor_ftp);
                $ftp_usuario = cotizador_config('FTP_USER');
                $ftp_clave = cotizador_config('FTP_PASSWORD');
                //$ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/tu_carpeta/local/";// ORIGINAL

                ///FTP LOCAl
                $ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/";
                //$ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/info/";

                ///FTP SELVA
                //$ftp_carpeta_local =  $_SERVER['DOCUMENT_ROOT'] . "/var/www/html/info/";
                //$ftp_carpeta_remota= "/tu_carpeta/remota/";//ORIGINAL
                $ftp_carpeta_remota= "/";
                $mi_nombredearchivo="admin_datos.txt";
                //$mi_nombredearchivo=rename($_SESSION["admin"].'_datos.txt',$_SESSION["admin"].'_datos_'.date("d-m-Y_H-i-s").'.txt');

                //$nombre_archivo = $ftp_carpeta_local.$mi_nombredearchivo;
                $nombre_archivo = $mi_nombredearchivo;
                $archivo_destino = $ftp_carpeta_remota.$id.'_'.$_SESSION["admin"].'_'.$cod.'_'.date("d-m-Y_H-i-s").'_'.$chapa.'.txt';
                $resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave);
                if ((!$conexion_id) || (!$resultado_login)) {
                    echo  "La conexion ha fallado! al conectar con  $servidor_ftp para usuario $usuario";
                    exit;
                } else {
                    echo "Conectado con $servidor_ftp, para usuario $usuario";
                }
                //ftp_pasv($conexion_id, true);
                //$upload = ftp_put($conexion_id, $archivo_destino, $nombre_archivo, FTP_BINARY);
                if (!$upload) {
                    echo "Ha ocurrido un error al subir el archivo";
                } else {
                    //echo "<h1>Subido $nombre_archivo a $servidor_ftp as $archivo_destino</H1>";
                    echo "<h5>Archivo ". $archivo_destino." Enviado  </H5>";
                }
                ftp_close($conexion_id);
                ?>*/
               
                $ftp_server = cotizador_config('FTP_HOST');
                $conn_id = ftp_connect($ftp_server);
                $ftp_user_name = cotizador_config('FTP_USER');
                $ftp_user_pass = cotizador_config('FTP_PASSWORD');
$file = 'admin_datos.txt';
$remote_file = 'readme.txt';

// establecer una conexión básica
$conn_id = ftp_connect($ftp_server);

// iniciar sesión con nombre de usuario y contraseña
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// activar modo pasivo
ftp_pasv($conn_id, true);

// cargar un archivo
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "se ha cargado $file con éxito\n";
} else {
 echo "Hubo un problema al cargar $file\n";
}

// cerrar la conexión ftp
ftp_close($conn_id);
?>
               