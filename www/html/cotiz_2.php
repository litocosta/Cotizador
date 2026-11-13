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
      $fecha_actual = date("d-m-Y");
        //sumo 1 día
      $fecha_ven = date("Y-m-d h:i:s",strtotime($fecha_actual."+ 30 days")); 
      echo "fecha vencimiento: ".$fecha_ven;
      $ano = $_POST['ano'];
      $marca = $_POST['marca'];
      $precio_crudo = $_POST['precio'];
      $codia = $_POST['codia'];
      echo $codia;
      $precio_info_dto = $precio_crudo-(($precio_crudo*15)/100);
      //echo 'Precio: '.$precio;
      $nom = $_POST['nom'];
      $ape = $_POST['ape'];
      $mail = $_POST['mail'];
      $loc = $_POST['loca'];
      $pro = $_POST['pro'];
      $pat = $_POST['pat'];
      $kil = $_POST['kil'];
      $cotitu = $_POST['cotitu'];
      $uso = $_POST['uso'];
      //$choque = $_POST['choque'];
      $prenda = $_POST['prenda'];
      //$entrega = $_POST['entrega'];
      $entrega = 1;
      $tel = $_POST['tel'];
      $dni = $_POST['dni'];
      $servername = cotizador_config('DB_HOST');
      $database = cotizador_config('DB_NAME');
      $username = cotizador_config('DB_USER');
      $password = cotizador_config('DB_PASSWORD');
      $i = 0;
        $precio_d ='';
        $largo_precio = strlen($precio_info_dto);
        $cortar_precio = $precio_info_dto;
        while($largo_precio > $i)
        {
            $precio_d = '.'.substr($cortar_precio, -3).$precio_d;
            $cortar_precio = substr($cortar_precio,0,-3);
            $i = $i + 3;
        }
        $precio_d = substr($precio_d,1);
      
            // Create connection
      $conn = mysqli_connect($servername, $username, $password, $database);
      // Check connection
      if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
      }
      
      //echo "Connected successfully";
      
      //$sql = 'INSERT INTO cotizados (nombre) 
      //        VALUES ("$nom")';
      $sql = "INSERT INTO cotizados (nombre, apellido, email, ciudad, provincia, patente, kilometros, cotitular, tax_rem_uber, prendado, entrega, telefono,
             dni, auto, ano, precio_info, fecha_vencimiento, precio_info_dto, codia) 
              VALUES ('$nom', '$ape', '$mail', '$loc', '$pro', '$pat', '$kil', '$cotitu', '$uso',  '$prenda', '$entrega', '$tel', '$dni', '$marca', '$ano',
               '$precio_crudo', '$fecha_ven', '$precio_info_dto', '$codia')";
      if (mysqli_query($conn, $sql)) {
            //echo "Datos guardados";
            
            //printf ("Nuevo registro con el id %d.\n", mysqli_insert_id($conn));
           $id_cliente = mysqli_insert_id($conn);


      } 
      else 
      {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
      mysqli_close($conn);
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
    function myFunction(imagen) {
        var x = document.getElementById("oculto");
           //alert(x.style.display);
        var y = document.getElementById("oculto2");
        var z = document.getElementById("oculto3");
        var w = document.getElementById("oculto4");
        var motor = document.getElementById("ir_motor_adelante");
        var auto  = document.getElementById("ir_auto_adelante");
        var asiento  = document.getElementById("ir_asiento_adelante");
        var motor_a = document.getElementById("ir_motor_atras");
        var auto_a  = document.getElementById("ir_auto_atras");
        var asiento_a  = document.getElementById("ir_asiento_atras");

        if(imagen=="motor")
        {
           
                document.getElementById("img1").src="imagenes/motor.svg";
                document.getElementById("img2").src="imagenes/auto2.svg";
                document.getElementById("img3").src="imagenes/asientos2.png";
                document.getElementById("img4").src="imagenes/rueda.svg";
                motor.style.display = "none";
                auto.style.display = "inline-block";
                asiento.style.display = "none";
                motor_a.style.display = "inline-block";
                auto_a.style.display = "none";
                asiento_a.style.display = "none";
                x.style.display = "none";
                y.style.display = "block";
                z.style.display = "none";
                w.style.display = "none";
           
             
           
        }
        if(imagen=="motor_a")
        {
                document.getElementById("img1").src="imagenes/motor2.svg";
                document.getElementById("img2").src="imagenes/auto.svg";
                document.getElementById("img3").src="imagenes/asientos2.png";
                document.getElementById("img4").src="imagenes/rueda.svg";
                motor.style.display = "inline-block";
                auto.style.display = "none";
                asiento.style.display = "none";
                motor_a.style.display = "none";
                auto_a.style.display = "none";
                asiento_a.style.display = "none";
                y.style.display = "none";
                x.style.display = "inline-block";
                z.style.display = "none";
                w.style.display = "none";
           
             
           
        }
        if(imagen=="auto")
        {
                document.getElementById("img1").src="imagenes/motor.svg";
                document.getElementById("img2").src="imagenes/auto.svg";
                document.getElementById("img3").src="imagenes/asientos.png";
                document.getElementById("img4").src="imagenes/rueda.svg";
                motor.style.display = "none";
                auto.style.display = "none";
                asiento.style.display = "inline-block";
                motor_a.style.display = "none";
                auto_a.style.display = "inline-block";
                asiento_a.style.display = "none";
                x.style.display = "none";
                y.style.display = "none";
                z.style.display = "block";
                w.style.display = "none";
        }

        if(imagen=="auto_a")
        {
                document.getElementById("img1").src="imagenes/motor.svg";
                document.getElementById("img2").src="imagenes/auto2.svg";
                document.getElementById("img3").src="imagenes/asientos2.png";
                document.getElementById("img4").src="imagenes/rueda.svg";
                motor.style.display = "none";
                auto.style.display = "inline-block";
                asiento.style.display = "none";
                motor_a.style.display = "inline-block";
                auto_a.style.display = "none";
                asiento_a.style.display = "none";
                x.style.display = "none";
                y.style.display = "block";
                z.style.display = "none";
                w.style.display = "none";
        }
        if(imagen=="asiento")
        {
            if (z.style.display == "none"){
                z.style.display = "block";
                document.getElementById("img3").src="imagenes/asientos.png";
                document.getElementById("img2").src="imagenes/auto.svg";
                document.getElementById("img1").src="imagenes/motor.svg";
                document.getElementById("img4").src="imagenes/rueda.svg";
                y.style.display = "none";
                x.style.display = "none";
                w.style.display = "none";
            }
            else{
                z.style.display = "none";
                document.getElementById("img3").src="imagenes/asientos2.png";
                document.getElementById("img2").src="imagenes/auto.svg";
                document.getElementById("img1").src="imagenes/motor.svg";
                document.getElementById("img4").src="imagenes/rueda.svg";
                y.style.display = "none";
                x.style.display = "none";
                w.style.display = "none";
            }
        }
        if(imagen=="rueda")
        {
            //alert(imagen);
            //alert(w.style.display);
            if (w.style.display == "none"){
               // alert("entro1");
                w.style.display = "block";
                document.getElementById("img4").src="imagenes/rueda.png";
                document.getElementById("img3").src="imagenes/asientos2.png";
                document.getElementById("img2").src="imagenes/auto.svg";
                document.getElementById("img1").src="imagenes/motor.svg";
                y.style.display = "none";
                x.style.display = "none";
                z.style.display = "none";
            }
            else{
                w.style.display = "none";
                document.getElementById("img4").src="imagenes/rueda.svg";
                document.getElementById("img3").src="imagenes/asientos2.png";
                document.getElementById("img2").src="imagenes/auto.svg";
                document.getElementById("img1").src="imagenes/motor.svg";
                y.style.display = "none";
                x.style.display = "none";
                y.style.display = "none";
            }
        }
        
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
<style>
/*#oculto{display:none;}
#oculto2{display:none;}
#oculto3{display:none;}
#oculto4{display:none;}*/
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
            <form action="cotiz_final.php" method="POST"> 
               
                <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
                    <?php
                    $conn = mysqli_connect($servername, $username, $password, $database);
                    $sql = "SELECT nombre, apellido, auto, ano, precio_info FROM cotizados WHERE id = $id_cliente";
                    //echo $id_cliente;
                    $resultado = mysqli_query($conn, $sql) or die ('Error en el query 2 database');
                    while ($fila = mysqli_fetch_array( $resultado ))
                    {
                        $cliente = $fila["apellido"].' '.$fila["nombre"];
                        $auto = $fila["auto"].' modelo '.$fila["ano"];
                    }

                    ?>
                    <h5>Cliente: <?php echo $cliente; ?></h5><BR>
                 
                    <h5>Automovil: <?php echo $auto.'<BR>Precio estimado: $'.$precio_d; ?></h5><BR>
                    
                    <input hidden type="text" name="precio2" value="<?php echo $precio_crudo; ?>"/>
                    <input hidden type="text" name="id" value="<?php echo $id_cliente; ?>"/>
                    <input hidden type="text" name="ano" value="<?php echo $ano; ?>"/>
                    <input hidden type="text" name="cliente" value="<?php echo $cliente; ?>"/>
                    <input hidden type="text" name="auto" value="<?php echo $auto; ?>"/>
                    <div style="margin:1em">
                        <a style="margin:0.5em">
                            <img id="img1" src="imagenes/motor2.svg" width="50" height="50" />
                        </a>
                        <a style="margin:0.5em">
                           <img id="img2" src="imagenes/auto.svg" width="50" height="50" />
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
                    <div id="oculto">
                         <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Funcionamiento</strong></h4>
                        <h6>El auto funciona correctamente?</h6>
                        <input id="cotitu" type="radio" name="funcion" value="si" required>Si
                        <input id="cotitu" type="radio" name="funcion" value="no" required>No
                        
                        <h6>El motor presenta alguna falla?</h6>
                        <input id="uso" type="radio" name="falla" value="si" required>Si
                        <input id="uso" type="radio" name="falla" value="no" required>No
                        
                        <h6>La caja de cambios tiene algun desperfecto?</h6>
                        <input type="radio" name="caja" value="si" required>Si
                        <input type="radio" name="caja" value="no" required>No
                        
                        <h6>Los frenos tienen alguna falla?</h6>
                        <input type="radio" name="frenos" value="si" required>Si
                        <input type="radio" name="frenos" value="no" required>No

                        <h6>La suspensión o el tren delantero hacen ruidos anormales?</h6>
                        <input type="radio" name="sus_tren" value="si" required>Si
                        <input type="radio" name="sus_tren" value="no" required>No
                        
                        <h6>Con el auto en marcha se prenden luces de advertencia?</h6>
                        <input type="radio" name="adver" value="si" required>Si
                        <input type="radio" name="adver" value="no" required>No
                        
                        <h6>Hay algun indicador del tablero que no funciona?</h6>
                        <input type="radio" name="indi" value="si" required>Si
                        <input type="radio" name="indi" value="no" required>No

                        <h6>Los airbags funcionan?</h6>
                            <input type="radio" name="airbag" value="si" required>Si
                            <input type="radio" name="airbag" value="no" required>No
                         <h6>El  ABS funciona?</h6>
                            <input type="radio" name="abs" value="si" required>Si
                            <input type="radio" name="abs" value="no" required>No
                    </div>
                    <div id="oculto2" style="display:none">
                        <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Aspecto Exterior</strong></h4>
                        
                        <h6>Tuvo algun choque fuerte?</h6>
                        <input type="radio" name="choque" value="si" required>Si
                        <input type="radio" name="choque" value="no" required>No

                        <h6>El parabrisas esta rajado o tiene piquetes?</h6>
                        <input id="cotitu" type="radio" name="parabri" value="si" required>Si
                        <input id="cotitu" type="radio" name="parabri" value="no" required>No
                        
                        <h6>Las ópticas delanteras están sanas?</h6>
                        <input id="uso" type="radio" name="opticas" value="si" required>Si
                        <input id="uso" type="radio" name="opticas" value="no" required>No
                        
                        <h6>Losa faros traseros están sanos?</h6>
                        <input type="radio" name="faros" value="si" required>Si
                        <input type="radio" name="faros" value="no" required>No
                        
                        <h6>Tiene algún daño por granizo?</h6>
                        <input type="radio" name="grani" value="si" required>Si
                        <input type="radio" name="grani" value="no" required>No

                        <h6>Estado general de la pintura</h6>
                        <select class="col-lg-8" name="pintura" required>
                            <option value="">Seleccionar</option>    
                            <option value="1">Muy bueno</option>
                            <option value="2">Levemente rayado</option>
                            <option value="3">Muy rayado</option>
                        </select><BR><BR>
                        
                        <h6>La pintura tiene paneles rayados?</h6>
                        <input type="radio" name="panel" value="si" required onclick="return myFunction2(0)">Si
                        <input type="radio" name="panel" value="no" required onclick="return myFunction2(1)">No
                        <div id="paneles">
                            <br>
                            
                            <label><input name="paneles[]" type="checkbox" id="cbox1"  value="cap">Capot</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox2"  value="bau">Baul</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox3"  value="tec">Techo</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox4"  value="pdi">Puerta delantera izquierda</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox5"  value="pdd">Puerta delantera derecha</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox6"  value="pti">Puerta trasera izquierda</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox7"  value="ptd">Puerta trasera derecha</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox8"  value="gdi">Guardabarro delantero izquierdo</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox9"  value="gdd">Guardabarro delantero derecho</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox10" value="gti">Guardabarro trasero izquierdo</label><br>
                            <label><input name="paneles[]" type="checkbox" id="cbox11" value="gtd">Guardabarro trasero derecho</label><br>
                           
                        </div>

                        <h6>La chapa tiene rayas profundas?</h6>
                        <input type="radio" name="profundo" value="si" required onclick="return myFunction3(0)"> Si
                        <input type="radio" name="profundo" value="no" required onclick="return myFunction3(1)">No
                        <div id="paneles2">
                            <br>
                            <label><input name="profu[]" type="checkbox" id="cbox21"  value="cap">Capot</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox22"  value="bau">Baul</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox23"  value="tec">Techo</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox24"  value="pdi">Puerta delantera izquierda</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox25"  value="pdd">Puerta delantera derecha</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox26"  value="pti">Puerta trasera izquierda</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox27"  value="ptd">Puerta trasera derecha</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox28"  value="gdi">Guardabarro delantero izquierdo</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox29"  value="gdd">Guardabarro delantero derecho</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox210" value="gti">Guardabarro trasero izquierdo</label><br>
                            <label><input name="profu[]" type="checkbox" id="cbox211" value="gtd">Guardabarro trasero derecho</label><br>
                        </div>
                        <h6>Estado general del paragolpe delantero</h6>
                        <select class="col-lg-8" name="paradel" required>
                            <option value="">Seleccionar</option>    
                            <option value="1">Prefecto</option>
                            <option value="2">Levemente rayado</option>
                            <option value="3">Chocado o roto</option>
                        </select><BR><BR>
                        <h6>Estado general del paragolpe trasero</h6>
                        <select class="col-lg-8" name="paratra" required>
                            <option value="">Seleccionar</option>    
                            <option value="1">Prefecto</option>
                            <option value="2">Levemente rayado</option>
                            <option value="3">Chocado o roto</option>
                        </select><BR><BR>
                    </div>
                    <div id="oculto3" style="display:none">
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
                                <option value="3">Algo descolorado</option>
                                <option value="4">En malas condiciones</option>
                            </select><BR><BR>
                        
                        <h6>El AA enfría?</h6>
                            <input id="aa" type="radio" name="aa" value="si" required>Si
                            <input id="aa" type="radio" name="aa" value="no" required>No
                        <h6>La calefaccion funciona?</h6>
                            <input id="cale" type="radio" name="cale" value="si" required>Si
                            <input id="cale" type="radio" name="cale" value="no" required>No
                        <h6>Los vidrios electricos funcionan?</h6>
                            <input id="vid" type="radio" name="vid" value="si" required>Si
                            <input id="vid" type="radio" name="vid" value="no" required>No
                        <h6>Cierre centralizado</h6>
                        <select class="col-lg-8" name="cierre" required>
                                <option value="">Seleccionar</option>    
                                <option value="1">No tiene</option>
                                <option value="2">Funciona</option>
                                <option value="3">No funciona</option>
                        </select><BR><BR>
                    </div>
                    <div id="oculto4" style="display:none">
                        <h4 style="background:darkgrey; border 1px;border-radius:5px"><strong>Cubiertas y accesorios</strong></h4>
                        <h6>Kilometros de los neumáticos</h6>
                            <select class="col-lg-8" name="neuma" required>
                                <option value="">Seleccionar</option>    
                                <option value="1">de 0 a 20.000 km</option>
                                <option value="2">de 20.000 a 40.000 km</option>
                                <option value="3">Mas de 40.000 km</option>
                                <option value="4">No sabe</option>
                            </select><BR><BR>
                        <h6>Llantas o tasas</h6>
                            <select class="col-lg-8" name="llantas" required>
                                <option value="">Seleccionar</option>    
                                <option value="1">En perfecto estado</option>
                                <option value="2">Levemente rayadas</option>
                                <option value="3">Muy golpeadas</option>
                            </select><br><br>
                        <h6>LLave comando, segunda llave, rueda de auxilio y llave cruz/cricket</h6>
                            (Seleccionar lo que no anda o no tiene)
                            </select><BR>
                            <label><input name="llave[]" type="checkbox" id="llave" value="llave_c">LLave comando</label><br>
                            <label><input name="llave[]" type="checkbox" id="llave" value="llave_2">Segunda llave</label><br>
                            <label><input name="llave[]" type="checkbox" id="llave" value="auxilio">Rueda de auxilio</label><br>
                            <label><input name="llave[]" type="checkbox" id="llave" value="cruz">LLave cruz</label><br>
                            <label><input name="llave[]" type="checkbox" id="llave" value="cricket">Cricket</label><br>
                    </div><br>
                    
                    <input id="ir_motor_atras" style="display:none" onClick="myFunction('motor_a');" type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="Atras" />
                    <input id="ir_auto_atras" style="display:none" onClick="myFunction('auto_a');" type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="Atras" />
                    <input id="ir_asiento_atras" style="display:none" onClick="myFunction('asiento_a');" type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="Atras" />
                    
                    <input id="ir_motor_adelante" onClick="myFunction('motor');" type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="avanzar" />
                    <input id="ir_auto_adelante" style="display:none" onClick="myFunction('auto');" type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="avanzar" />
                    <input id="ir_asiento_adelante" style="display:none" onClick="myFunction('asiento');" type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="avanzar" />
                    
                    <input style="display:none" id="mySubmit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Avanzar"/>
                  
                    <!--<a href="marcas.php?titular=titular">
                        <button id="boton" type="button" class="btn btn-light" data_but="btn-xs"><i class='fa fa-automobile'></i>Continuar
                        </button>
                    
                    </a>--><br><br>
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
               // function cheking() {
               //     alert(document.getElementById("titu").value);
               //     alert(document.getElementById("cotitu").value);
            
              //  }

                </script>
                <?php
               
          
                ?>
            </div>
        </div>
    </div>
    
	</section>