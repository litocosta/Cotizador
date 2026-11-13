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
          <h4><strong>Precios actualizados</strong></h4>
        <?php
require_once __DIR__ . '/config.php';
        session_start();
        if(empty($_SESSION["admin"]))
        {
          header("location: acceso.php");
        }
        else
        {
        //echo $_POST['id_version'];
        $recibido = $_POST['id_version'];
        //echo 'Esto es lo recibido: '.$recibido."<BR>";
        $num_espacio = strpos($recibido,' ',0);
        //echo 'primer espacio: '.$num_espacio.'<BR>';
        $id = substr($recibido,0,$num_espacio);
        $marca_modelo = substr($recibido,$num_espacio+1);
        echo '<H3>'.$marca_modelo.'</H3><BR>';
        ////echo strlen($marca_modelo);
        $num_espacio2 = strpos($marca_modelo,' ',0);
        //echo 'segundo espacio: '.$num_espacio2.'<BR>';
        $marca = substr($marca_modelo,0,$num_espacio2);
        $modelo = substr($marca_modelo,$num_espacio2);
        require_once 'HTTP/Request2.php';

        require_once 'HTTP/Request2.php';
        $request = new HTTP_Request2();
        //GET
        //https://test-info_auto.gestion.online/api/custom/private/
        //vehicleCurrentPrices?vehicleId=87174624
        //$request->setUrl('https://test-info_auto.gestion.online/api/custom/private/vehicleCurrentPrices?vehicleId='.$id.'\n&access_token=eaf9d3cedc4532663e10844282728a91ffeb25d43d7712e1213f63c021e69d62');
        //$request->setUrl('https://test-info_auto.gestion.online/api/custom/private/vehicleCurrentPrices?vehicleId=87174624'); ANDA
        //$request->setUrl('https://test-info_auto.gestion.online/api/custom/private/vehicleCurrentPrices?vehicleId='.$id); //testeo
        $request->setUrl('https://test-info_auto.gestion.online/api/custom/private/vehicleCurrentPrices?vehicleId='.$id);
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
          'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
          'Authorization' => cotizador_config('INFOAUTO_AUTHORIZATION_3'),
          'Accept' => 'application/vnd.gestion.online+json',
          'X-Force-Content-Type' => 'application/json'
        ));
        try {
          $response = $request->send();
          if ($response->getStatus() == 200) {
            //echo $response->getBody();

            $muestra = $response->getbody();
            //$muestra = '"id":"109976965","name":"Scania","resourceSlug":null"id":"114359873","name":"Renault","resourceSlug":null';
            echo $muestra."<br>";
            $total_caracteres = strlen($muestra);
            $cursor = 0;
            $inicio = '"';
            $coma = ',';
            $busca_coma = 1;
            $dos_puntos = ':';
            $corchete = '}';
            $comilla = '"';
            $salida = true;
            //echo '<h4>Marca selecionada: '.$marca.'</h4><br>';
            //echo '<h4>Modelo selecionado: '.$modelo.'</h4><br>';
            //echo '<h5>Seleccione una version</h5>';
            //echo '<form action="precio.php" method="post"> ';

            
            //echo '<select  class="col-lg-8" name="id_version"';
            //echo '<table><tr><td>Modelo</td><td>Precio</td></tr>';
            echo'<ul class="navbar-nav ml-auto">
                  <li class="nav-item"><h4>Modelo Precio</h4></li>';
            while ($salida)
            {
                
                if($busca_coma == 0)
                {
                    $salida = false;
                }
                else
                {
                  /*if ($cursor==0)
                  {

                  }*/
                  $busca_coma = strpos($muestra,$coma,$cursor);
                  $busca_dos_puntos = strpos($muestra,$dos_puntos,$cursor);
                  $busca_comillas = strpos($muestra,$comilla,$cursor);
                  // $valor = substr($muestra,$busca_coma,3);
                  //echo '<BR>comillas es: <p style="color:red;">'.$busca_comillas.'</p><BR>';
                  //echo '<BR>Dos puntos es: <p style="color:red;">'.$busca_dos_puntos.'</p><BR>';
                  //echo '<BR>Coma esta en: <p style="color:red;">'.$busca_coma.'</p><BR>';
                  if ($busca_coma <> 0)
                  {
                    $precio = substr($muestra,$busca_dos_puntos+1,($busca_coma-$busca_dos_puntos)-1);
                    $ano = substr($muestra,$busca_comillas+1,($busca_dos_puntos-$busca_comillas)-2);
                  // echo '<BR>Precio es: <p style="color:red;">'.$precio.' Modelo es: '.$ano.' </p><BR>';
                    if(strlen($precio) > 3)
                    {
                      $cadena = substr($precio,0,strlen($precio)-3).'.'.substr($precio,-3);
                      //echo 'cadena: '.$cadena;
                      $precio = $cadena;
                    }
                    echo '<li class="nav-item" style="margin-left:2em">'.$ano.' $'.$precio.'.000</li>';
                    $cursor = $busca_coma+1;    
                  }
                  else {
                  // echo 'Entro por nada';
                    $busca_corchete = strpos($muestra,$corchete,$cursor);
                    $precio = substr($muestra,$busca_dos_puntos+1,($busca_corchete-$busca_dos_puntos)-1);
                    if(strlen($precio) > 3)
                    {
                      //$cadena = substr($precio,-3);
                      $cadena = substr($precio,0,strlen($precio)-3).'.'.substr($precio,-3);
                      //echo 'cadena: '.$cadena;
                      $precio = $cadena;
                    }
                    $ano = substr($muestra,$busca_comillas+1,($busca_dos_puntos-$busca_comillas)-2);
                    //echo '<BR>Precio es: <p style="color:red;">'.$precio.' Modelo es: '.$ano.' </p><BR>';
                    echo '<li class="nav-item" style="margin-left:2em">'.$ano.' $'.$precio.'.000</li>';
                  }
                  
                }  
              }
            echo '</ul>';
              echo '<BR><form action="marcas.php" method="post"> ';
                echo ' <div class="row">';
                      echo '<div class="col-lg-8 mx-auto"><input style="background:#343a40;color:white" class="col-lg-8" type="submit" value="Volver al inicio" />
                      </div>';
            echo '</form>';
          }
          else 
          {
            //echo $response->getBody();
            //echo 'En este momento no podemos atender su solicitud, disculpe los inconvenientes' . $response->getStatus() . ' ' .
            //$response->getReasonPhrase();
            
            if ($response->getStatus()==502)
            {
                echo 'En este momento no podemos atender su solicitud, disculpe los inconvenientes';
                echo '<BR><BR>';
            echo '<form action="marcas.php" method="post"> ';
                echo ' <div class="row">';
                      echo '<div class="col-lg-8 mx-auto"><input style="background:#343a40;color:white" class="col-lg-8" type="submit" value="Volver al inicio" />
                      </div>';
            echo '</form>';
            }
            if ($response->getStatus()==403)
            {
                echo 'Token incorrecto';
                echo '<BR><BR>';
            echo '<form action="marcas.php" method="post"> ';
                echo ' <div class="row">';
                      echo '<div class="col-lg-8 mx-auto"><input style="background:#343a40;color:white" class="col-lg-8" type="submit" value="Volver al inicio" />
                      </div>';
            echo '</form>';
            }
            
            //echo 'En este momento no podemos atender su solicitud, disculpe los inconvenientes';// . $response->getStatus() . ' ' .
            //$response->getReasonPhrase();
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