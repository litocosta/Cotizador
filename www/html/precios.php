<?php
require_once __DIR__ . '/config.php';
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
 session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
   
      $usuario = $_SESSION["admin"];
      $marca = $_POST["marca"];
      $modelo = $_POST["modelo"];
      $version = $_POST["version"];
      $servername = cotizador_config('DB_HOST_2');
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
echo '<h4>Marca selecionada: '.$marca.'</h4>';
echo '<h4>Modelo selecionado: '.utf8_encode($modelo).'</h4>';
$modelo2 = utf8_encode($modelo);
echo '<h4>Version selecionada: '.$version.'</h4>';
$version2 = utf8_decode($version);
//echo '<h4>Seleccione un año </h4>'.;

//$sql = "SELECT * FROM acara WHERE marca = '$marca' AND modelo = '$modelo' AND version='$version' ORDER by ano";
//$sql1 = "SELECT * FROM acara WHERE marca LIKE '%$marca%' AND modelo LIKE '%$modelo%' AND version LIKE '%$version%' ORDER by ano";
$sql1 = "SELECT * FROM acara WHERE marca LIKE '%$marca%' AND modelo LIKE '%$modelo2%' AND version LIKE '%$version2%'";

//$sql = "SELECT * FROM acara";
$resultado = mysqli_query($conn, $sql1) or die ('Error en el query database');
//echo "encontro: ".mysqli_num_rows($resultado);
echo '<h4>Seleccione un año </h4>';
if (mysqli_num_rows($resultado) <= 0 )
{
echo '<h5 style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">No se encontraron cotizaciones para este modelo</h5><br>'  ;
}
while($fila = mysqli_fetch_array( $resultado ) )
{
 
  
    //echo 'Encontrados: '.mysqli_num_rows($resultado);
    if($fila["precio_entero"] == 0)
    {
      //echo '<li class="nav-item" style="margin-left:2em">'.$fila["ano"].' No hay cotización
                        
      //              </li>';  
    }
    else 
    {
       if ($row['ver_valor']=='s'){
      echo '
     
      <li class="nav-item" style="margin-left:2em">'.$fila['ano'].' '.$fila["moneda"].' '.$fila['precio_entero'].'.000
                        <a class="btn btn-light" style="background:#83CA88; color:white; margin-bottom:0.5em" 
                          href="peritaje.php?ano='.$fila["ano"].'&marca='.$marca.'&modelo='.$modelo.'&version='.$version.'&precio='.
                          $fila["precio_entero"].'&moneda='.$fila["moneda"].'">Seleccionar
                        </a>
                    </li>';
    
       }
       else
       {
         echo '
     
      <li class="nav-item" style="margin-left:2em">'.$fila['ano'].' '.$fila["moneda"].'
                        <a class="btn btn-light" style="background:#83CA88; color:white; margin-bottom:0.5em" 
                          href="peritaje.php?ano='.$fila["ano"].'&marca='.$marca.'&modelo='.$modelo.'&version='.$version.'&precio='.
                          $fila["precio_entero"].'&moneda='.$fila["moneda"].'">Seleccionar
                        </a>
                    </li>';
       }
    }
  
}


echo '    <a href="javascript: history.go(-1)">
                        <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Atrás
                        </button>
                    </a>';
?>