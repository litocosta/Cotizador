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
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Selecione un usado</strong></h4>
         <?php
        
     
          header("Content-Type: text/html;charset=utf-8");
          echo '<h4>Por marca</h4>';
          echo '<form action="busca_usados.php" method="post"> ';
          //  echo'<input hidden name="id_cliente" value="'.$id_cliente.'">';
         
          //echo '<option value=""</option>Seleccionar';
          
          $sql = "SELECT DISTINCT (marca) FROM acara ORDER BY marca";
          //$sql = "SELECT * FROM acara";
          $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
          echo '<select class="col-lg-8" name="marca"';
          echo '<option value=""></option>';
          echo '<option value="">Seleccionar</option>';
          while($fila = mysqli_fetch_array( $resultado ) )
          {
           //echo mysqli_num_rows($resultado);
            echo '<option value="'.$fila['marca'].'">'.$fila['marca'].'</option>';
              
          }
          echo '</select><br><br>';
          echo '<h4>Por palabra</h4>';
          echo '<input class="col-lg-8" name="texto" placeholder="Ingrese texto a buscar...">';
          echo '<BR><BR>';
          echo '<h4>Por rango de precios</h4>';
          //echo '(Si busca un año en particular, ingrese solo desde)<BR>';
          echo '<strong style="margin-right:2em">Desde</strong><strong>Hasta</strong><br>';
          echo '$<input  name="precio1" size="4" style="margin-right:2em" placeholder="0">$<input name="precio2" size="4" placeholder="99999999">';
          echo '<BR><BR>';
          echo '<h4>Por año</h4>';
          echo '(Si busca un año en particular, ingrese solo desde)<BR>';
          echo '<strong style="margin-right:2em">Desde</strong><strong>Hasta</strong><br>';
          echo '<input  name="ano1" size="2" style="margin-right:2em" placeholder="0000"><input name="ano2" size="2" placeholder="9999">';
          echo '<BR><BR>';
          echo ' <div class="row">
                        <div class="col-lg-8 mx-auto"><input style="font-size:1.5em;" class="btn btn-light" type="submit" value="Buscar" />
                </div>
              </div>';
              
          echo '</form>';
          echo '<BR>';
          echo '<a href="propios.php">
                        <button type="button" style="background:white;color:black" class="btn btn-light" data_but="btn-xs">Borrar filtros
                        </button>
                    </a><BR><BR>';
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