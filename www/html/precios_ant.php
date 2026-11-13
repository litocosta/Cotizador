<?php
require_once __DIR__ . '/config.php';
 session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
   
      $usuario = $_SESSION["admin"];
      $marca = $_POST["marca"];
      $modelo = $_POST["modelo"];
      $version = $_POST["version"];
      $servername = cotizador_config('DB_HOST');
      $database = cotizador_config('DB_NAME');
      $username = cotizador_config('DB_USER');
      $password = cotizador_config('DB_PASSWORD');
      $conn = mysqli_connect($servername, $username, $password, $database);
      $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
      $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
      $row = mysqli_fetch_array($resultado);
      $nombre_usuario = $row["nombre"].' '.$row['apellido'];


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Montironi</title>
    <link rel="icon"  type="image/png" href="car3.png"/>
    <link rel="icon" href="car.ico" type="image/x-icon">
    
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
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
        <div class="col-lg-8 mx-auto">
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
<?php
include 'genera_token.php';
$curl = curl_init();
//$id_cliente = $_POST['id_cliente'];
$recibido = $_POST['id_version'];
echo $recibido;
$num_espacio = strpos($recibido,' ',0);
$marca = substr($recibido,$num_espacio);
        //echo $num_espacio;
$id = substr($recibido,0,$num_espacio);
//echo $id;
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://demo.api.infoauto.com.ar/cars/pub/models/".$id."/prices",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$token.'',
    cotizador_config('INFOAUTO_COOKIE')
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo "Esto es todo: ".$response;
$total_caracteres = strlen($response);
$json = substr($response,1,$total_caracteres-3);
$fin = '},{';
$busco = strpos($json, $fin, 0);
//echo '<BR>Busco: '.$busco;
$registro = substr($json,0,$busco+1);
//echo '<BR>REgistro: '.$registro;
$obj = json_decode($registro);
////$nombre = $obj->{'brand'}->{'name'};
print '<H4>'.$marca.'</H4>';
//echo '<H4>'.$id_nombre_modelo.'<BR>'.'</h4>';
$restito = substr($json,0);
//$restito = substr($json,$busco+2);
echo'<ul class="navbar-nav ml-auto">
<li style="margin-left:-5.5em" class="nav-item"><h4>Año Precio</h4></li>';
$cantidad = 0;
//echo "busco: ".$busco;
while($busco <> '')
          {
            
            $registro = substr($restito,0,$busco+1);
            //echo '<BR>REgistro: '.$registro;
            $restito = substr($restito,$busco+2);
            //echo '<BR>REstito: '.$restito;
            $obj = json_decode($registro);
            $precio = $obj->{'price'};
            $precio_crudo = $obj->{'price'}*1000;
           // $codia = $obj->{'codia'};
            //echo gettype($precio_crudo);
            $ano = $obj->{'year'};
            //echo $ano;
            if(strlen($precio) > 3)
            {
                $cadena = substr($precio,0,strlen($precio)-3).'.'.substr($precio,-3);
               //echo 'cadena: '.$cadena;
                $precio = $cadena;
            }
            else
            {
                    # code...
            }
            echo '<li class="nav-item" style="margin-left:2em">'.$ano.' $'.$precio.'.000
                      <a class="btn btn-light" style="background:#83CA88; color:white; margin-bottom:0.5em" 
                        href="peritaje.php?codia='.$id.'&ano='.$ano.'&marca='.$marca.'&precio_crudo='.$precio_crudo.'">Seleccionar
                      </a>
                  </li>';
                
            //echo 'Año: '.$obj->{'year'}.' Precio: '.$precio."<BR>";
            //print $obj->{'codia'}.' '.$obj->{'description'}.'<BR>';
           
            $busco = strpos($restito, $fin, 0);
            $cantidad++;
          }
          if ($cantidad==0)
          {
              echo '<h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>No hay cotización para este modelo</strong></h4>';
          }
          echo '</ul>';
              echo '<BR><form action="index.php" method="post"> ';
                echo ' <div class="row">';
                      echo '<div class="col-lg-8 mx-auto"><input style="background:#DE6B6C;color:white" class="btn btn-light" type="submit" value="Volver al inicio" />
                      </div>';
            echo '</form>';
?>