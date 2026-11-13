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
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <!--<ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
          </li>
        </ul>-->
      </div>
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
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Cotización</strong></h4>
<?php
require_once __DIR__ . '/config.php';
    //echo $_GET['id_cli'];
   // echo $_GET['ano'];
   // echo $_GET['marca'];
   // echo $_GET['precio'];
    $precio = $_GET['precio'];
    $id_cli = $_GET['id_cli'];
    $marca  = $_GET['marca'];
    $ano = $_GET['ano'];
    $servername = cotizador_config('DB_HOST');
    $database = cotizador_config('DB_NAME');
    $username = cotizador_config('DB_USER');
    $password = cotizador_config('DB_PASSWORD');
    $conn = mysqli_connect($servername, $username, $password, $database);
      // Check connection
    
    $sql = "SELECT nombre, apellido FROM cotizados WHERE id = $id_cli";
    $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
    if( $resultado )
    {

      //Ahora valida que la consuta haya traido registros
      if( mysqli_num_rows( $resultado ) > 0)
      {

        //Mientras mysqli_fetch_array traiga algo, lo agregamos a una variable temporal
        while($fila = mysqli_fetch_array( $resultado ) )
        {

          //Ahora $fila tiene la primera fila de la consulta, pongamos que tienes
          //un campo en tu DB llamado NOMBRE, así accederías
          echo '<p>El vehículo '.$_GET["marca"].', modelo '.$ano.'</p>'.'<p> que pertenece a '.$fila["nombre"].' '.$fila["apellido"].'</p>';
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
          echo '<p>tiene una cotización inicial de $'.$precio.'.000</p>';
        }
      }
  }
echo '<a href="index.php">
  <button type="button" class="btn btn-light" data_but="btn-xs"><i></i>Volver al inicio
  </button>
</a>
<a href="cotiz_2.php?marca='.$marca.'&id='.$id_cli.'&precio='.$precio.'&ano='.$ano.'">
  <button type="button" class="btn btn-light" data_but="btn-xs"><i></i>Continuar
  </button>
</a>';
?>
