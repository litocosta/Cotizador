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
        <div class="col-lg-8 mx-auto">
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
<?php

        //$id = $_POST['id_modelo'];
        //$id_cliente = $_POST['id_cliente'];
        $recibido = $_POST['id_modelo'];
        //echo 'recibido: '.$recibido.'<BR>';
        $num_espacio = strpos($recibido,' ',0);
        //echo 'Num espacio: '.$num_espacio.'<BR>';
        $id_marca = substr($recibido,0,$num_espacio);

        $resto = substr($recibido,$num_espacio+1);
        //echo "resto es: ".$resto.'<BR>';
        $num_espacio = strpos($resto,' ',0);
        //$num_espacio = strpos($recibido,' ',0);
       // echo 'Num espacio: '.$num_espacio.'<BR>';
        $id_modelo = substr($resto,0,$num_espacio);
        $id_nombre_modelo = substr($resto,$num_espacio);
        //echo "resto es: ".$resto.'<BR>';
        
        //echo $id_modelo.'<BR>';
        //echo $marca.'<BR>';

        require_once 'HTTP/Request2.php';
        include 'genera_token.php';
        $request = new HTTP_Request2();
        $request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/'.$id_marca.'/groups/'.$id_modelo.'/models/');
        //$request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/'.'18'.'/groups/'.'28'.'/models/');
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
        'follow_redirects' => TRUE
         ));
        $request->setHeader(array(
        'Authorization' => 'Bearer '.$token,
        'Accept' => 'application/vnd.gestion.online+json',
        'X-Force-Content-Type' => 'application/json'
      ));

      try 
      {
        $response = $request->send();
        if ($response->getStatus() == 200) 
        {
  
          $muestra = $response->getbody();
          $total_caracteres = strlen($muestra);
          $json = substr($muestra,1,$total_caracteres-3);
          
          //$json ='{"as_codia":true,"brand":{"id":1,"name":"ACURA"},"codia":10001,"description":"INTEGRA LS SM","group":{"id":1,"name":"INTEGRA"},"list_price":false,"photo_url":"https://storage.googleapis.com/preciosa-staging-cars-images/78092543-b34f-4886-976e-1b966d8d377c.jpg","position":1,"prices":true,"prices_from":1992,"prices_to":1997,"r_codia":null,"summary":""},{"as_codia":true,"brand":{"id":1,"name":"ACURA"},"codia":10003,"description":"INTEGRA RS SM","group":{"id":1,"name":"INTEGRA"},"list_price":false,"photo_url":null,"position":2,"prices":true,"prices_from":1992,"prices_to":1997,"r_codia":null,"summary":""}';
          //echo $json."<br>";
          $fin = '},{';
          $busco = strpos($json, $fin, 0);
          $bandera = true;
          //echo '<BR>Busco: '.$busco;
          if ($busco=='')
          {
            $registro = substr($json,0);  
          }
          else {
            $registro = substr($json,0,$busco+1);  # code...
          }
          
          //echo '<BR>REgistro: '.$registro;
          $obj = json_decode($registro);
          $nombre = $obj->{'brand'}->{'name'};
          print '<H4>Marca seleccionada: '.$nombre.'</H4>';
          echo '<H4>Modelo seleccionado:'.$id_nombre_modelo.'<BR>'.'</h4>';
          //$restito = substr($json,$busco+2);
          echo '<h5>Seleccione una versión</h5>';
          echo '<form action="precios.php" method="post"> ';
          //echo'<input hidden name="id_cliente" value="'.$id_cliente.'">';
          echo '<select class="col-lg-8" name="id_version"';
          echo $nombre;
          while($bandera or strlen($registro) > 6 )
          {
            if($bandera)
            {
              echo 'entro por bandera verdad<BR>';
              $restito = substr($json,$busco+2);
            }
            //echo 'Bandera: '.$bandera;
            $bandera = false;
            
            echo '<BR>REgistro: '.$registro;
            
            echo '<BR><BR>REstito: '.$restito;
            $obj = json_decode($registro);
            //echo '<option value="'.$obj->{'codia'}.' '.$nombre.' '.$id_nombre_modelo.' '.$obj->{'description'}.' ">'.$obj->{'description'}.'</option>';
            echo '<option value="'.$obj->{'codia'}.' '.$nombre.' '.$obj->{'description'}.' ">'.$obj->{'description'}.'</option>';
            //print '<BR><BR>'.$obj->{'codia'}.' '.$obj->{'description'}.'<BR>';
           
            $busco = strpos($restito, $fin, 0);
            $registro = substr($restito,0,$busco+1);
            $restito = substr($restito,$busco+2);
            echo 'largo registro: '.strlen($registro);
            echo '<BR>Busco: '.$busco;
           
          }
            echo '<BR><BR>ultimo restito REstito: '.$restito;
            if (strlen($restito) > 10)
            {
              $codia_ant = $obj->{'codia'};
              $restito = '{"'.$restito; 
                echo '<BR><BR>ultimo restito REstito: '.$restito;
              $obj = json_decode($restito); 
              if($obj->{'codia'} == $codia_ant)
              {
                echo 'son iguales';
              }
              else {
                echo '<option value="'.$obj->{'codia'}.' '.$nombre.' '.$id_nombre_modelo.' '.$obj->{'description'}.' ">'.$obj->{'description'}.'</option>';# code...
              }
              //print '<BR><BR>'.$obj->{'codia'}.' '.$obj->{'description'}.'<BR>';
              //echo '<option value="'.$obj->{'codia'}.' '.$nombre.' '.$id_nombre_modelo.' '.$obj->{'description'}.' ">'.$obj->{'description'}.'</option>';
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
      catch(HTTP_Request2_Exception $e) 
      {
        echo 'Error: ' . $e->getMessage();
      }
    }
    ?>

     </div>
      </div>
    </div>
  </section>
