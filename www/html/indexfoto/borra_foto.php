<?php
require_once __DIR__ . '/../config.php';
if (isset($_GET['foto']))
{
  $foto = $_GET['foto'];
  echo $foto;
}
$servidor_ftp = cotizador_config('FTP_HOST');
$conexion_id = ftp_connect($servidor_ftp);
$ftp_usuario = cotizador_config('FTP_USER_2');
$ftp_clave = cotizador_config('FTP_PASSWORD');
//$dir = $coti;
$resultado_login = ftp_login($conexion_id, $ftp_usuario, $ftp_clave);
//echo "El directorio principal es: " . ftp_pwd($conexion_id) . "\n";
ftp_chdir($conexion_id, "117"); 
//echo "El directorio principal es: " . ftp_pwd($conexion_id) . "\n";

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
     
    </div> 
  </nav>
 
  <section class="bg-primary text-white">
    <div class="container text-center">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <!--<h4><strong>Precios actualizados</strong></h4>-->
         <h4><strong>Eliminar Foto?</strong></h4>
         
         <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" enctype="multipart/form-data">
             <input hidden class="search_query form-control" type="text" name="key" id="key" value="<?php echo $foto; ?>">
             <button name="submit" type="submit" class="btn btn-light" style="margin-left:1em">Eliminar</button>

            <a href="index.php">
                <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Cancelar</button>
            </a> 
         </form>
     
        
        <?php
        
        if (isset($_POST['submit'])){

           unlink($_POST['key']);
           echo $_POST['key']."<br><br>Foto eliminada";
           $file = $_POST['key'];
           if (ftp_delete($conexion_id, $file)) 
           {
            echo "$file se ha eliminado satisfactoriamente\n";
           } 
           else 
           {
            echo "No se pudo eliminar $file\n";
           }
           echo '<a href="index.php">
                <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver</button>
            </a>';

       ?>


      
      </div>
       
   
  </section>
  <?php
    }
  ?>