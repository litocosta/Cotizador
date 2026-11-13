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
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="icon"  type="image/png" href="car3.png"/>
    <link rel="icon" href="car.ico" type="image/x-icon">
    
  

<style>
* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}
</style>
</head>
<body>
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
        ?>
<div class="slideshow-container">
<?php
if (isset($_POST['submit']))
        {
         //echo "<h5>entro</h5>";
            $id = $_POST['coti'];
            $sql_coti = "SELECT * FROM cotizados WHERE id='$id'";
           //$sql = "SELECT * FROM acara";
            $resultado_coti = mysqli_query($conn, $sql_coti) or die ('Error en el query database');
            $fila_coti = mysqli_fetch_array( $resultado_coti );
            echo '<H3>';
                echo $fila_coti['nombre'].' '.$fila_coti['apellido'].'<br>';
                echo $fila_coti['marca'].' '.$fila_coti['modelo'].' '.$fila_coti['version'].' '.$fila_coti['ano'].'<br>';
            echo '</H3>';
            $dir = "fotos/".$id."/";
            //echo $dir;
            $photo = glob($dir . "*.jpg");
            foreach ($photo as $photos) 
            {

            ?>
                <div class="mySlides fade">
                <div class="numbertext">1 / 3</div>
                <img src="<?php print_r($photos) ?>" style="width:100%">
                <div class="text">Caption Text</div>
                </div>
            <?php }}?>
<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>

<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>

</body>

</html> 
