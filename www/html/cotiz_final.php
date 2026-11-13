
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
      unlink($usuario.'_datos.txt');

      $file = $usuario.'_datos.txt';
      $conn = mysqli_connect($servername, $username, $password, $database);
      $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
      $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
      $row = mysqli_fetch_array($resultado);
      $nombre_usuario = $row["nombre"].' '.$row['apellido'];

$precio = $_POST["precio"];

$ano = $_POST["ano"];
$cliente = $_POST["cliente"];
$id_cliente = $_POST["id"];
$auto = $_POST["auto"];
$cod = $row['cod_personal'];
//echo "ID es ".$id_cliente;
//echo "COD es ".$cod;
$moneda = $_POST['moneda'];
if($moneda<>"$")
      {
          $sql_moneda = "SELECT * FROM parametros ";
          $resultado = mysqli_query($conn, $sql_moneda) or die ('Error en el query database');
          $row = mysqli_fetch_array($resultado);
          $valor_dolar = $row["dolar"];
          //$precio = $precio*$valor_dolar;
          //echo "precio en pesos ".$precio;
      }else{
        $valor_dolar = 1;
      }
     
//
$resta = 0;
if ($_POST['funcion']=="no")
{
    $resta = $resta+1000;
}

if ($_POST['falla']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['falla']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['frenos']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['sus_tren']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['adver']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['indi']=="si")
{
    $resta = $resta+1000;
}
 ////echo "Total Funcionamiento: ".$resta;
$resta_fun = $resta;

$resta = 0;
 //echo 'EXTERIOR'.'<br>';
if ($_POST['parabri']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['opticas']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['faros']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['grani']=="si")
{
    $resta = $resta+1000;
}

if ($_POST['pintura']=="si")
{
    $resta = $resta+1000;
}


   

    //echo '<div>Has seleccionado: '.$selected.'</div>';
 


    

    //echo '<div>Has seleccionado: '.$selected.'</div>';
    //echo '<br>';
    if ($_POST['paradel']=="1")
    {
        $resta = $resta+500;
    }
    elseif ($_POST['paradel']=="2")
    {
        $resta = $resta+1000;
    }
    else
    {
        $resta = $resta+1500;
    }
    if ($_POST['paratra']=="1")
    {
        $resta = $resta+500;
    }
    elseif ($_POST['paratra']=="2")
    {
        $resta = $resta+1000;
    }
    else
    {
        $resta = $resta+1500;
    }
//echo "Total Exterior: ".$resta;
$resta_ext = $resta;
$resta = 0;

if ($_POST['tapi']=="1")
{
    $resta = $resta+500;
}
elseif ($_POST['tapi']=="2")
{
    $resta = $resta+1000;
}
elseif ($_POST['tapi']=="3")
{
    $resta = $resta+1500;
}
else
{
    $resta = $resta+2000;
}

if ($_POST['pola']=="1")
{
    $resta = $resta+500;
}
elseif ($_POST['pola']=="2")
{
    $resta = $resta+1000;
}
elseif ($_POST['pola']=="3")
{
    $resta = $resta+1500;
}
else
{
    $resta = $resta+2000;
}
if ($_POST['aa']=="no")
 {
     $resta = $resta+1000;
 }
 if ($_POST['cale']=="no")
 {
     $resta = $resta+1000;
 }
 if ($_POST['vid']=="no")
 {
     $resta = $resta+1000;
 }

 if ($_POST['cierre']=="1")
{
    $resta = $resta+500;
}
elseif ($_POST['cierre']=="2")
{
    $resta = $resta+1000;
}
elseif ($_POST['cierre']=="3")
{
    $resta = $resta+1500;
}
else
{
    $resta = $resta+2000;
}

//echo "Total Interior: ".$resta;
$resta_int = $resta;
$resta = 0;

if ($_POST['neuma']=="1")
{
    $resta = $resta+500;
}
elseif ($_POST['neuma']=="2")
{
    $resta = $resta+1000;
}
elseif ($_POST['neuma']=="3")
{
    $resta = $resta+1500;
}
else
{
    $resta = $resta+2000;
}

//echo "llantas ".$_POST["llantas"];
if ($_POST['llantas']=="1")
{
    $resta = $resta+500;
}
elseif ($_POST['llantas']=="2")
{
    $resta = $resta+1000;
}
else
{
    $resta = $resta+2000;
}

//cho "<br>Total Accesorios: ".$resta;
$resta_acc = $resta;
$resta = 0;
$total_restas = $resta_fun+$resta_ext+$resta_int+$resta_acc;
//echo "<br>total restas: ".$total_restas;
//echo "<Br>Precio crudo: ".$precio_crudo;
//echo "<Br>Precio infoauto: ".$precio+1000;
//$precio_final = intval($precio);
//echo "<Br>Precio infoauto: ".gettype($precio);
//echo "<Br>Precio restas: ".gettype($total_restas);
$precio_final = (($precio*1000)*$valor_dolar)-(($precio*15/100)*1000)*$valor_dolar;
////echo "<br>".($precio*1000)*$valor_dolar."<br>";

//echo "<BR>precio final: ".$precio_final;
$precio_info = $precio_final-$total_restas;

//$precio = intval($precio);
//echo "precio crudo: ".$precio_crudo;
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

$conn = mysqli_connect($servername, $username, $password, $database);
   // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "UPDATE cotizados SET precio_final=$precio_info WHERE id=$id_cliente";
mysqli_query($conn, $sql);

$sql = "INSERT INTO funcionamiento (funciona, airbag, abs, falla_motor, falla_caja, falla_frenos, falla_sus_tren, luces_adver, falla_indicadores, id_cliente) 
        VALUES ('$funcion', '$airbag', '$abs', '$falla', '$caja', '$frenos', '$sus_tren', '$adver', '$indi', '$id_cliente')";
if (mysqli_query($conn, $sql)) {
    //$id_cliente = mysqli_insert_id($conn);
    $id_funcio = mysqli_insert_id($conn);
    $jump = "\r\n";
    $separator = ",";
    $fp = fopen($file, 'a');
    $tabla = "funcionamiento" . $jump;
    fwrite($fp, $tabla);
    //$registro = 'nombre' . $separator . 'apellido' . $separator . 'email' . $separator . $jump;
    $registro = 'id' . $separator . 'funciona' . $separator . 'airbag' . $separator . 'abs' . $separator . 'falla_motor' . $separator . 'alla_caja' . $separator . 'falla_frenos'
                 . $separator . 'falla_sus_tren' . $separator . 'luces_adver' . $separator . 'alla_indicadores' . $separator . 'id_cliente' . $jump;
    fwrite($fp, $registro);
    //$registro = $row['nombre'] . $separator . $row['apellido'] . $separator . $row['email'] . $jump;
    $registro = $id_funcio . $separator . $funcion . $separator . $airbag . $separator . $abs . $separator . $falla . $separator . $caja . $separator . $frenos
                 . $separator . $sus_tren . $separator . $adver . $separator . $indi . $separator . $id_cliente . $jump;
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
$pintura = $_POST["pintura"];
$panel = $_POST["panel"];
$profu = $_POST["profundo"];
$paradel = $_POST["paradel"];
$paratra = $_POST["paratra"];

$conn = mysqli_connect($servername, $username, $password, $database);
   // Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "INSERT INTO aspecto_exterior (choque_fuerte, parabrisas_roto, opticas_del_rotas, faros_atras_rotos,danio_granizo, 
                                      estado_pintura, paneles_rayados, rayas_profundas, paragolpe_del, paragolpe_tras, id_cliente) 
        VALUES ('$choque', '$parabri', '$opticas', '$faros', '$grani', '$pintura', '$panel', '$profu', '$paradel', '$paratra', '$id_cliente')";
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
                . $separator . $panel . $separator . $profu . $separator . $paradel . $separator . $paratra .  $separator . $id_cliente . $jump;
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
       // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $fp = fopen($file, 'a');
        $tabla = "chapa_pintura" . $jump;
        fwrite($fp, $tabla);
        $registro = 'id_exterior' . $separator . 'item' .  $jump;
        fwrite($fp, $registro);
        //foreach($_POST['paneles'] as $selected){
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
        $profu = explode(",",$_POST['profu']);
        //echo $_POST['profu'].'<BR>';
        print_r(explode(",",$_POST['profu']));
        $conn = mysqli_connect($servername, $username, $password, $database);
       // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $fp = fopen($file, 'a');
        $tabla = "chapa_rayada" . $jump;
        fwrite($fp, $tabla);
        $registro = 'id_exterior' . $separator . 'item' .  $jump;
        fwrite($fp, $registro);
        foreach($profu as $selected){
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
$sql = "INSERT INTO interior (tapizado, polarizado, aa_funciona, calefac_funciona, levantacrist_funciona, cierre_central, id_cliente) 
        VALUES ('$tapi', '$pola', '$aa', '$cale', '$vid', '$cierre', '$id_cliente')";
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
                $cierre . $separator . $id_cliente . $jump;
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
$sql = "INSERT INTO cub_accesorios (km_gomas, llantas_tasas, llave_comando, segunda_llave, auxilio, cruz, cricket, obs, id_cliente) 
        VALUES ('$neuma', '$llantas', '$item1', '$item2', '$item3', '$item4', '$item5', '$obs','$id_cliente')";
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
                $item4 . $separator  . $item5 . $separator  . $obs . $separator  . $id_cliente . $jump;
    fwrite($fp, $registro);
    fclose($fp);
    chmod($file, 0777);
} 
else 
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);


$precio2 = str_replace ( ".", "", $precio);
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
$sql = "SELECT * FROM cotizados WHERE id='$id_cliente'";
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
                        'precio_info_act_dto' . $separator . 'fecha_ingreso' . $separator . 'fecha_vencimiento' . $separator . 'precio_final'. $separator . 'usuario'.$separator . 'gnc'.
                        $jump;
            fwrite($fp, $registro);
            //$registro = $row['nombre'] . $separator . $row['apellido'] . $separator . $row['email'] . $jump;
            $registro = $fila['id'] . $separator . $fila['nombre'] . $separator . $fila['apellido'] . $separator  . $fila['email'] . $separator  .  $fila['ciudad'] . $separator  . $fila['provincia'] . $separator  .
                        $fila['patente'] . $separator  . $fila['kilometros'] . $separator . $fila['color'] . $separator  .  $fila['asientos'] . $separator  . $fila['combustible'] . $separator  . $fila['transmision'] . $separator  . 
                        $fila['cilindrada'] . $separator  .  $fila['cotitular'] . $separator  . $fila['tax_rem_uber'] . $separator  . $fila['prendado'] . $separator  . $fila['entrega'] . $separator  . 
                        $fila['telefono'] . $separator  . $fila['celular'] . $separator  . $fila['dni'] . $separator  . $fila['marca'] . $separator  . $fila['modelo'] . $separator  . $fila['version'] . $separator  . 
                        $fila['ano'] . $separator  . $fila['precio_info'] . $separator  . $fila['precio_info_dto'] . $separator  . $fila['precio_info_act'] . $separator .
                        $fila['precio_info_act_dto'] . $separator  . $fila['fecha_ingreso'] . $separator  . $fila['fecha_vencimiento'] . $separator  . 
                        $fila['precio_final'] . $separator  . $fila['usuario'] . $separator  . $fila['gnc'] . $jump;
            fwrite($fp, $registro);
            fclose($fp);
            chmod($file, 0777);
            $chapa = $fila['patente'];
          //Ahora $fila tiene la primera fila de la consulta, pongamos que tienes
          //un campo en tu DB llamado NOMBRE, así accederías
            if( is_numeric($fila["precio_info"]) && is_numeric($ano))
            {
                //echo (int)$fila["precio"]-(int)$ano;
            }
            else 
            {
               // Echo "naninga";
            }
        }
    }
}

//echo $precio_info;

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
      <h6 style="color:white">Usuario:<?php echo ' '.$nombre_usuario; ?>
			<a id="salir" style="margin-left:1em;"  href="salir.php">Cerrar Sesión</a></h6>
    </div> 
  </nav>
	<section class="bg-primary text-white">
    <div class="container text-center">
		<div class="row">
			<div class="col-lg-8 mx-auto" style="margin-top:-4em">
         
               
                <br><h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4><br>
                    <?php echo '<h5>Cliente: '.$cliente.'<BR><BR>'; 
                    
                    if($row['ver_valor']=='s')
                    {
                        echo $auto.'<BR>Precio estimado: $ '.number_format((($precio-($precio*15/100))*1000)*$valor_dolar,0,'','.').'<BR><BR></h5>'; 
                        echo '<h5   style="background:#DE6B6C;color:white">Observaciones: -($'.number_format(($total_restas),0,'','.').')<BR><BR></h5>';
                        echo "<h2>Cotización Final: $".number_format(($precio_info),0,'','.').'</h2>';    
                    }
                    else
                    {
                        echo "<h2>Cotización Finallizada</h2>";    
                    }
                     ?>
                    
            </div>
        </div><br>
        
        <?php
        //echo $cod;
        ?>
        <a class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" href="envio_proyaut.php?cod=<?php echo $cod; ?>&id=<?php echo $id_cliente; ?>&chapa=<?php echo $chapa; ?>">Enviar a Proyaut
        
    </a>
    </div>
    
	</section>