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
    $usuario = $_SESSION["admin"];
    $conn = mysqli_connect($servername, $username, $password, $database);
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
    $row = mysqli_fetch_array($resultado);
    $nombre_usuario = $row["nombre"].' '.$row['apellido'];
   
    
      $id_cliente = $_POST['id'];
      $cod = $_POST['cod'];
      $precio = $_POST['precio'];
      $auto = $_POST['auto'];
      $cliente = $_POST['cliente'];
      $moneda = $_POST['moneda'];
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
      //PASE FUNCIONAMIENTO

      $funcion = $_POST["funcion"];
      $falla = $_POST["falla"];
      $caja = $_POST["caja"];
      $sus_tren = $_POST["sus_tren"];
      $adver =  $_POST["adver"];
      $indi = $_POST["indi"];
      $frenos = $_POST["frenos"];
      $airbag = $_POST["airbag"];
      $abs = $_POST["abs"];

      
      
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
<script>
function myFunction2(param) {
        var x = document.getElementById("paneles");
        var y = document.getElementsByName("panel");
        //alert(y.value);
        //document.getElementById("mySubmit").disabled = true;
        if (param == 0){
            x.style.display = "block";
        }
        else{
            x.style.display = "none";
        }
    }  

    function myFunction3(param) {
        //alert(param);
        var x = document.getElementById("paneles2");
        var y = document.getElementsByName("profu");
        //alert(x.value);
        //document.getElementById("mySubmit").disabled = true;
        if (param == 0){
            x.style.display = "block";
        }
        else{
            x.style.display = "none";
        }
    }  
    
</script>
<style>
.radio {
	width: 1.5em;
    height: 1.5em;
    margin-left:1em;
	}
.checkbox {
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
            <form action="cotiz_int.php" method="POST"> 
               
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
                    <input hidden type="text" name="moneda" value="<?php echo $moneda; ?>"/>
                    <input hidden type="text" name="auto" value="<?php echo $auto; ?>"/>
                    <input hidden type="text" name="id" value="<?php echo $id_cliente; ?>"/>
                    <input hidden type="text" name="ano" value="<?php echo $ano; ?>"/>
                    <input hidden type="text" name="cliente" value="<?php echo $cliente; ?>"/>
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

                    <div style="margin:1em">
                        <a style="margin:0.5em">
                            <img id="img1" src="imagenes/motor.svg" width="50" height="50" />
                        </a>
                        <a style="margin:0.5em">
                           <img id="img2" src="imagenes/auto2.svg" width="50" height="50" />
                        </a>
                        <a style="margin:0.5em">
                           <img id="img3" src="imagenes/asientos2.png" width="50" height="50" />
                        </a>
                        <a style="margin:0.5em">
                           <img id="img4" src="imagenes/rueda.svg" width="50" height="50" />
                        </a>
                    </div>    
                    <div class="col-lg-8 mx-auto">
                        
                    </div>    
                    <div>
                        <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Aspecto Exterior</strong></h4>
                        
                        <h6>Tuvo algun choque fuerte?</h6>
                        <input type="radio"  class="radio"name="choque" value="si" required>Si
                        <input type="radio"  class="radio"name="choque" value="no" required>No

                        <h6>El parabrisas esta rajado o tiene piquetes?</h6>
                        <input id="cotitu" class="radio" type="radio" name="parabri" value="si" required>Si
                        <input id="cotitu" class="radio" type="radio" name="parabri" value="no" required>No
                        
                        <h6>Las ópticas delanteras están sanas?</h6>
                        <input id="uso" class="radio" type="radio" name="opticas" value="si" required>Si
                        <input id="uso" class="radio" type="radio" name="opticas" value="no" required>No
                        
                        <h6>Los faros traseros están sanos?</h6>
                        <input type="radio" class="radio" name="faros" value="si" required>Si
                        <input type="radio" class="radio" name="faros" value="no" required>No
                        
                        <h6>Tiene algún daño por granizo?</h6>
                        <input type="radio" class="radio" name="grani" value="si" required>Si
                        <input type="radio" class="radio" name="grani" value="no" required>No

                        <h6>Estado general de la pintura</h6>
                        <select class="col-lg-8" name="pintura" required>
                            <option value="">Seleccionar</option>    
                            <option value="1">Muy bueno</option>
                            <option value="2">Levemente rayado</option>
                            <option value="3">Muy rayado</option>
                        </select><BR><BR>
                        
                        <h6>La pintura tiene paneles rayados?</h6>
                        <input type="radio" class="radio" name="panel" value="si" required onclick="return myFunction2(0)">Si
                        <input type="radio" class="radio" name="panel" value="no" required onclick="return myFunction2(1)">No
                        <div id="paneles">
                            <br>
                            
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox1"  value="cap">Capot</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox2"  value="bau">Baul</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox3"  value="tec">Techo</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox4"  value="pdi">Puerta delantera izquierda</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox5"  value="pdd">Puerta delantera derecha</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox6"  value="pti">Puerta trasera izquierda</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox7"  value="ptd">Puerta trasera derecha</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox8"  value="gdi">Guardabarro delantero izquierdo</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox9"  value="gdd">Guardabarro delantero derecho</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox10" value="gti">Guardabarro trasero izquierdo</label><br>
                            <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox11" value="gtd">Guardabarro trasero derecho</label><br>
                           
                        </div>

                        <h6>La chapa tiene rayas profundas?</h6>
                        <input type="radio" class="radio" name="profundo" value="si" required onclick="return myFunction3(0)"> Si
                        <input type="radio" class="radio" name="profundo" value="no" required onclick="return myFunction3(1)">No
                        <div id="paneles2">
                            <br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox21"  value="cap">Capot</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox22"  value="bau">Baul</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox23"  value="tec">Techo</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox24"  value="pdi">Puerta delantera izquierda</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox25"  value="pdd">Puerta delantera derecha</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox26"  value="pti">Puerta trasera izquierda</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox27"  value="ptd">Puerta trasera derecha</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox28"  value="gdi">Guardabarro delantero izquierdo</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox29"  value="gdd">Guardabarro delantero derecho</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox210" value="gti">Guardabarro trasero izquierdo</label><br>
                            <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox211" value="gtd">Guardabarro trasero derecho</label><br>
                        </div>
                        <h6>Estado general del paragolpe delantero</h6>
                        <select class="col-lg-8" name="paradel" required>
                            <option value="">Seleccionar</option>    
                            <option value="1">Perfecto</option>
                            <option value="2">Levemente rayado</option>
                            <option value="3">Chocado o roto</option>
                        </select><BR><BR>
                        <h6>Estado general del paragolpe trasero</h6>
                        <select class="col-lg-8" name="paratra" required>
                            <option value="">Seleccionar</option>    
                            <option value="1">Perfecto</option>
                            <option value="2">Levemente rayado</option>
                            <option value="3">Chocado o roto</option>
                        </select><BR><BR>
                    </div>
                   
                  
                    <!--<input onClick="" type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="Atras" />-->
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
               
          
                ?>
            </div>
        </div>
    </div>
    
	</section>