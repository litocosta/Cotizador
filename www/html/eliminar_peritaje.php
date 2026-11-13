 <?php
require_once __DIR__ . '/config.php';
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
<script language= javascript type= text/javascript>
function muestraDatos()
{
  v = document.getElementById("oculto");	
  w = document.getElementById("funcionamiento");	
  x = document.getElementById("exterior");	
  y = document.getElementById("interior");	
  z = document.getElementById("accesorios");	
  v.style.display = "block";
  w.style.display = "none";
  x.style.display = "none";
  y.style.display = "none";
  z.style.display = "none";
}
function funciona()
{
  v = document.getElementById("oculto");	
  w = document.getElementById("funcionamiento");	
  x = document.getElementById("exterior");	
  y = document.getElementById("interior");	
  z = document.getElementById("accesorios");	
  v.style.display = "none";
  w.style.display = "block";
  x.style.display = "none";
  y.style.display = "none";
  z.style.display = "none";
}
function exterior()
{
  v = document.getElementById("oculto");	
  w = document.getElementById("funcionamiento");	
  x = document.getElementById("exterior");	
  y = document.getElementById("interior");	
  z = document.getElementById("accesorios");	
  v.style.display = "none";
  w.style.display = "none";
  x.style.display = "block";
  y.style.display = "none";
  z.style.display = "none";
}
function interior()
{
  v = document.getElementById("oculto");	
  w = document.getElementById("funcionamiento");	
  x = document.getElementById("exterior");	
  y = document.getElementById("interior");	
  z = document.getElementById("accesorios");	
  v.style.display = "none";
  w.style.display = "none";
  x.style.display = "none";
  y.style.display = "block";
  z.style.display = "none";
}
function accesorios()
{
  v = document.getElementById("oculto");	
  w = document.getElementById("funcionamiento");	
  x = document.getElementById("exterior");	
  y = document.getElementById("interior");	
  z = document.getElementById("accesorios");	
  v.style.display = "none";
  w.style.display = "none";
  x.style.display = "none";
  y.style.display = "none";
  z.style.display = "block";
}


</script>
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
 
  <section class="bg-primary text-white">
    <div class="container text-center">
      <div class="row">
        <div class="col-lg-8 mx-auto">
           <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Modificar peritaje</strong></h4><br><br>
          <div id="ocultar">
            <form action="" method="post" enctype="multipart/form-data">
           
                <label>Ingrese la patente del vehículo</label>

                <input type="text" name="pat" id="patente"><br><br>
                <input id="mySubmit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Buscar"/>
            </form>
             <br>
             <a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
          </div>
        <?php
        if (isset($_POST["pat"]))
        {
            
            $pat = $_POST["pat"];
            $sql = "SELECT * FROM cotizados WHERE patente='$pat'";
            $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
            if (mysqli_num_rows($resultado) > 0 )
            {
                ?>
                <script type="text/javascript"> document.getElementById('ocultar').hidden = true;</script>
                <?php
                $fila = mysqli_fetch_array( $resultado );
                $auto = $fila['marca'].' '.$fila['modelo'].' '.$fila['version'];
                $id = $fila['id'];
                $chapa = $fila['patente'];
                $ano = $fila['ano'];
            ?>
            <form action="borra_peritaje.php" method="POST" id="validationForm" name="validationForm">
              
                    <h5>Vehículo: <?php echo $auto.', modelo '.$ano; ?></h5>
                    
                    <?php //echo "Dolar ".$valor_dolar;?>
                    <?php //echo "precio en pesos ".$precio;?>
                    <?php if ($row['ver_valor']=='s')
                    { ?>
                        <h5>Valor de toma estimativo: $<?php echo number_format($fila['precio_info'],0,'','.');?></h5>
                    <?php } 
                    ?>
                    <!--<button onclick="muestraDatos();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Datos generales</button>              
                    <button onclick="funciona();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Funcionamiento</button>              
                    <button onclick="exterior();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Aspecto exterior</button>              
                    <button onclick="interior();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Aspecto interior</button>              
                    <button onclick="accesorios();" style="background:darkgrey; border: 1px;border-radius:5px; color:white;" type="button">Cubiertas y accesorios</button> -->             
                    <div id="oculto">
                        <br><h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Datos Generales</strong></h4>
                        
                        <input type="text" hidden name="id_borra"  value="<?php echo $id;?>">
                        <label forHTML="letras">Apellido/s</label>
                        <input type="text" id="letras" name="ape" readonly value="<?php echo $fila['apellido'];?>"><BR>
                        <div id="message" style="position: absolute; left: 10px; top: 50px; background-color: red; z-index: 10" hidden>
                            Introduzca solo letras. Máximo 35 caracteres.
                        </div>
                        <label>Nombre/s</label>
                        <input type="text" id="nombre" name="nom"readonly value="<?php echo $fila['nombre'];?>""><br>

                        <!--<input type="text" id="nombre" name="nom" required onkeyup="validar(this.id)" onblur="validar(this.id)"><BR>-->
                        <label>D.N.I.</label>
                        <input type="text" name="dni" id="dni" readonly value="<?php echo $fila['dni'];?>"><BR>
                                                                        
                        <label>Celular</label>
                        +<input type="text" name="celu" maxlength="10" size="12" readonly value="<?php echo $fila['celular'];?>"><br>
                       
                        <label>Tel. fijo </label>
                        +<input type="text" name="pais2" value="54" size="2"><input type="text" name="tel" size="10"><BR>
                        <label>E-mail</label>
                        <!--<input type="text" name="mail" id="mail" required onblur="validarE(this.id)"><BR>-->
                        <input type="text" name="mail" id="mail" readonly value="<?php echo $fila['email'];?>"><BR>
                        
                        <label>Provincia</label>
                        
                        <input  class="col-lg-3" type="text"  readonly  value="<?php echo $fila['provincia'];?>"><br>
                        
                        <label>Localidad</label>
                        
                        <input hidden type="text" name="loca1" id="loca1">
                        <input  class="col-lg-3" type="text" readonly  value="<?php echo $fila['ciudad'];?>">

                        <div id="suggestions">

                        </div>
                        <label>Patente</label>
                        <!--<input type="text" name="pat" id="patente" required onblur="validarPatente(this.value)"><BR>-->
                        <input type="text" name="pat" id="patente" readonly value="<?php echo $fila['patente'];?>"><br>
                        
                        <label>Kilometros</label>
                        <input type="text" name="kil" id="kilometros" readonly value="<?php echo $fila['kilometros'];?>"><BR>
                        
                        <label>Color</label>
                        <input type="text" readonly value="<?php echo $fila['color'];?>"><BR>
                        
                        <label>Nº de asientos</label>
                        <input type="text" name="kil" id="kilometros" readonly value="<?php echo $fila['asientos'];?>"><BR>
                        
                        <label>Tipo de combustible</label>
                        <input type="text" name="kil" id="kilometros" readonly value="<?php echo $fila['kilometros'];?>"><BR>
                        
                        <label>Transmisión</label>
                        <input type="text" name="kil" id="kilometros" readonly value="<?php echo $fila['transmision'];?>"><BR>
                                                
                        <label>Cilindrada</label>
                        
                        <input type="text" name="cilin" size="2" readonly value="<?php echo $fila['cilindrada'];?>"><BR><br>
                    

                        <h6>Tiene co-titular o figura casado?</h6>
                        <?php
                        if ($fila["cotitular"] == "si")
                        {
                        ?>
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="si" readonly checked>Si
                        
                        <?php
                        }
                        else 
                        {
                        ?>
                        
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="no" readonly checked>No
                        <?php
                        }
                        ?>
                        <h6>Se usa como taxi, remis, uber o similar?</h6>
                         <?php
                        if ($fila["tax_rem_uber"] == "si")
                        {
                        ?>
                        <input id="uso" class="text" type="radio" name="uso" value="si" readonly checked>Si
                        
                        <?php
                        }
                        else 
                        {
                        ?>    
                        
                        <input id="uso" class="radio" type="radio" name="uso" value="no" readonly checked>No                  
                        <?php
                        }
                        ?>
                        <h6>El vehículo está prendado?</h6>
                        <?php
                        if ($fila["prendado"] == "si")
                        {
                        ?>
                        <input type="radio" class="radio" name="prenda" value="si" readonly checked>Si
                        
                         <?php
                        }
                        else 
                        {
                        ?>    
                        
                        <input type="radio" class="radio" name="prenda" value="no" readonly checked>No
                         <?php
                        }
                        ?>
                    </div>
                    <div id="oculto2">
                        <label class="btn btn-danger" data_but="btn-xs">No es posible cotizar si no es titular
                        </label>
                    </div>
                    
                    
                    <!--<input id="mySubmit" class="btn btn-light" disabled="disabled" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Continuar"/>-->
                    <a href="javascript: history.go(-1)">
                            <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Atrás
                            </button>
                        </a>
                    <input id="mySubmit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Eliminar cotización"/>
                    <br><br>
                    <a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
                </form>
            <?php
            }
            else {
                echo '<br><label class="btn btn-danger" data_but="btn-xs">No se encontró la patente
                        </label>';
       
            }
        }
        ?>   
               
            </div>
        </div>
    </div>
       
      </div>
      
      </body>
     
      <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script>
         $(document).ready(function() {
            $('#key').on('keyup', function() {
                var key = $(this).val();	
                var provi = document.getElementById("loca1").value;	
                var dataString = 'key='+key+'&provi='+provi;
                    $.ajax({
                      type: "POST",
                      url: "ajax2.php",
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
         
         function CargarProductos(val)
        {
            
            document.getElementById("loca1").value = document.getElementById("proveedor").value;
           
        }
        
        </script>
         <script> 
                          //v = document.getElementById("oculto");	
                          //w = document.getElementById("funcionamiento");	
                          if (document.getElementById('panel').checked)
                          {
                            console.log("tiene datos");
                          }
                          else
                          {
                            y = document.getElementById("paneles");	
                            y.style.display = "none";
                          }


                          if (document.getElementById('profu').checked)
                          {
                            console.log("tiene datos");
                          }
                          else
                          {
                            x = document.getElementById("paneles2");	
                            x.style.display = "none";
                          }

                          
                          </script>
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
  </section>
  <?php
//    }
  ?>
