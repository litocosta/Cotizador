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
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
         <?php
        
        //echo $_POST['id_marca'];
        //$id_cliente = $_POST['id_cliente'];
        $recibido = $_POST['id_marca'];
        $num_espacio = strpos($recibido,' ',0);
        //echo $num_espacio;
        $id = substr($recibido,0,$num_espacio);
        $marca = substr($recibido,$num_espacio);
        //echo $marca;
        require_once 'HTTP/Request2.php';
        include 'genera_token.php';
        $request = new HTTP_Request2();
        $request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/'.$id.'/groups/');
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
        'follow_redirects' => TRUE
         ));
        $request->setHeader(array(
        //'Authorization' => cotizador_config('INFOAUTO_AUTHORIZATION'),
        'Authorization' => 'Bearer '.$token,
        'Accept' => 'application/vnd.gestion.online+json',
        'X-Force-Content-Type' => 'application/json'
      ));

      try {
        $response = $request->send();
        if ($response->getStatus() == 200) 
        {
  
          $muestra = $response->getbody();
          $total_caracteres = strlen($muestra);
          $muestra = substr($muestra,1,$total_caracteres-3);
          //echo $muestra."<br>";
         // echo $total_caracteres."<br>";
          $cursor = 0;
          //$inicio = '[';
          //$fin = ']';
          $corchete_i = '{';
          $corchete_f = '}';
         // $busca_id = 'id';
          //$busca_nombre = 'name';
          //$busca_coma = ',';
          //$busca_dospuntos = ':';
          //$salida = true;
          echo '<h4>Marca selecionada: '.$marca.'</h4><br>';
          echo '<h5>Seleccione un modelo</h5>';
          echo '<form action="version.php" method="post"> ';
          //echo'<input hidden name="id_cliente" value="'.$id_cliente.'">';
          echo '<select class="col-lg-8" name="id_modelo"';
          while ($cursor < $total_caracteres-2)
          {
            $principio_registro = strpos($muestra,$corchete_i,$cursor);
            $fin_registro = strpos($muestra,$corchete_f,$cursor);
            //echo '<BR>Principio: '.$principio_registro;
           // echo '<BR>Fin: '.$fin_registro;
            $registro = substr($muestra,$cursor,($fin_registro-$principio_registro)+1);
            echo "<BR>El registro es: ".$registro.'<BR> ';
            $obj = json_decode($registro);
            echo '<option value="'.$id.' '.$obj->{'id'}.' '.$obj->{'name'}.' '.$obj->{'model'}.'">'.$obj->{'name'}.'</option>';
            
            //echo '<input name="modelo" value="'.$obj->{'model'}.'">';
            //print $obj->{'name'}; // 12345
            $cursor = $fin_registro+2;
          }
          echo '</select><br><br>';
          echo ' <div class="row">
                      <div class="col-lg-8 mx-auto"><input style="font-size:1.5em;" class="btn btn-light" type="submit" value="Continuar" />
              </div>
            </div>';
          echo '</form>';
          echo '<BR>';
          echo '<form action="index.php" method="post"> ';
              echo ' <div class="row">';
                    echo '<div class="col-lg-8 mx-auto"><input style="background:#DE6B6C;color:white" class="btn btn-light" type="submit" value="Volver al inicio" />
                    </div>';
          echo '</form>';
        }
        else 
        {
          echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
          $response->getReasonPhrase();
        }
      }
      catch(HTTP_Request2_Exception $e) {
        echo 'Error: ' . $e->getMessage();
      }
    }
?>
        </div>
      </div>
    </div>
  </section>

