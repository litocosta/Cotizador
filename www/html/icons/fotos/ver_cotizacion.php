 <?php
require_once __DIR__ . '/../../config.php';
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
<script>
        
        function escondeTraer()
        {
           document.getElementById('submit').style.display = 'none';
        }
         function muestraTraer()
        {
           document.getElementById('submit').style.display = 'block';
        }
      
    </script>
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
          <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Seleccionar cotización</strong></h4>
                   <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
                    <select class="col-lg-8" name="coti">
          <?php
          $sql = "SELECT * FROM cotizados WHERE usuario='$usuario'";
          //$sql = "SELECT * FROM acara";
          $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
          header("Content-Type: text/html;charset=utf-8");
        echo '<option value=""</option>Seleccionar';
          while($fila = mysqli_fetch_array( $resultado ) )
          {
           //echo mysqli_num_rows($resultado);
            echo '<option value="'.$fila['id'].'"</option>'.$fila['marca'].' '.$fila['modelo'].' '.$fila['version'].' '.$fila['ano'];
              
          }
          echo '</select><br><br>';
          
          echo ' <div class="row">
                        <div class="col-lg-8 mx-auto"><input style="font-size:1.5em;" id="submit" class="btn btn-light" type="submit" name="submit" value="traer" />
                </div>
              </div>';
          echo '</form>';
        
          }
          if (isset($_POST['submit'])){
                    //echo "<h5>entro</h5>";
                    $id = $_POST['coti'];
                    $sql_coti = "SELECT * FROM cotizados WHERE id='$id'";
                    //$sql = "SELECT * FROM acara";
                    $resultado_coti = mysqli_query($conn, $sql_coti) or die ('Error en el query database');
                    // header("Content-Type: text/html;charset=utf-8");

                    while($fila_coti = mysqli_fetch_array( $resultado_coti ) )
                    {
                    //echo mysqli_num_rows($resultado);
                        echo '<H3>';
                        echo $fila_coti['nombre'].' '.$fila_coti['apellido'].'<br>';
                        
                        echo $fila_coti['marca'].' '.$fila_coti['modelo'].' '.$fila_coti['version'].' '.$fila_coti['ano'].'<br>';
                        echo '</H3>';
                        //Creamos Nuestra Función
                    function lista_archivos($carpeta,$id)
                    { //La función recibira como parametro un carpeta
                    if (is_dir($carpeta)) 
                    { //Comprovamos que sea un carpeta Valido
                        if ($dir = opendir($carpeta)) 
                        {//Abrimos el carpeta
                            //echo '<ul>';
                            while (($archivo = readdir($dir)) !== false)
                            { //Comenzamos a leer archivo por archivo
                                if ($archivo != '.' && $archivo != '..' && substr($archivo,0,2)==$id)
                                { 
                                    $nuevaRuta = $carpeta.$archivo.'/';
                                    //echo '<li>'; //Abrimos un elemento de lista 
                                    if (is_dir($nuevaRuta)) 
                                    { //Si la ruta que creamos es un carpeta entonces:
                                        //echo 'poronga';
                                        echo '<h2><b>'.$nuevaRuta.'</b></h2>'; //Imprimimos la ruta completa resaltandola en negrita
                                        
                                        //echo '<img src="'.$nuevaRuta.'" />';
                                        //lista_archivos($nuevaRuta);//Volvemos a llamar a este metodo para que explore ese carpeta.
                                    } 
                                    else 
                                    { //si no es un carpeta:
                                        //echo 'Archivo: '.$archivo; //simplemente imprimimos el nombre del archivo actual
                                        echo '<img src="fotos/'.$archivo.'" style="width:30%;height:30%;margin:1em;"/>';
                                    }
                                    //'</li>'; //Cerramos el item actual y se inicia la llamada al siguiente archivo
                                }
                            }//finaliza 
                           // echo '</ul>';//Se cierra la lista
                            closedir($dir);//Se cierra el archivo
                        }
                    }
                    else
                    {//Finaliza el If de la linea 12, si no es un carpeta valido, muestra el siguiente mensaje
                        echo 'No Existe la carpeta';
                    }				
                    }
                        //F    in de la Función	 
                        //Llamamos a la función
                    lista_archivos("fotos/".$id,$id);
                                             
                    }
          }
            echo '<BR>';
          echo '<a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>';
          ?>
        </div>
      </div>
    </div>
  </section>