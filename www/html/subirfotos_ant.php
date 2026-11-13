 <?php
require_once __DIR__ . '/config.php';
 session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
    else
    {
      $usuario = $_SESSION["admin"];
      $servername = cotizador_config('DB_HOST');
      $database = cotizador_config('DB_NAME');
      $username = cotizador_config('DB_USER');
      $password = cotizador_config('DB_PASSWORD');
      $conn = mysqli_connect($servername, $username, $password, $database);
      $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
      $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
      $row = mysqli_fetch_array($resultado);
      $nombre_usuario = $row["nombre"].' '.$row['apellido'];
      $id_usuario = $row['id'];


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
  <!--<header class="bg-primary text-white">
    <div class="container text-center">
      <h2>Montironi</h2>
      <p class="lead"></p>
    </div>
  </header>-->
  <section class="bg-primary text-white">
    <div class="container text-center">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <!--<h4><strong>Precios actualizados</strong></h4>-->
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Subir fotos</strong></h4>
         <?php
        
     
      
          echo '<h4>Seleccione una cotización</h4>';
          echo '<form action="envio_fotos.php" method="post" enctype="multipart/form-data"> ';
          //  echo'<input hidden name="id_cliente" value="'.$id_cliente.'">';
          echo '<select class="col-lg-8" name="coti"';
          $sql = "SELECT * FROM cotizados WHERE usuario='$usuario' ORDER BY patente";
          //$sql = "SELECT * FROM acara";
          $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
          header("Content-Type: text/html;charset=utf-8");

          while($fila = mysqli_fetch_array( $resultado ) )
          {
           //echo mysqli_num_rows($resultado);
            echo '<option value="'.$fila['id'].'"</option>'.$fila['patente'].' '.$fila['marca'].' '.$fila['modelo'].' '.$fila['version'].' '.$fila['ano'];
              
          }
          echo '</select><br><br>';
          echo '<input type="file" name="imagen[]" id="imagen[]" multiple=""/><br><br>';
		      
		         
          echo ' <div class="row">
                        <div class="col-lg-8 mx-auto"><input style="font-size:1.5em;" class="btn btn-light" type="submit" value="subir fotos" />
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