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
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 70%;
    height: 70%;
  }
  </style>
</head>

<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><strong>MONTIRONI</strong></a>
      <h6 style="color:white">Usuario:<?php echo ' '.$nombre_usuario; ?>
			<a id="salir" style="margin-left:1em;"  href="salir.php">Cerrar Sesión</a></h6>
    </div> 
</nav><br><br>
<section class="bg-primary text-white">
    <div class="container text-center">
        <div class="row">         
            <div class="col-lg-8 mx-auto"><br><br><br>
                <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Seleccionar cotización</strong></h4>
                <h5>Escriba la patente</h5>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
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
        if (isset($_POST['submit']))
        {
            //echo "<h5>entro</h5>";
           $data = $_POST['key'];
           $pos = strpos($data,'_',0);
           //echo $pos;
          $id = substr($data,0,$pos);
          $mostrar = substr($data,$pos+1);
            $sql_coti = "SELECT * FROM cotizados WHERE id='$id'";
            //$sql = "SELECT * FROM acara";
            $resultado_coti = mysqli_query($conn, $sql_coti) or die ('Error en el query database');
            $fila_coti = mysqli_fetch_array( $resultado_coti );
            echo '<H6>';
            echo $fila_coti['nombre'].' '.$fila_coti['apellido'].'<br>';
            echo $fila_coti['marca'].' '.$fila_coti['modelo'].' '.$fila_coti['version'].' '.$fila_coti['ano'].'<br>';
            echo '</H6>';
            $dir = "fotos/".$id."/";
            //echo $dir;
            $bandera = 0;
            // header("Content-Type: text/html;charset=utf-8");
            ?>
            <div class="carousel slide" data-ride="carousel" data-interval="false" id="carousel1">
                <div class="carousel-inner" role="listbox">
                    <?php
                    $photo = glob($dir . "*.{jpg,jpeg,gif,png}", GLOB_BRACE);
                    foreach ($photo as $photos) 
                    {
                        if ($bandera == 0)
                        {
                        ?>
                            <div class="carousel-item active"> 
                                <div class="container"> 
                                    <img  src="<?php print_r($photos) ?>" data-holder-rendered="true">
                                    <div class="carousel-caption">
                                  
                                    </div>
                                    <br><br><a style="background:#DE6B6C;color:white" class="btn btn-light" href="borra_foto.php?foto=<?php echo $photos ?>">Borrar</a>

                                </div>
                            </div>
                        <?php
                        $bandera = 1;
                        }
                        else
                        {
                        ?>
                            <div class="carousel-item">
                                <div class="container"> 
                                    <img  src="<?php print_r($photos) ?>" data-holder-rendered="true">
                                    <div class="carousel-caption">
                                    
                                        
                                    </div>
                                    <br><br><a style="background:#DE6B6C;color:white" class="btn btn-light" href="borra_foto.php?foto=<?php echo $photos ?>">Borrar</a>
                                </div>
                            </div>
                        <?php 
                        }
                    }?>
                    </div> <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                    </div>
                    <?php
                }
                echo '<BR><br>';
                echo '<a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a><br><br>';
                ?>
                </div>
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

</body>
</html>
<?php
}
?>

