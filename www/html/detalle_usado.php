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
    $id_cotizados = $_GET['id'];
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
    width: 80%;
    height: 80%;
  }
  #contenedor{
   overflow:hidden;
   display:inline-block; 
   vertical-align:top;
   /*background:rgb(245,245,245);*/
  }
    
    #bloque{
    float: left;
    width: 8em;
    /*height:10em;*/
    margin:1.5em;
    padding:0.3em;
    border:solid 1px ;
    border-radius:0.3em; 
    /*background:rgb(0,123,255);*/
    background:white;
    /*background:rgb(0,123,255);*/
    color:black;
    }

    #bloque p{
        font-weight:normal;
    }


    #bloque img{
        background: #B5E9AD;
    }
    ::-webkit-scrollbar {
    display: none;
    }
    body{
        /*overflow-y:;*/
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
        //if (isset($_POST['submit']))
        //{
            //echo "<h5>entro</h5>";
           //$data = $_POST['key'];
           //$pos = strpos($data,'_',0);
           //echo $pos;
          //$id = substr($data,0,$pos);
          //$mostrar = substr($data,$pos+1);
            $sql_usu = "SELECT * FROM usados WHERE id_cotizados='$id_cotizados'";
            $resultado_usu = mysqli_query($conn, $sql_usu) or die ('Error en el query database');
            $fila_usu = mysqli_fetch_array( $resultado_usu ); 
            $sql_coti = "SELECT * FROM cotizados WHERE id='$id_cotizados'";
            //$sql = "SELECT * FROM acara";
            $resultado_coti = mysqli_query($conn, $sql_coti) or die ('Error en el query database');
            $fila_coti = mysqli_fetch_array( $resultado_coti );
            echo '<H6>';
            //echo $fila_coti['nombre'].' '.$fila_coti['apellido'].'<br>';
            //echo $fila_coti['marca'].' '.$fila_coti['modelo'].' '.$fila_coti['version'].' '.$fila_coti['ano'].'<br>';
            echo '</H6>';
            $dir = "fotos/".$id_cotizados."/";
            //unlink("fotos/".$id_cotizados."/muestra.jpg");
            //echo $dir;
            $bandera = 0;
            // header("Content-Type: text/html;charset=utf-8");
            ?>
            <div style="display: block; vertical-align: middle;" class="carousel slide" data-ride="carousel" data-interval="false" id="carousel1">
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
                                    <img src="<?php print_r($photos) ?>" data-holder-rendered="true">
                                    <div class="carousel-caption">
                                  
                                    </div>
                                   

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
                                   
                                </div>
                            </div>
                        <?php 
                        }
                    }?>
                    </div> <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                    </div>
                    <?php
            //    }
               
                ?>
                </div>
                
            <BR><br>
            <div style="text-align:center; color:white">
              <h5><?php echo $fila_coti['marca'].' '.$fila_coti['modelo']; ?></h5>
              <h6><?php echo $fila_coti['version'].' '.$fila_coti['color']; ?></h6>
              
              
              <h6><?php echo 'Precio: $'.number_format($fila_usu['valor_sugerido'],0,'','.'); ?></h6>
              <h6><?php echo 'Patente: '.$fila_usu['patente']; ?></h6>
              <h6><?php echo 'Ubicación: '.$fila_usu['ubicacion']; ?></h6>
            <div id="contenedor" style="font-size:1em; ">
                  
                    <br>
                    <div id="bloque">
                        <img src="image/agenda.png">
                        <p>Modelo</p>
                        <p><strong><?php echo $fila_coti['ano']; ?></strong></p>
                    </div>
                    <div id="bloque">
                        <img src="image/km.png">
                        <p>Kilometraje</p>
                        <p><strong><?php echo number_format($fila_coti['kilometros'],0,'','.').' km'; ?></strong></p>
                    </div>
                    <div id="bloque">
                        <img src="image/combustible2.png">
                        <p>Combustible</p>
                        <p><strong><?php echo $fila_coti['combustible']; ?></strong></p>
                    </div>
                    <div id="bloque">
                        <img src="image/caja.png">
                        <p>Transmisión</p>
                        <p><strong><?php echo $fila_coti['transmision']; ?></strong></p>
                    </div>
                     <div id="bloque">
                        <img src="image/asientos.png">
                        <p>Plazas</p>
                        <p><strong><?php echo $fila_coti['asientos']; ?></strong></p>
                    </div>
                     <div id="bloque">
                        <img src="image/cilindrada.png">
                        <p>Cilindrada</p>
                        <p><strong><?php 
                        if($fila_coti['cilindrada'] < 10)
                        {
                            echo $fila_coti['cilindrada'].' Lts'; 
                        }
                        else {
                            echo round($fila_coti['cilindrada'],0).' cm<sup>3</sup>'; 
                        }
                        
                        ?></strong></p>
                    </div>
                   
                    
            </div><br><br>
            <a href="javascript: history.go(-1)">
                        <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Atras
                        </button>
            </a><br>
            <a href="index.php">

                    <br><br><button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                    </button>
            </a></div><br><br>

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

