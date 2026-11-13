<?php
require_once __DIR__ . '/config.php';
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
 session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
    else
    {
      $usuario = $_SESSION["admin"];
      $marca = $_POST["marca"];
      $modelo = $_POST["modelo"];
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
    <link rel="icon" type="image/png" href="car3.png" />
	<link rel="icon" href="car.ico" type="image/x-icon">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <script src="jquery.min.js"></script>
    <script src="validar.js"></script>
    <script src="validarE.js"></script>
</head>

<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><strong>MONTIRONI</strong></a>
     <h6 style="color:white">Usuario:<?php echo ' '.$nombre_usuario; ?>
			<a id="salir" style="margin-left:1em;"  href="salir.php">Cerrar Sesión</a></h6>
    
    </div>
    </nav>
      <div class="collapse navbar-collapse" id="navbarResponsive">
       
      </div>
    </div>
  </nav>
  
  <section class="bg-primary text-white">
    <div class="container text-center">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
         <?php
        echo '<h4>Marca selecionada: '.$marca.'</h4>';
        echo '<h4>Modelo selecionado: '.$modelo.'</h4>';
        echo '<h4>Seleccione una versión</h4>';
          echo '<form action="precios.php" method="post"> ';
          //  echo'<input hidden name="id_cliente" value="'.$id_cliente.'">';
          echo '<select class="col-lg-8" name="version"';
          $sql = "SELECT DISTINCT marca, modelo, version FROM acara WHERE marca = '$marca' AND modelo = '$modelo'";
          //$sql = "SELECT * FROM acara";
          $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
          

          echo '<option value="">Seleccionar</option>';
          while($fila = mysqli_fetch_array( $resultado ) )
          {
         
            echo '<option value="'.utf8_encode($fila['version']).'"</option>'.utf8_encode($fila['version']);
              
          }
          echo '</select><br><br>';
          echo '<input hidden name="marca" type="text" value="'.$marca.'" />';
          echo '<input hidden  name="modelo"type="text" value="'.$modelo.'" />';
      
          echo ' <div class="row">
                        <div class="col-lg-8 mx-auto">
                         <a href="javascript: history.go(-1)">
                            <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Atrás
                            </button>
                        </a>
                        <input style="font-size:1.5em;" class="btn btn-light" type="submit" value="Continuar" />
                </div>
              </div>';
          echo '</form>';
          echo '<BR>';
          echo '<a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>';
         
    }
?>
        </div>
      </div>
    </div>
  </section>

