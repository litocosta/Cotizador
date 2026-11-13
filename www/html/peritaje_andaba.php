<?php
require_once __DIR__ . '/config.php';
include('movil/Mobile_Detect.php');
$detect = new Mobile_Detect();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
 session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
   
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
       // echo "paso nombre";
      $ano = $_GET['ano'];
      $marca = $_GET['marca'];
      $modelo = $_GET['modelo'];
      $version = $_GET['version'];
      $precio = $_GET['precio'];
      $moneda = $_GET['moneda'];
      if($moneda<>"$")
      {
          $sql_moneda = "SELECT * FROM parametros";
         // echo "entrop por dolar";
          $resultado = mysqli_query($conn, $sql_moneda) or die ('Error en el query database');
          $row = mysqli_fetch_array($resultado);
          $valor_dolar = $row["dolar"];
          //$precio = $precio*$valor_dolar;
          //echo "precio en pesos ".$precio;
      }else{
        $valor_dolar = 1;
      }


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
/*#oculto{display:none}*/
#oculto2{display:none}
#oculto label{
  display: inline-block;
  width: 80px;
}

*::-webkit-input-placeholder {
    /* Google Chrome y Safari */
    /*color: red;*/
    font-size: 0.7em;    
}
*:-moz-placeholder {
    /* Firefox anterior a 19 */
    color: red;
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
    <script>
        
        function verProv()
        {
            var provincia = document.getElementById('proveedor').value;
            if(provincia==1){
                alert('entro por 1');
                $("#productos").removeClass("required");
            }
            else
            {
                alert('entro por oytro');
                $("#productos").addClass("required");
            }
           
        }
        function CargarProductos(val)
        {
            
            document.getElementById("loca1").value = document.getElementById("proveedor").value;
            
            /*$('#respuesta').html("Por favor espera un momento");    
            $.ajax({
                type: "POST",
                url: 'consulta.php',
                data: 'idproveedor='+val,
               
                success: function(resp){
                    //alert(resp);
                    $('#productos').html(resp);
                    $('#respuesta').html("");
                }
            });*/
        }
       
        function CargarProductos2(val,provi)
        {
           
           document.getElementById("productos").style.visibility = "visible"; 
           document.getElementById("productos").size = "5";
           //document.getElementById("productos").style.height = "200px";
            document.getElementById("loca1").value = document.getElementById("proveedor").value;
            //var provi = document.getElementById("loca1").value;
             console.log(val, provi);
            // alert(val,provi);
            //$('loca1').val(val);
            $('#respuesta').html("Por favor espera un momento");    
            $.ajax({
                type: "POST",
                url: 'consulta.php',
                data: 'idproveedor='+val+'&provi='+provi,
               
                success: function(resp){
                    //alert(resp);
                    $('#productos').html(resp);
                    $('#respuesta').html("");
                }
            });
        }
        function verificaCel() {
            var cuenta = document.getElementById('area').value.length+document.getElementById('cel').value.length;

            if (cuenta > 10){
                alert("La longitud del código de area mas el número no debe superar los 10 digitos");
            }
        }
        
    </script>
     <?php
       

        
     ?>
	<section class="bg-primary text-white">
    <div class="container text-center">
		<div class="row">
			<div class="col-lg-8 mx-auto" style="margin-top:-4em">
                <form action="cotiz_fun.php" method="POST" id="validationForm" name="validationForm">
                <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
                    <h5>Vehículo: <?php echo $marca.' '.$modelo.' '.$version.', modelo '.$ano; ?></h5>
                    <?php //echo "Dolar ".$valor_dolar;?>
                    <?php //echo "precio en pesos ".$precio;?>
                    <?php if ($row['ver_valor']=='s')
                    { ?>
                        <h5>Valor de toma estimativo: $<?php echo number_format(($precio*1000*$valor_dolar)-((($precio*15/100)*1000)*$valor_dolar),0,'','.');?></h5>
                    <?php } ?>
                    <div id="oculto">
                        
                        <input type="text" hidden name="marca" value="<?php echo $marca;?>">
                        <input type="text" hidden name="ano"  value="<?php echo $ano;?>">
                        <input type="text" hidden name="precio"  value="<?php echo $precio?>">
                        <input type="text" hidden name="modelo"  value="<?php echo $modelo;?>">
                        <input type="text" hidden name="version"  value="<?php echo $version;?>">
                        <input type="text" hidden name="moneda"  value="<?php echo $moneda;?>">
                        <label forHTML="letras">Apellido/s</label>
                        <input type="text" id="letras" name="ape" required pattern="([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)+([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)"><BR>
                        <div id="message" style="position: absolute; left: 10px; top: 50px; background-color: red; z-index: 10" hidden>
                            Introduzca solo letras. Máximo 35 caracteres.
                        </div>
                        <label>Nombre/s</label>
                        <input type="text" id="nombre" name="nom" required pattern="([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)+([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)"><br>

                        <!--<input type="text" id="nombre" name="nom" required onkeyup="validar(this.id)" onblur="validar(this.id)"><BR>-->
                        <label>D.N.I.</label>
                        <input type="text" name="dni" id="dni" required onkeyup="validar2(this.id)" onblur="validar2(this.id)"><BR>
                        <div id="message2" style="position: absolute; left: 10px; top: 50px; background-color: red; z-index: 10" hidden>
                            Introduzca solo números sin puntos. Máximo 8 caracteres.
                        </div>
                                                
                        <label>Celular</label>
                        +<input type="text" name="pais" maxlength="3" size="2" required value="54" pattern="[0-9]{2}">
                        <input type="text" id="area" name="area" size="3" placeholder="cod area sin 0" pattern="[0-9]{2,4}" required>
                        <input type="text" id="cel" name="cel" size="6" placeholder="numero sin 15" pattern="[0-9]{6,8}" required onkeyup="verificaCel()"><BR>
                        <!--<input type="tel" name="cel" pattern="\([0-9]{3}\) [0-9]{4}[ -][0-9]{6}" 

                        title="código pais 3 digitos entre parentesis, un espacio, 4 para area provincia y 6 para el numero de linea" placeholder="(pais) dddd-ddddd" required><br>-->
                        
                        <label>Tel. fijo </label>
                        +<input type="text" name="pais2" value="54" size="2"><input type="text" name="tel" size="10"><BR>
                        <label>E-mail</label>
                        <!--<input type="text" name="mail" id="mail" required onblur="validarE(this.id)"><BR>-->
                        <input type="text" name="mail" id="mail" required><BR>
                        <div id="message5" style="position: absolute; left: 10px; top: 50px; background-color: red; z-index: 10" hidden>
                            Email inválido
                        </div>
                        <label>Provincia</label>
                        <?php
                        $sql = "SELECT * FROM provincias ORDER BY nombre";
                        $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');    
                        
                                    echo '<select required class="col-lg-3" name="pro" id="proveedor" onchange="CargarProductos(this.value);">';
                                    //echo '<select required class="col-lg-3" name="pro" id="proveedor">';
                                    echo '<option value="">Seleccionar</option>';
                                   while($res=mysqli_fetch_array($resultado)) {
                                        //echo '<pre>';
                                        //print_r($product);
                                       // print_r($nombre['nombre']);
                                        echo '<option value="'.$res['codigo'].'">'.$res['nombre'].'</option>';

                                        //echo '</pre>';
                                    }
                                    echo '</select><br>';
                                                                       
                                
    

                        ?>
                        <label>Localidad</label>
                        <input hidden type="text" name="loca1" id="loca1">
                        <?php
                        if($detect->isAndroidOS() || $detect->isIpad())
                        {
                        ?>
                           
                            <input type="text"  name="loca2" id="loca2" onchange="CargarProductos2(document.getElementById('loca1').value,this.value)"><br>
                            <!--<input type="text"  name="loca2" id="loca2"><br>-->
                        <?php
                        }
                        else
                        {
                        ?>
                        
                            <input type="text" name="loca2" id="loca2" onkeyup="CargarProductos2(document.getElementById('loca1').value,this.value)"><br>
                        <?php
                        }
                        ?>
                        <!--<input type="text" name="loca2" id="loca2"><br>-->
                        <select style="height:100px;"  id="productos" name="loca" required></select>
                        
                        <div id="respuesta"></div>
                    
                        <label>Patente</label>
                        <!--<input type="text" name="pat" id="patente" required onblur="validarPatente(this.value)"><BR>-->
                        <input type="text" name="pat" id="patente" required pattern="([A-Za-z]{3}[0-9]{3})*([A-Za-z]{2}[0-9]{3}[A-Za-z]{2})*"><br>
                        <div id="message3" style="position: absolute; left: 10px; top: 50px; background-color: red; z-index: 10" hidden>
                            Patente erronea
                        </div>
                        <label>Kilometros</label>
                        <input type="text" name="kil" id="kilometros" required onkeyup="validar3(this.id)" onblur="validar3(this.id)"><BR>
                        <div id="message4" style="position: absolute; left: 10px; top: 50px; background-color: red; z-index: 10" hidden>
                            Introduzca solo números sin puntos. Máximo 6 caracteres.
                        </div>
                        <label>Color</label>
                        <select required class="col-lg-3" name="color" id="color">
                        <option value="">Seleccionar</option>
                        <option value="blanco">Blanco</option>
                        <option value="negro">Negro</option>
                        <option value="rojo">Rojo</option>
                        <option value="bordeau">Bordeau</option>
                        <option value="azul obscuro">Azul obscuro</option>
                        <option value="azul claro">Azul claro</option>
                        <option value="marron">Marrón</option>
                        <option value="amarillo">Amarillo</option>
                        <option value="plateado">Plateado</option>
                        <option value="gris">Gris</option>
                        <option value="verde">Verde</option>
                        <option value="beige">Beige</option>
                        <option value="naranja">Naranja</option>
                        </select><BR><br>
                        Nº de asientos
                        <!--<input type="text" name="asientos" size="1" required pattern="[0-9]+"><BR><br>-->
                        <select class="col-lg-4" name="asientos" required>
                            <option value="">Seleccionar</option>    
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="100">+8</option>
                            
                        </select><BR><BR>
                        
                        Tipo de combustible
                        <select class="col-lg-4" name="combustible" required>
                            <option value="">Seleccionar</option>    
                            <option value="nafta">Nafta</option>
                            <option value="diesel">Diesel</option>
                            <option value="electrico">Eléctrico</option>
                        </select><BR><BR>
                        Transmisión
                        <select class="col-lg-4" name="trans" required>
                            <option value="">Seleccionar</option>    
                            <option value="manual">Manual</option>
                            <option value="automatica">Automática</option>
                        </select><br><br>
                        Cilindrada
                        <input type="text" name="cilin" size="2"  required pattern="[0-9.]+"><BR><br>
                        </select>

                        <h6>Tiene co-titular o figura casado?</h6>
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="si" required>Si
                        
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="no" required>No
                        
                        <h6>Se usa como taxi, remis, uber o similar?</h6>
                        <input id="uso" class="radio" type="radio" name="uso" value="si" required>Si
                        
                        <input id="uso" class="radio" type="radio" name="uso" value="no" required>No
                                               
                        <h6>El vehículo está prendado?</h6>
                        <input type="radio" class="radio" name="prenda" value="si" required>Si
                        
                        <input type="radio" class="radio" name="prenda" value="no" required>No
                       

                    </div>
                    <div id="oculto2">
                        <label class="btn btn-danger" data_but="btn-xs">No es posible cotizar si no es titular
                        </label>
                    </div>
                    <!--<input id="mySubmit" class="btn btn-light" disabled="disabled" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Continuar"/>-->
                    <a href="javascript: history.go(-1)">
                            <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Atras
                            </button>
                        </a>
                    <input id="mySubmit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Continuar"/>
                    <br><br>
                    <a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
                </form>
               
               
            </div>
        </div>
    </div>
    <script>
    /*$(document).on("change","#loca2",function(){
        document.getElementById("productos").style.visibility = "visible"; 
           document.getElementById("productos").size = "5";
           //document.getElementById("productos").style.height = "200px";
            document.getElementById("loca1").value = document.getElementById("proveedor").value;
            //var provi = document.getElementById("loca1").value;
            val =  document.getElementById("loca1").value;
            provi =  document.getElementById("loca2").value;
            console.log(val, provi);
            // alert(val,provi);
            //$('loca1').val(val);
            $('#respuesta').html("Por favor espera un momento");    
            $.ajax({
                type: "POST",
                url: 'consulta.php',
                data: 'idproveedor='+val+'&provi='+provi,
               
                success: function(resp){
                    //alert(resp);
                    $('#productos').html(resp);
                    $('#respuesta').html("");
                }
            });
        
  // aqui va el codigo que requieres hacer cuando se genere algun cambio....
    });*/
    </script>
	</section>