<?php
require_once __DIR__ . '/config.php';
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
 session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
   
      $usuario = $_SESSION["admin"];
      if (isset($_POST['marca'])) 
      {
        $marca = $_POST["marca"];
      }
      else
      {
        $marca ="";
      }
      if (isset($_POST['texto'])) 
      {
        $texto = $_POST["texto"];
      }
      else
      {
        $texto ="";
      }
      if (isset($_POST['ano1'])) 
      {
        $ano1 = $_POST["ano1"];
      }
      else
      {
        $ano1 ="";
      }
      if (isset($_POST['ano2'])) 
      {
        $ano2 = $_POST["ano2"];
      }
      else
      {
        $ano2 ="";
      }
      if (isset($_POST['precio1'])) 
      {
        $precio1 = $_POST["precio1"];
      }
      else
      {
        $precio1 ="";
      }
      if (isset($_POST['precio2'])) 
      {
        $precio2 = $_POST["precio2"];
      }
      else
      {
        $precio2 ="";
      }

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
<style>
      .title {
        display: block;
        
        clear: both;
      }    
      .title .date {
        float: right;
      }      
      .title .name {
        float: left;
      }
      li {
        display:inline-block;
      }
      a {
        width:1em;
      }
    </style>
<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><strong>MONTIRONI</strong></a>
      <h6 style="color:white">Usuario:<?php echo ' '.$nombre_usuario; ?>
			<a id="salir" style="margin-left:1em;"  href="salir.php">Cerrar Sesión</a></h6>
    </div> 
  </nav>
  <section class="bg-primary text-white">
    <div class="container text-center"  style="margin-bottom: -3em">
     
          <h4 style="background:darkgrey; border: 1px;border-radius:5px;"><strong>Resultado de la busqueda</strong></h4>
          <div class="container text-center">
          <br><br>
        <table>
          <tr>
            <td style="width:5em;"></td><td style="width:10em; text-align:left; padding-left:1em;"></td>

            <td style="background:rgb(102, 205, 170); color:rgb(102, 205, 170); width:5em;"></td><td style="width:15em; text-align:left; padding-left:1em;">Usados Propios</td>
            
            <td style="background:rgb(239, 245, 124); color:rgb(239, 245, 124); width:5em;"></td><td style="width:15em; text-align:left; padding-left:1em;">A ingresar</td>
           
            <td style="background:rgb(245, 201, 124); color:rgb(245, 201, 124); width:5em;"></td><td style="width:15em; text-align:left; padding-left:1em;">Reventa</td>
          </tr>
        </table>
    </div>
    </div>
 </section>
 <br>
<?php
 /*echo '<div>
        <table>
          <tr>
            <td style="background:rgb(102, 205, 170); color:rgb(102, 205, 170)">Color</td><td>Usados Propios</td>
            <td style="background:white; color:white">Color</td>
            <td style="background:rgb(239, 245, 124); color:rgb(239, 245, 124)">Color</td><td>A ingresar</td>
            <td style="background:white; color:white">Color</td>
            <td style="background:rgb(245, 201, 124); color:rgb(245, 201, 124)">Color</td><td>Reventa</td>
          </tr>
        </table>
    </div>';*/
//echo '<h4>a : '.$marca.'</h4>';
//echo '<h4>Texto: '.utf8_encode($texto).'</h4>';
//echo '<h4>años: '.$ano1.'-'.$ano2.'</h4>';
$page = false;

//examino la pagina a mostrar y el inicio del registro a mostrar
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}

if (!$page) {
    $start = 0;
    $page = 1;
} else {
    $start = ($page - 1) * 6;
}

if($marca!="")
{
    if($texto!="")
    {
        if($ano1!="")
        {
            if($ano2!="")
            {
                if($precio1!="" AND $precio2!="")
                {
                    //echo "ENTRO POR TODOS los filtros";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' 
                            AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' 
                            AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";
                }
                else 
                {
                    //echo "ENTRO POR marca texto y anios";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC";
                }
                
            }
            else
            {
                if($precio1!="" AND $precio2!="")
                {
                   //echo "ENTRO POR marca, texto precios y un aÑo en particular";
                   $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio ='$ano1' AND valor_sugerido >='$precio1' 
                          AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";    
                   $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio ='$ano1' AND valor_sugerido >='$precio1' 
                          AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";    
                }
                else
                {
                    //echo "ENTRO POR marca, texto y un aÑo en particular";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio ='$ano1' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND anio ='$ano1'  ORDER BY tipousado DESC";
                }

            }
        }
        else
        {
            if($precio1!="" AND $precio2!="")
            {
              //  echo "ENTRO POR marca y texto y precios";
                $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";
            }
            else 
            {
               // echo "ENTRO POR marca y texto";
                $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND  descripcion LIKE '%$texto%' ORDER BY tipousado DESC";
            }
        }
    }
    else
    {
        if($ano1!="")
        {
            if($ano2!="")
            {
                if($precio1!="" AND $precio2!="")
                {
                  //  echo "ENTRO POR marca y 2 años y precios";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";
                }
                else 
                {
                  //  echo "ENTRO POR marca y 2 años";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC";
                }
            }
            else
            {
                if($precio1!="" AND $precio2!="")
                {
                   // echo "ENTRO POR marca y un aÑo en particular";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio ='$ano1' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio ='$ano1' ORDER BY tipousado DESC";
                }
                else 
                {
                  //  echo "ENTRO POR marca precios y un aÑo en particular";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio ='$ano1' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' AND anio ='$ano1' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";
                }
            }
        }
        else
        {
          //  echo "ENTRO POR marca";
            $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' ORDER BY tipousado DESC LIMIT ".$start.", 6";
            $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' ORDER BY tipousado";
        }
        //$sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%'";
    }
}
else
{
    if($texto!="")
    {
        if($ano1!="")
        {
            if($ano2!="")
            {
                if($precio1!="" AND $precio2!="")
                {
                   // echo "ENTRO POR texto precios y 2 años";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";    
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";    
                }
                else
                {
                   // echo "ENTRO POR texto y 2 años";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC LIMIT ".$start.", 6";    
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC";    
                }
                
            }
            else
            {
                if($precio1!="" AND $precio2!="")
                {
                  //  echo "ENTRO POR texto precios y un aÑo en particular";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio ='$ano1' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio ='$ano1' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";  
                }
                else 
                {
                  //  echo "ENTRO POR texto y un aÑo en particular";
                    $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio ='$ano1' ORDER BY tipousado DESC LIMIT ".$start.", 6";    
                    $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND anio ='$ano1' ORDER BY tipousado DESC";    
                }
                
            }
        }
        else
        {
            if($precio1!="" AND $precio2!="")
            {
               // echo "ENTRO POR texto y precios";
                $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";
            }
            else 
            {
               // echo "ENTRO POR texto";
                $sql = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                $sql1 = "SELECT * FROM usados WHERE descripcion LIKE '%$texto%' ORDER BY tipousado DESC";
            }
            
        }
    }
    else
    {
        if($ano1!="")
        {
            if($ano2!="")
            {
                if($precio1!="" AND $precio2!="")
                {  
                   //echo "ENTRO POR 2 años y precios";
                    $sql = "SELECT * FROM usados WHERE anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE anio >='$ano1' AND anio <='$ano2' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado";
                }
                else 
                {
                   // echo "ENTRO POR 2 años<br>";
                   // echo "anio1 es: ".$ano1."<br>";
                   // echo "anio2 es: ".$ano2."<br>";
                  

                    $sql = "SELECT * FROM usados WHERE anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE anio >='$ano1' AND anio <='$ano2' ORDER BY tipousado DESC";
                }
                
            }
            else
            {
                if($precio1!="" AND $precio2!="")
                {
                  //  echo "ENTRO POR un aÑo en particular y precios";
                    $sql = "SELECT * FROM usados WHERE anio ='$ano1' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE anio ='$ano1' AND valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";
                }
                else 
                {
                   /// echo "ENTRO POR un aÑo en particular";
                    $sql = "SELECT * FROM usados WHERE anio ='$ano1' ORDER BY tipousado DESC LIMIT ".$start.", 6";
                    $sql1 = "SELECT * FROM usados WHERE anio ='$ano1' ORDER BY tipousado DESC";
                }
                
            }
        }
        else
        {
            if($precio1!="" AND $precio2!="")
            {
              //  echo "ENTRO por años";
                $sql1 = "SELECT * FROM usados WHERE valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC";
                $sql = "SELECT * FROM usados WHERE valor_sugerido >='$precio1' AND valor_sugerido <='$precio2' ORDER BY tipousado DESC LIMIT ".$start.", 6";
            }
            else 
            {
                //echo "ENTRO sin filtros";
                $sql1 = "SELECT * FROM usados  ORDER BY tipousado DESC";
                $sql = "SELECT * FROM usados  ORDER BY tipousado DESC LIMIT ".$start.", 6";
                
            }
            
        }    
    }

}
//$sql = "SELECT * FROM usados WHERE descripcion LIKE '%$marca%' OR  descripcion LIKE '$texto'";
//$sql = "SELECT * FROM acara";
//$resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
$resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
$num_total_rows = $resultado->num_rows;
//echo '<h4>Seleccione un año </h4>';
$resultado1 = mysqli_query($conn, $sql1) or die ('Error en el query database');
//echo "<br>Encontrados: ".mysqli_num_rows($resultado1);
//echo "<br>Start: ".$start."<br>";
if (mysqli_num_rows($resultado1) <= 0 )
{
    echo '<br><h5 style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">No se encontraron automoviles con esas características</h5><br>'  ;
}
else
{
//calculo el total de paginas

//$total_pages = ceil($num_total_rows / 6);
$total_pages = ceil(mysqli_num_rows($resultado1) / 6);
//echo '<section class="bg-primary text-white">';
//echo '<div style="display:inline-block;width:100%">';
echo '<div id="" class="container">
        <div class="row align-items-start">
        ';
        $color=0;
        while($fila = mysqli_fetch_array( $resultado ) )
        {
            $bandera = 0;
            $id = $fila["id_cotizados"];
            //echo '<div style="display:inline-block">';
            //echo '<div style="border:solid; width:300px">';
            //echo '<div class="col-sm-4">';
            $dir = "fotos/".$id."/";
            $photo = glob($dir . "*.{jpg,jpeg,gif,png}", GLOB_BRACE);
            //echo "FOTOS:".$photo[0].'<br>';
            if(!empty($photo)){
              echo '<div class="col-sm-4">';
              //echo "FOTOS:".$photo[0];
              //echo "inicio: ".$start;
              foreach ($photo as $photos) 
              {
              
                  if ($bandera==0)
                  {
                  $id_cotizados = $fila['id_cotizados'];
                  $imagen = getimagesize($photos);    //Sacamos la información
                  $ancho = $imagen[0];              //Ancho
                  $alto = $imagen[1];               //Alto

                  ?>
                      <a href="detalle_usado.php?id=<?php echo $id_cotizados;?>" >
                          <div style="height:278px; width:350px; border: solid 1px gray; text-align:center; background:white">
                          <figure>
                          <?php
                         // if ($ancho > $alto)
                         // {
                        
                            $imagen_original = imagecreatefromjpeg($photos);
 
                            //Obtengo el ancho de la imagen quecargue
                            $ancho_original = imagesx($imagen_original);
                            
                            //Obtengo el alto de la imagen que cargue
                            $alto_original = imagesy($imagen_original);
                            
                            //SI QUEREMOS UN ANCHO FINAL FIJO, calculamos el ALTO de forma proporcionada
                            $ancho_final = 348;
                            
                            //Ancho final en pixeles
                            $alto_final = ($ancho_final / $ancho_original) * $alto_original;
                            
                            //SI CONOCEMOS UN ALTO FINAL FIJO, calculamos el ANCHO de forma proporcionada
                            
                            //Para usar este caso, comentar las dos lineas anteriores, y descomentar las dos siguientes a este comentario
                            
                            /*$alto_final = 250; //Alto final en pixeles
                            $ancho_final = ($alto_final / $alto_original) * $ancho_original;*/
                            
                            //Creo una imagen vacia, con el alto y el ancho que tendrá la imagen redimensionada
                            $imagen_redimensionada = imagecreatetruecolor($ancho_final, $alto_final);
                            
                            //Copio la imagen original con las nuevas dimensiones a la imagen en blanco que creamos en la linea anterior
                            $muestra = imagecopyresampled($imagen_redimensionada, $imagen_original, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho_original, $alto_original);
                            
                            //Guardo la imagen ya redimensionada
                            imagejpeg($imagen_redimensionada, $dir.'muestra.jpg');
                            
                            //Libero recursos, destruyendo las imágenes que estaban en memoria
                            imagedestroy($imagen_original);
                            
                            imagedestroy($imagen_redimensionada);
                            
                            echo '<img src='.$dir.'muestra.jpg>';
                       
                          //}
                         

                                                    
                          ?>
                          </figure>
                          </div>
                          
                          <?php
                          $total_car = strlen($fila['descripcion']);
                          $busca_espacio = strpos($fila['descripcion']," ");
                          $texto_1 = substr($fila['descripcion'],0,$busca_espacio); 
                          $texto_2 = substr($fila['descripcion'],$busca_espacio+1); 
                          $busca_espacio = strpos($texto_2," ");
                          $texto_1 = $texto_1 .' '. substr($texto_2,0,$busca_espacio); 
                          $texto_2 = substr($texto_2,$busca_espacio+1); 
                        
                          // $texto_1 = $texto_1 + substr($texto_2,$busca_espacio);
                          //$segundo_texto = substr($fila['descripcion'],$busca_espacio);
                          if($fila['tipousado']=='U'){
                              // echo 'Color: '.$color;
                                echo '<div style="height:150px; width:350px; margin-bottom:2em; margin-top:-1em; 
                              border-bottom-left-radius: 15%; border-bottom-right-radius: 15%; background:rgb(102, 205, 170); color:black">';
                            $color=1;
                          }
                          elseif($fila['tipousado']=='S'){
                              //echo 'Color: '.$color;
                                echo '<div style="height:150px; width:350px; margin-bottom:2em; margin-top:-1em; 
                              border-bottom-left-radius: 15%; border-bottom-right-radius: 15%; background:rgb(239, 245, 124); color:black">';
                              $color=2;
                          }
                          else{
                              // echo 'Color: '.$color;
                                echo '<div style="height:150px; width:350px; margin-bottom:2em; margin-top:-1em; 
                              border-bottom-left-radius: 15%; border-bottom-right-radius: 15%; background:rgb(245, 201, 124); color:black">';
                              $color=0;
                          }
                        
                        
                          //echo '<p style="margin:0.6em;">'.$fila['descripcion'].'</p>';
                          echo '<div style="margin-left:0.4em; font-size:1.3em; font-weight:bold;">'.$texto_1.'</div>';
                          echo '<div style="margin-left:0.6em;">'.$texto_2.'</div>';
                          //echo '<p style="margin:0.6em;">Modelo: '.$fila['anio'].'</p>';
                          echo '<br>
                                      <div  class="title" style="margin-left:0.4em; font-size:1.2em; font-weight:bold;margin-right:0.4em;"><span class="name">Precio: $'.number_format($fila['valor_sugerido'],0,'','.').'</span>
                                      <span  class="date">Año: '.$fila['anio'].'</span>
                                      </div>';
                          echo '</div>';
                          //echo '<br>';
                          ?>
                      </a>   
              
                  <?php
                  $bandera=1;
                  }   
          
              }
              echo ' </div>';
            }
            
            //echo  $fila["id_cotizados"];
            //echo ' </div>';
        
        
        }
        echo ' </div>';  
    //echo "total de paginas: ".$total_pages;
    if ($total_pages > 1) 
    {
      if ($page != 1) 
      {
          echo '<li class="page-item"><a style="width:2em;" class="page-link" href="busca_usados.php?page='.($page-1).'"><span aria-hidden="true">&laquo;</span></a></li>';
      }

      for ($i=1;$i<=$total_pages;$i++) 
      {
          if ($page == $i) 
          {
              echo '<li class="page-item active"><a  style="width:2em;"  class="page-link" href="#">'.$page.'</a></li>';
          }
          else 
          {
              echo '<li class="page-item"><a style="width:2em;" class="page-link" href="busca_usados.php?page='.$i.'">'.$i.'</a></li>';
          }
      }
      if ($page != $total_pages) 
      {
          echo '<li class="page-item"><a style="width:2em;" class="page-link" href="busca_usados.php?page='.($page+1).'"><span aria-hidden="true">&raquo;</span></a></li>';
      }
    }
  }
  echo ' </div>';
  ?>
   
    <br><br><div class="bg-primary text-white" align="center">
     
        <?php //echo '<br><a href="javascript: history.go(-1)">
              //          <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Volver
              //          </button><br>
              //      </a><br>';
          echo '    <br><a href="propios.php">
                        <button type="button" style="font-size:1.5em;" class="btn btn-light" data_but="btn-xs">Volver
          </button><BR>
      </a><br>';
        ?>
     
    </div>
    <br>
