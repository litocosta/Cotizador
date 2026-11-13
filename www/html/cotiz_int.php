<?php
require_once __DIR__ . '/config.php';
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
//session_cache_limiter('public'); // works too
session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
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
   
      $usuario = $_SESSION["admin"];
      $id_cliente = $_POST['id'];
      $precio = $_POST['precio'];
    $auto = $_POST['auto'];
      $cliente = $_POST['cliente'];
      $moneda = $_POST['moneda'];
      $cod = $_POST['cod'];
      if($moneda<>"$")
      {
          $sql_moneda = "SELECT * FROM parametros ";
          $resultado = mysqli_query($conn, $sql_moneda) or die ('Error en el query database');
          $row = mysqli_fetch_array($resultado);
          $valor_dolar = $row["dolar"];
          //$precio = $precio*$valor_dolar;
          //echo "precio en pesos ".$precio;
      }else{
        $valor_dolar = 1;
      }
    //POST FUNCIONAMIENTO
    $funcion = $_POST["funcion"];
    $falla = $_POST["falla"];
    $caja = $_POST["caja"];
    $sus_tren = $_POST["sus_tren"];
    $adver =  $_POST["adver"];
    $indi = $_POST["indi"];
    $frenos = $_POST["frenos"];
    $airbag = $_POST["airbag"];
    $abs = $_POST["abs"];
    //POST EXTERIOR
    $parabri = $_POST["parabri"];
    $opticas = $_POST["opticas"];
    $faros = $_POST["faros"];
    $grani = $_POST["grani"];
    $pintura = $_POST["pintura"];
    $choque = $_POST["choque"];
    $panel = $_POST["panel"];
    //echo "Profundidad ".$_POST["profu"][0];
    $profundo = $_POST["profundo"];
    $paradel = $_POST["paradel"];
    $paratra = $_POST["paratra"];
    if($panel=="si"){
        $paneles = implode(",",$_POST["paneles"]);
    }
    if($profundo=="si"){
        $profu = implode(",",$_POST["profu"]);
    }
    
   
     
   
    //echo '<BR>'.$paneles;
    //echo '<BR>'.$profu;

      
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Montironi</title>
	<link rel="icon" type="image/png" href="car3.png" />
	<link rel="icon" href="car.ico" type="image/x-icon">
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <script src="jquery.min.js"></script>
    <script src="validar.js"></script>
    <script src="validarE.js"></script>
</head>

<style>
.radio {
	width: 1.5em;
    height: 1.5em;
    margin-left:1em;
	}
#paneles{display:none;}

#paneles {
  /*display: inline-block;*/
  text-align:left;
  margin-left:20%;/*width: 80px;*/
}

#paneles2{display:none;}

#paneles2 {
  /*display: inline-block;*/
  text-align:left;
  margin-left:20%;/*width: 80px;*/
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
    <div class="container text-center">
		<div class="row">
			<div class="col-lg-8 mx-auto" style="margin-top:-4em">
            <form action="cotiz_cub.php" method="POST"> 
               
                <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
                    

                 
                    <h5>Cliente: <?php echo $cliente; ?></h5><BR>
                    <?php if($row['ver_valor']=='s')
                    { ?>
                        <h5>Automovil: <?php echo $auto.'<BR>Precio estimado: $ '.number_format((($precio-($precio*15/100))*1000)*$valor_dolar,0,'','.'); ?></h5><BR>
                    <?php
                    }
                    else 
                    { ?>
                        <h5>Automovil: <?php echo $auto; ?></h5><BR>
                    <?php
                    }
                    ?>
                    <input hidden type="text" name="precio" value="<?php echo $precio; ?>"/>
                    
                    <input hidden type="text" name="id" value="<?php echo $id_cliente; ?>"/>
                    <input hidden type="text" name="ano" value="<?php echo $ano; ?>"/>
                    <input hidden type="text" name="cliente" value="<?php echo $cliente; ?>"/>
                    <input hidden type="text" name="auto" value="<?php echo $auto; ?>"/>
                    <input hidden type="text" name="moneda" value="<?php echo $moneda; ?>"/>
                    <input hidden type="text" name="cod" value="<?php echo $cod; ?>"/>

                    <input hidden type="text" name="funcion" value="<?php echo $funcion; ?>"/>
                    <input hidden type="text" name="falla" value="<?php echo $falla; ?>"/>
                    <input hidden type="text" name="caja" value="<?php echo $caja; ?>"/>
                    <input hidden type="text" name="sus_tren" value="<?php echo $sus_tren; ?>"/>
                    <input hidden type="text" name="adver" value="<?php echo $adver; ?>"/>
                    <input hidden type="text" name="parabri" value="<?php echo $parabri; ?>"/>
                    <input hidden type="text" name="frenos" value="<?php echo $frenos; ?>"/>
                    <input hidden type="text" name="indi" value="<?php echo $indi; ?>"/>
                    <input hidden type="text" name="airbag" value="<?php echo $airbag ?>"/>
                    <input hidden type="text" name="abs" value="<?php echo $abs; ?>"/>

                    <input hidden type="text" name="choque" value="<?php echo $choque; ?>"/>
                    <input hidden type="text" name="parabri" value="<?php echo $parabri; ?>"/>
                    <input hidden type="text" name="opticas" value="<?php echo $opticas; ?>"/>
                    <input hidden type="text" name="faros" value="<?php echo $faros; ?>"/>
                    <input hidden type="text" name="grani" value="<?php echo $grani; ?>"/>
                    <input hidden type="text" name="pintura" value="<?php echo $pintura; ?>"/>
                    <input hidden type="text" name="panel" value="<?php echo $panel; ?>"/>
                    <input hidden type="text" name="profundo" value="<?php echo $profundo; ?>"/>
                    <input hidden type="text" name="paradel" value="<?php echo $paradel; ?>"/>
                    <input hidden type="text" name="paratra" value="<?php echo $paratra; ?>"/>

                    <input hidden type="text" name="paneles" value="<?php echo $paneles; ?>"/>
                    <input hidden type="text" name="profu" value="<?php echo $profu; ?>"/>

                    <div style="margin:1em">
                        <a style="margin:0.5em">
                            <img id="img1" src="imagenes/motor.svg" width="50" height="50" />
                        </a>
                        <a style="margin:0.5em">
                           <img id="img2" src="imagenes/auto.svg" width="50" height="50" />
                        </a>
                        <a style="margin:0.5em">
                           <img id="img3" src="imagenes/asientos.png" width="50" height="50" />
                        </a>
                        <a style="margin:0.5em">
                           <img id="img4" src="imagenes/rueda.svg" width="50" height="50" />
                        </a>
                    </div>    
                    <div class="col-lg-8 mx-auto">
                        
                    </div>    
                    <div>
                       <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Interior y climatización</strong></h4>
                        <h6>Estado general del tapizado</h6>
                            <select class="col-lg-8" name="tapi" required>
                                <option value="">Seleccionar</option>    
                                <option value="1">Sano y limpio</option>
                                <option value="2">Algo manchado</option>
                                <option value="3">Tiene partes rotas</option>
                                <option value="4">Muy roto o muy manchado</option>
                            </select><BR><BR>
                    
                        <h6>Polarizado?</h6>
                            <select class="col-lg-8" name="pola" required>
                                <option value="">Seleccionar</option>    
                                <option value="1">No tiene</option>
                                <option value="2">En buenas condiciones</option>
                                <option value="3">Algo descolorido</option>
                                <option value="4">En malas condiciones</option>
                            </select><BR><BR>
                        
                        <h6>El AA enfría?</h6>
                            <input id="aa" class="radio" type="radio" name="aa" value="si" required>Si
                            <input id="aa" class="radio" type="radio" name="aa" value="no" required>No
                        <h6>La calefaccion funciona?</h6>
                            <input id="cale" class="radio" type="radio" name="cale" value="si" required>Si
                            <input id="cale" class="radio" type="radio" name="cale" value="no" required>No
                        <h6>Los vidrios electricos funcionan?</h6>
                            <input id="vid" class="radio" type="radio" name="vid" value="si" required>Si
                            <input id="vid" class="radio" type="radio" name="vid" value="no" required>No
                        <h6>Cierre centralizado</h6>
                        <select class="col-lg-8" name="cierre" required>
                                <option value="">Seleccionar</option>    
                                <option value="1">No tiene</option>
                                <option value="2">Funciona</option>
                        </select><BR><BR>
                    </div>
                   
                   
                    
                     <a href="javascript: history.go(-1)">
                        <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Atrás
                        </button>
                    </a>
                     <input type="submit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="avanzar" />
                    
                    </a><br><br>
                    <a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
                </form>
                <script type="text/javascript">
                function cheking(){
                    alert(document.getElementsByName('cotitu').value);
                }

                function titular(){
                    alert("No se puede cotinzar si no es titular");
                }
                function volver(){
                    if (window.history.replaceState) { // verificamos disponibilidad
                        window.history.replaceState(null, null, window.location.href);
                    }
                }
               
                </script>
                <?php
                //echo 'Json '.$paneles_int;     
          
                ?>
            </div>
        </div>
    </div>
    
	</section>