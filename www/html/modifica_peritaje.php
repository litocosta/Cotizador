
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

$id = $_POST['id_cambio'];
$nom = $_POST['nom'];
$ape = $_POST['ape'];
$dni = $_POST['dni'];
$mail = $_POST['mail'];
$loc = $_POST['loca1'];
$pro = $_POST['pro'];
$key = $_POST['key'];
$sql_pro = "SELECT * FROM provincias WHERE codigo='$pro'";
$resultado_pro = mysqli_query($conn, $sql_pro) or die ('Error en el query database');
$row_pro = mysqli_fetch_array($resultado_pro);
$pro = $row_pro['nombre'];
$pat = $_POST['pat'];
$kil = $_POST['kil'];
$col = $_POST['color'];

$cel = $_POST['celu'];
$cotitu = $_POST['cotitu'];
$uso = $_POST['uso'];
$pren = $_POST['prenda'];
$asientos = $_POST['asientos'];
$combustible = $_POST['combustible'];
$cilin = $_POST['cilin'];
$trans = $_POST['trans'];
//$prenda = $_POST['prenda'];
//FUNCIONAMIENTO//
$funcion = $_POST["funcion"];
$falla = $_POST["falla"];
$caja = $_POST["caja"];
$frenos = $_POST["frenos"];
$funcion = $_POST["funcion"];
$sus_tren = $_POST["sus_tren"];
$adver = $_POST["adver"];
$indi = $_POST["indi"];
$airbag = $_POST["airbag"];
$abs = $_POST["abs"];


   // Check connection


   /*echo "La id es: ".$id."<br>";
                echo $nom."<br>";
                echo $ape."<br>";
                echo $dni."<br>";
                echo $pro."<br>";
                echo $key."<br>";
                echo $mail."<br>";
                echo $pat."<br>";
                echo $kil."<br>";
                echo $col."<br>";
                echo $cel."<br>";
                echo $cotitu."<br>";
                echo $uso."<br>";

                echo $asientos."<br>";
                echo $combustible."<br>";
                echo $cilin."<br>";
                echo $trans."<br>";*/

$sql = "UPDATE cotizados SET nombre='$nom', apellido='$ape', email='$mail', ciudad='$key', provincia='$pro', patente='$pat', kilometros='$kil', cotitular='$cotitu',
        tax_rem_uber='$uso', prendado='$pren', celular='$cel', color='$col', asientos='$asientos', combustible='$combustible', transmision='$trans'  WHERE id='$id'";
mysqli_query($conn, $sql);

$sql = "UPDATE funcionamiento SET funciona='$funcion', airbag='$airbag', abs='$abs', falla_motor='$falla', falla_caja='$caja', falla_frenos='$frenos', falla_sus_tren='$sus_tren', 
        luces_adver='$adver', falla_indicadores='$indi' WHERE  id_cliente='$id' ";
if (mysqli_query($conn, $sql)) {

    $id_funcio = mysqli_insert_id($conn);
    $jump = "\r\n";
    $separator = ",";
    $fp = fopen($file, 'a');
    $tabla = "funcionamiento" . $jump;
    fwrite($fp, $tabla);

    $registro = 'id' . $separator . 'funciona' . $separator . 'airbag' . $separator . 'abs' . $separator . 'falla_motor' . $separator . 'alla_caja' . $separator . 'falla_frenos'
                 . $separator . 'falla_sus_tren' . $separator . 'luces_adver' . $separator . 'alla_indicadores' . $separator . 'id_cliente' . $jump;
    fwrite($fp, $registro);

    $registro = $id_funcio . $separator . $funcion . $separator . $airbag . $separator . $abs . $separator . $falla . $separator . $caja . $separator . $frenos
                 . $separator . $sus_tren . $separator . $adver . $separator . $indi . $separator . $id . $jump;
    fwrite($fp, $registro);
    fclose($fp);
    chmod($file, 0777);
} 
else 
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);



//EXTERIOR
$parabri = $_POST["parabri"];
$opticas = $_POST["opticas"];
$faros = $_POST["faros"];
$grani = $_POST["grani"];
$pintura = $_POST["pintura"];
$choque = $_POST["choque"];
$panel = $_POST["panel"];
$profu = $_POST["profundo"];
$paradel = $_POST["paradel"];
$paratra = $_POST["paratra"];

$conn = mysqli_connect($servername, $username, $password, $database);
   // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "UPDATE aspecto_exterior SET choque_fuerte='$choque', parabrisas_roto='$parabri', opticas_del_rotas='$opticas', faros_atras_rotos='$faros',
danio_granizo='$grani', estado_pintura='$pintura', paneles_rayados='$panel', rayas_profundas='$profu', paragolpe_del='$paradel', paragolpe_tras='$paratra' 
WHERE id_cliente='$id'";
if (mysqli_query($conn, $sql)) {
    $id_exterior = mysqli_insert_id($conn);
    $jump = "\r\n";
    $separator = ",";
    $fp = fopen($file, 'a');
    $tabla = "aspecto_exterior" . $jump;
    fwrite($fp, $tabla);
    //$registro = 'nombre' . $separator . 'apellido' . $separator . 'email' . $separator . $jump;
    $registro = 'id' .$separator . 'choque_fuerte' . $separator . 'parabrisas_roto' . $separator . 'opticas_del_rotas' . $separator . 'faros_atras_rotos' . $separator . 
                'danio_granizo' . $separator . 'estado_pintura' . $separator . 'paneles_rayados' . $separator . 'rayas_profundas' . $separator . 
                'paragolpe_del' . $separator . 'paragolpe_tras' . $separator . 'id_cliente' . $jump;
    fwrite($fp, $registro);
    //$registro = $row['nombre'] . $separator . $row['apellido'] . $separator . $row['email'] . $jump;
    $registro = $id_exterior .$separator . $choque . $separator . $parabri . $separator . $opticas . $separator . $faros . $separator . $grani . $separator . $pintura
                . $separator . $panel . $separator . $profu . $separator . $paradel . $separator . $paratra .  $separator . $id . $jump;
    fwrite($fp, $registro);
    fclose($fp);
    chmod($file, 0777);
} 
else 
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);

if ($panel == "si")
{
    if(!empty($_POST['paneles'])){
        //echo $_POST['paneles'].'<BR>';
        //print_r(explode(",",$_POST['paneles']));
        $paneles = explode(",",$_POST['paneles']);
        $conn = mysqli_connect($servername, $username, $password, $database);
        //$sql = "SELECT * FROM chapa_pintura WHERE id_exterior='$id_exterior"
        $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');  
        mysqli_query($conn, "DELETE FROM chapa_pintura WHERE id_exterior='$id_exterior");
        
       // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $fp = fopen($file, 'a');
        $tabla = "chapa_pintura" . $jump;
        fwrite($fp, $tabla);
        $registro = 'id_exterior' . $separator . 'item' .  $jump;
        fwrite($fp, $registro);
        
        foreach($paneles as $selected){
           //echo $selected."</br>";
           $sql = "INSERT INTO chapa_pintura (id_exterior, item) VALUES ('$id_exterior', '$selected')";
           mysqli_query($conn, $sql);
          
           $registro = $id_exterior . $separator . $selected .  $jump;
           fwrite($fp, $registro);

        }
        mysqli_close($conn);
        fclose($fp);
        chmod($file, 0777);
    }
}

if ($profu == "si")
{
    if(!empty($_POST['profu'])){
        $profun = explode(",",$_POST['profu']);
        //echo $_POST['profu'].'<BR>';
        //print_r(explode(",",$_POST['profu']));
        $conn = mysqli_connect($servername, $username, $password, $database);
       // Check connection
        $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');  
        mysqli_query($conn, "DELETE FROM chapa_rayada WHERE id_exterior='$id_exterior");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $fp = fopen($file, 'a');
        $tabla = "chapa_rayada" . $jump;
        fwrite($fp, $tabla);
        $registro = 'id_exterior' . $separator . 'item' .  $jump;
        fwrite($fp, $registro);
        foreach($profun as $selected){
           //echo $selected."</br>";
           $sql = "INSERT INTO chapa_rayada (id_exterior, item) VALUES ('$id_exterior', '$selected')";
           mysqli_query($conn, $sql);
           
           $registro = $id_exterior . $separator . $selected .  $jump;
           fwrite($fp, $registro);
        }
        mysqli_close($conn);
        fclose($fp);
        chmod($file, 0777);
    }
}


//INTERIOR
$tapi = $_POST["tapi"];
$pola = $_POST["pola"];
$aa = $_POST["aa"];
$cale = $_POST["cale"];
$vid = $_POST["vid"];
$cierre = $_POST["cierre"];

$conn = mysqli_connect($servername, $username, $password, $database);
   // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "UPDATE interior SET tapizado='$tapi', polarizado='$pola', aa_funciona='$aa', calefac_funciona='$cale', levantacrist_funciona='$vid',
        cierre_central='$cierre' WHERE id_cliente='$id'";
        
if (mysqli_query($conn, $sql)) {
    $id_interior = mysqli_insert_id($conn);
    $jump = "\r\n";
    $separator = ",";
    $fp = fopen($file, 'a');
    $tabla = "interior" . $jump;
    fwrite($fp, $tabla);
    //$registro = 'nombre' . $separator . 'apellido' . $separator . 'email' . $separator . $jump;
    $registro = 'id'. $separator .'tapizado' . $separator . 'polarizado' . $separator . 'aa_funciona' . $separator . 'calefac_funciona' . $separator . 
                'levantacrist_funciona' . $separator . 'cierre_central' . $separator . 'id_cliente' . $jump;
    fwrite($fp, $registro);
    //$registro = $row['nombre'] . $separator . $row['apellido'] . $separator . $row['email'] . $jump;
    $registro = $id_interior . $separator . $tapi . $separator . $pola . $separator . $aa . $separator . $cale . $separator . $vid . $separator . 
                $cierre . $separator . $id . $jump;
    fwrite($fp, $registro);
    fclose($fp);
    chmod($file, 0777);
} 
else 
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);


$neuma = $_POST["neuma"];
$llantas = $_POST["llantas"];
$obs = $_POST["obs"];
$item1 = 'si';
$item2 = 'si';
$item3 = 'si';
$item4 = 'si';
$item5 = 'si';
if(!empty($_POST['llave'])){

        foreach($_POST['llave'] as $selected){
                     
           //echo $selected."<BR>";
           if($selected == "llave_c"){
               
                $item1 = $selected;
                //echo "SI entro".$item1."<BR>";
           }
           
           if($selected =="llave_2"){
               $item2 = $selected;
           }
         
           if($selected =="auxilio"){
               $item3 = $selected;
           }
          
           if($selected =="cruz"){
               $item4 = $selected;
           }
           
           if($selected =="cricket"){
               $item5 = $selected;
           }
          
        }
       // echo "item1: ".$item1."<BR>";
       // echo "item2: ".$item2."<BR>";
        //echo "item3: ".$item3."<BR>";
       // echo "item4: ".$item4."<BR>";
       // echo "item5: ".$item5."<BR>";
        //mysqli_close($conn);
    }

$conn = mysqli_connect($servername, $username, $password, $database);
   // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "UPDATE cub_accesorios SET km_gomas='$neuma', llantas_tasas='$llantas', llave_comando='$item1', segunda_llave='$item2', auxilio='$item3',
        cruz='$item4', cricket='$item5', obs='$obs' WHERE id_cliente='$id'";
if (mysqli_query($conn, $sql)) {
    $id_acce = mysqli_insert_id($conn);
     $jump = "\r\n";
    $separator = ",";
    $fp = fopen($file, 'a');
    $tabla = "cub_accesorios" . $jump;
    fwrite($fp, $tabla);
    //$registro = 'nombre' . $separator . 'apellido' . $separator . 'email' . $separator . $jump;
    $registro = 'id'. $separator .'km_gomas' . $separator . 'llantas_tasas' . $separator . 'llave_comando' . $separator . 'segunda_llave' . $separator . 
                'auxilio' . $separator . 'cruz' . $separator . 'cricket' . $separator . 'obs' . $separator . 'id_cliente' . $jump;
    fwrite($fp, $registro);
    //$registro = $row['nombre'] . $separator . $row['apellido'] . $separator . $row['email'] . $jump;
    $registro = $id_acce . $separator . $neuma . $separator . $llantas . $separator  . $item1 . $separator  . $item2 . $separator  . $item3 . $separator  . 
                $item4 . $separator  . $item5 . $separator  . $obs . $separator  . $id . $jump;
    fwrite($fp, $registro);
    fclose($fp);
    chmod($file, 0777);
} 
else 
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);


//$precio2 = str_replace ( ".", "", $precio);
      // $precio_crudo = $_POST['precioc'];
      //echo 'nombre: '.$nom.'<BR>';
            // Create connection
//echo "Precio ".$precio;
$conn = mysqli_connect($servername, $username, $password, $database);
  // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
      
      //echo "Connected successfully";
      
      //$sql = 'INSERT INTO cotizados (nombre) 
      //        VALUES ("$nom")';
$sql = "SELECT * FROM cotizados WHERE id='$id'";
$resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
if( $resultado )
{
    //echo "entro por resultado<br>";
      //Ahora valida que la consuta haya traido registros
    if( mysqli_num_rows( $resultado ) > 0)
    {
        //echo "columnas mas que 1<br>";
        //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
        while($fila = mysqli_fetch_array( $resultado ) )
        {
            $jump = "\r\n";
            $separator = ",";
            $fp = fopen($file, 'a');
            $tabla = "cotizados" . $jump;
            fwrite($fp, $tabla);
            //$registro = 'nombre' . $separator . 'apellido' . $separator . 'email' . $separator . $jump;
            $registro = 'id'. $separator .'nombre' . $separator . 'apellido' . $separator . 'email' . $separator . 'ciudad' . $separator .  'provincia' . $separator . 'patente' . $separator . 'kilometros' . $separator . 
                        'color'  . $separator . 'asientos'  . $separator . 'combustible'  . $separator . 'transmision'  . $separator . 'cilindrada'  . $separator . 'cotitular' .$separator . 'tax_rem_uber' . $separator.
                        'prendado' . $separator . 'entrega' . $separator . 'telefono' . $separator . 'celular' . $separator . 'dni' . $separator .
                        'marca' . $separator . 'modelo' . $separator . 'version' . $separator . 'ano' . $separator . 'precio_info' . $separator . 'precio_info_dto' . $separator . 'precio_info_act' . $separator .
                        'precio_info_act_dto' . $separator . 'fecha_ingreso' . $separator . 'fecha_vencimiento' . $separator . 'precio_final'. $separator . 'usuario'.
                        $jump;
            fwrite($fp, $registro);
            //$registro = $row['nombre'] . $separator . $row['apellido'] . $separator . $row['email'] . $jump;
            $registro = $fila['id'] . $separator . $fila['nombre'] . $separator . $fila['apellido'] . $separator  . $fila['email'] . $separator  .  $fila['ciudad'] . $separator  . $fila['provincia'] . $separator  .
                        $fila['patente'] . $separator  . $fila['kilometros'] . $separator . $fila['color'] . $separator  .  $fila['asientos'] . $separator  . $fila['combustible'] . $separator  . $fila['transmision'] . $separator  . 
                        $fila['cilindrada'] . $separator  .  $fila['cotitular'] . $separator  . $fila['tax_rem_uber'] . $separator  . $fila['prendado'] . $separator  . $fila['entrega'] . $separator  . 
                        $fila['telefono'] . $separator  . $fila['celular'] . $separator  . $fila['dni'] . $separator  . $fila['marca'] . $separator  . $fila['modelo'] . $separator  . $fila['version'] . $separator  . 
                        $fila['ano'] . $separator  . $fila['precio_info'] . $separator  . $fila['precio_info_dto'] . $separator  . $fila['precio_info_act'] . $separator .
                        $fila['precio_info_act_dto'] . $separator  . $fila['fecha_ingreso'] . $separator  . $fila['fecha_vencimiento'] . $separator  . 
                        $fila['precio_final'] . $separator  . $fila['usuario'] . $jump;
            fwrite($fp, $registro);
            fclose($fp);
            chmod($file, 0777);
            $chapa = $fila['patente'];
          //Ahora $fila tiene la primera fila de la consulta, pongamos que tienes
          //un campo en tu DB llamado NOMBRE, así accederías
           /* if( is_numeric($fila["precio_info"]) && is_numeric($ano))
            {
                //echo (int)$fila["precio"]-(int)$ano;
            }
            else 
            {
               // Echo "naninga";
            }*/
        }
    }
}

//echo $precio_info;

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
                $archivo_destino = $ftp_carpeta_remota.$id.'_'.$_SESSION["admin"].'_'.$cod.'_'.date("d-m-Y_H-i-s").'_'.$chapa.'_mod.txt';
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
         
               
                <br><h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4><br>
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
       
        
    </a>
    </div>
    
	</section>