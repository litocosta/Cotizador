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
<link rel="stylesheet" href="css/styles.css">
  
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
          <!--<h4><strong>Precios actualizados</strong></h4>-->
         <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Subir fotos</strong></h4>
         <h4>Escriba la patente</h4>
         <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data" autocomplete="off">
           <div class="input-group input-group-sm">
            <input class="search_query form-control" type="text" name="key" id="key" placeholder="Buscar..." onfocus="esconder();">

              <span class="input-group-btn">
                 <button name="submit" type="submit" class="btn btn-light" style="margin-left:1em">Traer</button>
              </span>
           </div>
         </form>
     
          <div id="suggestions">
          </div>
       
      </div>
      
      </body>
     
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script>
         $(document).ready(function() {
            $('#key').on('keyup', function() {
                var key = $(this).val();		
                var dataString = 'key='+key;
                    $.ajax({
                      type: "POST",
                      url: "ajax.php",
                      data: dataString,
                      success: function(data) {
                          //Escribimos las sugerencias que nos manda la consulta
                          $('#suggestions').fadeIn(1000).html(data);
                          //Al hacer click en algua de las sugerencias
                          $('.suggest-element').on('click', function(){
                                  //Obtenemos la id unica de la sugerencia pulsada
                                  var id = $(this).attr('id');
                                  //Editamos el valor del input con data de la sugerencia pulsada
                                  $('#key').val($('#'+id).attr('data'));
                                  //Hacemos desaparecer el resto de sugerencias
                                  $('#suggestions').fadeOut(1000);
                                  //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                                  return false;
                          });
                      }
                  });
              });
          }); 
           $(document).ready(function() {
            $('#key').on('click', function() {
                var key = $(this).val();		
                var dataString = 'key='+key;
                    $.ajax({
                      type: "POST",
                      url: "ajax.php",
                      data: dataString,
                      success: function(data) {
                          //Escribimos las sugerencias que nos manda la consulta
                          $('#suggestions').fadeIn(1000).html(data);
                          //Al hacer click en algua de las sugerencias
                          $('.suggest-element').on('click', function(){
                                  //Obtenemos la id unica de la sugerencia pulsada
                                  var id = $(this).attr('id');
                                  //Editamos el valor del input con data de la sugerencia pulsada
                                  $('#key').val($('#'+id).attr('data'));
                                  //Hacemos desaparecer el resto de sugerencias
                                  $('#suggestions').fadeOut(1000);
                                  //alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                                  return false;
                          });
                      }
                  });
              });
          }); 
        
        </script>
  
        </div>
        <?php
        
        if (isset($_POST['submit'])){
           $data = $_POST['key'];
           $pos = strpos($data,'_',0);
           //echo $pos;
          $id = substr($data,0,$pos);
          $mostrar = substr($data,$pos+1);
                    // echo $id;
          echo $mostrar.'<br><br>';
          echo '<form action="envio_fotos.php" method="post" enctype="multipart/form-data"> ';
         
         
            $sql = "SELECT * FROM cotizados WHERE id='$id'";
          
            $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
            //header("Content-Type: text/html;charset=utf-8");

            $fila = mysqli_fetch_array( $resultado );
            ?>   
            
            <div id="esconder" class="row">
                
            
                <div class="col-lg-8 mx-auto">
                <input type="file" name="imagen[]" id="imagen[]" multiple=""/><br><br>
                <input type="text" hidden name="id_coti" id="id_coti" value="<?php echo $id;?>"/><br><br>
                <input style="font-size:1.5em;" class="btn btn-light" type="submit" value="subir fotos" />
                </div>
            </div>
          </form>
        <?php
        }
       ?>
      <br><a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
          </button>
      </a> 
      </div>
       
    </div>
    <script>
    function esconder(){
          //alert('estro');
          //document.getElementById("esconder").style.background = "grey";
          document.getElementById('esconder').hidden = true;
          //document.getElementById('suggestions').hidden = true;
        }
    </script>
  </section>
  <?php
    }
  ?>