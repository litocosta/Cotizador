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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 50%;
    height: 50%;
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
                    $fila_coti = mysqli_fetch_array( $resultado_coti );
                     echo '<H5>';
                        echo $fila_coti['nombre'].' '.$fila_coti['apellido'].'<br>';
                        
                        echo $fila_coti['marca'].' '.$fila_coti['modelo'].' '.$fila_coti['version'].' '.$fila_coti['ano'].'<br>';
                        echo '</H5>';
                        $dir = "fotos/".$id."/";
                    //echo $dir;
                    $bandera = 0;
                    // header("Content-Type: text/html;charset=utf-8");
                  ?>
               
                    <div class="carousel slide" data-ride="carousel" id="carousel1">
                        <div class="carousel-inner" role="listbox">
                            <?php
                            $photo = glob($dir . "*.jpg");
                            foreach ($photo as $photos) 
                            {
                                if ($bandera == 0){
                                ?>
                                <div class="carousel-item active"> 
                                    <div class="container"> 
                                    <img  src="<?php print_r($photos) ?>" data-holder-rendered="true">
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
                                <?php }}?>

                           

                        </div> <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                    </div>

            </div>
        </div>
        <?php } ?>
            <?php
         
            echo '<BR><br>';
          echo '<a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a><br><br>';
          ?>
        
    </div>

</section>
</body>
</html>
