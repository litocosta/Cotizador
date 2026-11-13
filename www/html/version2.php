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
          echo $_POST['id_modelo']."<BR>";
          $recibido = $_POST['id_modelo'];
          $num_espacio = strpos($recibido,' ',0);
          //echo 'primer espacio: '.$num_espacio.'<BR>';
          $id = substr($recibido,0,$num_espacio);
          $marca_modelo = substr($recibido,$num_espacio+2);
          //echo 'marca_modelo: '.$marca_modelo.'<BR>';
          ////echo strlen($marca_modelo);
          $num_espacio2 = strpos($marca_modelo,' ',0);
          //echo 'segundo espacio: '.$num_espacio2.'<BR>';
          $marca = substr($marca_modelo,0,$num_espacio2);
          $modelo = substr($marca_modelo,$num_espacio2);
          require_once 'HTTP/Request2.php';
          $request = new HTTP_Request2();
          //$request->setUrl('https://test-info_auto.gestion.online/api/custom/public/vehicleProperties?vehicleId='.$id);
          $request->setUrl('https://test-info_auto.gestion.online/api/custom/public/vehicles?modelId='.$id);
          $request->setMethod(HTTP_Request2::METHOD_GET);
          $request->setConfig(array(
            'follow_redirects' => TRUE
          ));
          $request->setHeader(array(
            'Authorization' => cotizador_config('INFOAUTO_AUTHORIZATION_5'),
            'Accept' => 'application/vnd.gestion.online+json',
            'X-Force-Content-Type' => 'application/json'
          ));
          try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
              //echo $response->getBody();
              // mio
              $muestra = $response->getbody();
              //$muestra = '"id":"109976965","name":"Scania","resourceSlug":null"id":"114359873","name":"Renault","resourceSlug":null';
              //echo $muestra."<br>";
              $total_caracteres = strlen($muestra);
              $cursor = 0;
              $busca_id = 'id":"';
              $busca_nombre = 'name":"';
              $ano1 = 'since":';
              $ano2 = '"to":"';
              //echo $ano1;
              //$busca_nombre = 'description":"';
              $busca_comillas = '"';
              $salida = true;
              echo '<h4>Marca selecionada: '.$marca.'</h4><br>';
              echo '<h4>Modelo selecionado: '.$modelo.'</h4><br>';
              echo '<h5>Seleccione una version</h5>';
              echo '<form action="precio.php" method="post"> ';

              
              echo '<select  class="col-lg-8" name="id_version"';

              while ($salida)
              {
                  //echo '<option value="'.$id.'">'.$id.'  '.$nombre.'</option>';
                  //echo '<option value="'.$id.'">'.$nombre.' '.$encuentra_comillas.' '.'Esto es la resta: '.$la_resta.' '.'Esto ENCUENTRA ANO: '.$encuentra_ano1.'</option>';
                  if($nombre)
                  {
                    echo '<option value="'.$id.' '.$marca.' '.$modelo.' '.$nombre.'">'.$nombre.' ('.$anio1.'-'.$anio2.')'.'</option>';
                  }
                  
                  $encuentra_cadena = strpos($muestra,$busca_id,$cursor);
                  $encuentra_nombre = strpos($muestra,$busca_nombre,$cursor);
                  $encuentra_ano1 = strpos($muestra,$ano1,$cursor);
                  $encuentra_ano2 = strpos($muestra,$ano2,$cursor);
                  
                  if($encuentra_cadena=='')
                  {
                      $salida = false;
                  }
                  else
                  {
                      echo 'Cursor: '.$cursor;
                      echo 'encuentra cadena: '.$encuentra_cadena;
                      $encuentra_comillas = strpos($muestra,$busca_comillas,$encuentra_cadena+5);
                      //$encuentra_comillas = strlen(substr($muestra, $encuentra_cadena+5,))
                      echo 'encuentra comillas: '.$encuentra_comillas;
                      $la_resta = $encuentra_comillas-($encuentra_cadena+5);
                      //echo '<br> la resta es: '.$la_resta;
                      $id = substr($muestra,$encuentra_cadena+5,$la_resta);
                    
                      $encuentra_comillas = strpos($muestra,$busca_comillas,$encuentra_nombre+7);
                      $la_resta = $encuentra_comillas-($encuentra_nombre+7);
                      $nombre = substr($muestra,$encuentra_nombre+7,$la_resta);
                      //echo '<option value="'.$id.'">'.$id.'  '.$nombre.'</option>';
                      //echo '<br>'.'Id: '.$id.'   '.'Marca: '.$nombre.'<br>';

                      $encuentra_comillas = strpos($muestra,$busca_comillas,$encuentra_ano1);
                      $la_resta = $encuentra_comillas-($encuentra_ano1);
                      $since = substr($muestra,$encuentra_ano1+7,14);
                      $anio1 = substr($since,0,4);
                      $anio2 = substr($since,-4);

                      //$cursor = $encuentra_cadena+5+9; 
                      $cursor = $encuentra_comillas;
                  }  
              }
              echo '</select><BR><BR>';
              echo ' <div class="row">
                          <div class="col-lg-8 mx-auto"><input style="background:primary;color:dark" class="col-lg-8" type="submit" value="Continuar" />
              
                  </div>
                </div>';
              echo '</form>';
              echo '<BR>';
              echo '<form action="index.php" method="post"> ';
                  echo ' <div class="row">';
                        echo '<div class="col-lg-8 mx-auto"><input style="background:#343a40;color:white" class="col-lg-8" type="submit" value="Volver al inicio" />
                        </div>';
              echo '</form>';
              
              //termino mio
            }
            else {
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
