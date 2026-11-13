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
            <form action="modifica_peritaje.php" method="POST" id="validationForm" name="validationForm">
              
                    <h5>Vehículo: <?php echo $auto.', modelo '.$ano; ?></h5>
                    
                    <?php //echo "Dolar ".$valor_dolar;?>
                    <?php //echo "precio en pesos ".$precio;?>
                    <?php if ($row['ver_valor']=='s')
                    { ?>
                        <h5>Valor de toma estimativo: $<?php echo number_format($fila['precio_info'],0,'','.');?></h5>
                    <?php } 
                    ?>
                    <button onclick="muestraDatos();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Datos generales</button>              
                    <button onclick="funciona();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Funcionamiento</button>              
                    <button onclick="exterior();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Aspecto exterior</button>              
                    <button onclick="interior();" style="background:darkgrey; border: 1px;border-radius:5px; color:white; margin-bottom:0.4em;" type="button">Aspecto interior</button>              
                    <button onclick="accesorios();" style="background:darkgrey; border: 1px;border-radius:5px; color:white;" type="button">Cubiertas y accesorios</button>              
                    <div id="oculto">
                        <br><h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Datos Generales</strong></h4>
                        
                        <input type="text" hidden name="id_cambio"  value="<?php echo $id;?>">
                        <label forHTML="letras">Apellido/s</label>
                        <input type="text" id="letras" name="ape" required pattern="([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)+([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)" value="<?php echo $fila['apellido'];?>"><BR>
                        <div id="message" style="position: absolute; left: 10px; top: 50px; background-color: red; z-index: 10" hidden>
                            Introduzca solo letras. Máximo 35 caracteres.
                        </div>
                        <label>Nombre/s</label>
                        <input type="text" id="nombre" name="nom" required pattern="([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)+([a-zA-ZÁÉÍÓÚñáéíóú]{1,}[\s]*)" value="<?php echo $fila['nombre'];?>""><br>

                        <!--<input type="text" id="nombre" name="nom" required onkeyup="validar(this.id)" onblur="validar(this.id)"><BR>-->
                        <label>D.N.I.</label>
                        <input type="text" name="dni" id="dni" required pattern="[0-9]{7,8}"  value="<?php echo $fila['dni'];?>"><BR>
                                                                        
                        <label>Celular</label>
                        +<input type="text" name="celu" maxlength="10" size="12" required pattern="[0-9]{12}" value="<?php echo $fila['celular'];?>"><br>
                        <!--<input type="text" id="area" name="area" size="3" placeholder="cod area sin 0" pattern="[0-9]{2,4}" required>
                        <input type="text" id="cel" name="cel" size="6" placeholder="numero sin 15" pattern="[0-9]{6,8}" required onkeyup="verificaCel()"><BR>
                        <input type="tel" name="cel" pattern="\([0-9]{3}\) [0-9]{4}[ -][0-9]{6}" 

                        title="código pais 3 digitos entre parentesis, un espacio, 4 para area provincia y 6 para el numero de linea" placeholder="(pais) dddd-ddddd" required><br>-->
                        
                        <label>Tel. fijo </label>
                        +<input type="text" name="pais2" value="54" size="2"><input type="text" name="tel" size="10"><BR>
                        <label>E-mail</label>
                        <!--<input type="text" name="mail" id="mail" required onblur="validarE(this.id)"><BR>-->
                        <input type="text" name="mail" id="mail" required value="<?php echo $fila['email'];?>"><BR>
                        
                        <label>Provincia</label>
                        
                        
                        <?php
                        $busca_pro = $fila["provincia"];
                        $sql = "SELECT * FROM provincias ORDER BY nombre";
                        $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');    

                                    $busca_codigo = "SELECT * FROM provincias WHERE nombre='$busca_pro'";
                                    $busca_res = mysqli_query($conn, $busca_codigo) or die ('Error en el query database');    
                                    $busca_resu = mysqli_fetch_array($busca_res);
                                    //echo "Codigo: ".$busca_resu['codigo'];
                                    echo '<select class="col-lg-3" name="pro" id="proveedor" onfocus="CargarProductos(this.value);">';
                                    
                                    echo '<option value="'.$busca_resu["codigo"].'">'.$fila["provincia"].'</option>';
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
                        
                       
                            <input  class="col-lg-3" type="text" name="key" id="key" placeholder="Buscar..." onfocus="esconder();"  value="<?php echo $fila['ciudad'];?>">

                      
                    
                        <div id="suggestions">
                        </div>
                        <label>Patente</label>
                        <!--<input type="text" name="pat" id="patente" required onblur="validarPatente(this.value)"><BR>-->
                        <input type="text" name="pat" id="patente" required pattern="([A-Za-z]{3}[0-9]{3})*([A-Za-z]{2}[0-9]{3}[A-Za-z]{2})*" placeholder="XX000XX o XXX000" value="<?php echo $fila['patente'];?>"><br>
                        
                        <label>Kilometros</label>
                        <input type="text" name="kil" id="kilometros" required pattern="[0-9]{1,6}" placeholder="Solo números" value="<?php echo $fila['kilometros'];?>"><BR>
                        
                        <label>Color</label>
                        
                        <select required class="col-lg-3" name="color" id="color">
                        <option value="<?php echo $fila['color'];?>"><?php echo $fila['color'];?></option>
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
                        </select><br>
                        Nº de asientos
                        
                        <select class="col-lg-4" name="asientos" required>
                            <option value="<?php echo $fila['asientos'];?>"><?php echo $fila['asientos'];?></option>    
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
                            <option value="<?php echo $fila['combustible'];?>"><?php echo $fila['combustible'];?></option>    
                            <option value="">Seleccionar</option>    
                            <option value="nafta">Nafta</option>
                            <option value="diesel">Diesel</option>
                            <option value="electrico">Eléctrico</option>
                        </select><BR><BR>
                        Transmisión
                        
                        <select class="col-lg-4" name="trans" required>
                            <option value="<?php echo $fila['transmision'];?>"><?php echo $fila['transmision'];?></option>    
                            <option value="">Seleccionar</option>    
                            <option value="manual">Manual</option>
                            <option value="automatica">Automática</option>
                        </select><br><br>
                        Cilindrada
                        
                        <input type="text" name="cilin" size="2"  required pattern="[0-9.]+" value="<?php echo $fila['cilindrada'];?>"><BR><br>
                        </select>

                        <h6>Tiene co-titular o figura casado?</h6>
                        <?php
                        if ($fila["cotitular"] == "si")
                        {
                        ?>
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="si" required checked>Si
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="no" required>No
                        <?php
                        }
                        else 
                        {
                        ?>
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="si" required>Si
                        <input id="cotitu" class="radio" type="radio" name="cotitu" value="no" required checked>No
                        <?php
                        }
                        ?>
                        <h6>Se usa como taxi, remis, uber o similar?</h6>
                         <?php
                        if ($fila["tax_rem_uber"] == "si")
                        {
                        ?>
                        <input id="uso" class="radio" type="radio" name="uso" value="si" required checked>Si
                        <input id="uso" class="radio" type="radio" name="uso" value="no" required>No
                        <?php
                        }
                        else 
                        {
                        ?>    
                        <input id="uso" class="radio" type="radio" name="uso" value="si" required>Si
                        <input id="uso" class="radio" type="radio" name="uso" value="no" required checked>No                  
                        <?php
                        }
                        ?>
                        <h6>El vehículo está prendado?</h6>
                        <?php
                        if ($fila["prendado"] == "si")
                        {
                        ?>
                        <input type="radio" class="radio" name="prenda" value="si" required checked>Si
                        <input type="radio" class="radio" name="prenda" value="no" required>No
                         <?php
                        }
                        else 
                        {
                        ?>    
                        <input type="radio" class="radio" name="prenda" value="si" required>Si
                        <input type="radio" class="radio" name="prenda" value="no" required checked>No
                         <?php
                        }
                        ?>
                    </div>
                    <div id="oculto2">
                        <label class="btn btn-danger" data_but="btn-xs">No es posible cotizar si no es titular
                        </label>
                    </div>
                    <div style="display:none;" id="funcionamiento">
                      <br><h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Funcionamiento</strong></h4>
                      <?php
                      //echo "ID Cliente: ",$id;
                      $sql_fun = "SELECT * FROM funcionamiento WHERE id_cliente='$id'";
                      $resultado_fun = mysqli_query($conn, $sql_fun) or die ('Error en el query database');
                      $fila_fun = mysqli_fetch_array($resultado_fun);
                    
                      if (mysqli_num_rows($resultado_fun) > 0 )
                      {
                      ?>
                      <h6>El auto funciona correctamente?</h6>
                      <?php
                      if ($fila_fun["funciona"] == "si")
                      {
                      ?>
                        <input id="cotitu" type="radio" class="radio" name="funcion" value="si" required checked>Si
                        <input id="cotitu" type="radio" class="radio" name="funcion" value="no" required>No                     
                      <?php
                      }
                      else 
                      {
                      ?>    
                        <input id="cotitu" type="radio" class="radio" name="funcion" value="si" required>Si
                        <input id="cotitu" type="radio" class="radio" name="funcion" value="no" required checked>No
                      <?php
                      }
                      ?>
                                                            
                      <h6>El motor presenta alguna falla?</h6>
                      <?php
                      if ($fila_fun["falla_motor"] == "si")
                      {
                      ?>
                      <input id="uso" type="radio" class="radio" name="falla" value="si" required checked>Si
                      <input id="uso" type="radio" class="radio" name="falla" value="no" required>No                    
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input id="uso" type="radio" class="radio" name="falla" value="si" required>Si
                      <input id="uso" type="radio" class="radio" name="falla" value="no" required checked>No
                      <?php
                      }
                      ?>
                      
                                        
                      <h6>La caja de cambios tiene algun desperfecto?</h6>
                      <?php
                      if ($fila_fun["falla_caja"] == "si")
                      {
                      ?>
                      <input type="radio" class="radio" name="caja" value="si" required checked>Si
                      <input type="radio" class="radio" name="caja" value="no" required>No                                          
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input type="radio" class="radio" name="caja" value="si" required>Si
                      <input type="radio" class="radio" name="caja" value="no" required checked>No
                      <?php
                      }
                      ?>
                      <h6>Los frenos tienen alguna falla?</h6>
                      <?php
                      if ($fila_fun["falla_frenos"] == "si")
                      {
                      ?>
                      <input type="radio" class="radio" name="frenos" value="si" required checked>Si
                      <input type="radio" class="radio" name="frenos" value="no" required>No                                          
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input type="radio" class="radio" name="frenos" value="si" required>Si
                      <input type="radio" class="radio" name="frenos" value="no" required checked>No
                      <?php
                      }
                      ?>
                      <h6>La suspensión o el tren delantero hacen ruidos anormales?</h6>
                      <?php
                      if ($fila_fun["falla_sus_tren"] == "si")
                      {
                      ?>
                      <input type="radio" class="radio" name="sus_tren" value="si" required checked>Si
                      <input type="radio" class="radio" name="sus_tren" value="no" required>No                                          
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input type="radio" class="radio" name="sus_tren" value="si" required>Si
                      <input type="radio" class="radio" name="sus_tren" value="no" required checked>No
                      <?php
                      }
                      ?>
                      <h6>Con el auto en marcha se prenden luces de advertencia?</h6>
                      <?php
                      if ($fila_fun["luces_adver"] == "si")
                      {
                      ?>
                      <input type="radio" class="radio" name="adver" value="si" required checked>Si
                      <input type="radio" class="radio" name="adver" value="no" required>No                                          
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input type="radio" class="radio" name="adver" value="si" required>Si
                      <input type="radio" class="radio" name="adver" value="no" required checked>No
                      <?php
                      }
                      ?>
                      <h6>Hay algun indicador del tablero que no funciona?</h6>
                      <?php
                      if ($fila_fun["falla_indicadores"] == "si")
                      {
                      ?>
                      <input type="radio" class="radio" name="indi" value="si" required checked>Si
                      <input type="radio" class="radio" name="indi" value="no" required>No                                          
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input type="radio" class="radio" name="indi" value="si" required>Si
                      <input type="radio" class="radio" name="indi" value="no" required checked>No
                      <?php
                      }
                      ?>
                      <h6>Los airbags funcionan?</h6>
                      <?php
                      if ($fila_fun["airbag"] == "si")
                      {
                      ?>
                      <input type="radio" class="radio" name="airbag" value="si" required checked>Si
                      <input type="radio" class="radio" name="airbag" value="no" required>No                                          
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input type="radio" class="radio" name="airbag" value="si" required>Si
                      <input type="radio" class="radio" name="airbag" value="no" required checked>No
                      <?php
                      }
                      ?>
                      <h6>El  ABS funciona?</h6>
                      <?php
                      if ($fila_fun["abs"] == "si")
                      {
                      ?>
                      <input type="radio" class="radio" name="abs" value="si" required checked>Si
                      <input type="radio" class="radio" name="abs" value="no" required>No                                          
                      <?php
                      }
                      else 
                      {
                      ?>    
                      <input type="radio" class="radio" name="abs" value="si" required>Si
                      <input type="radio" class="radio" name="abs" value="no" required checked>No
                      <?php
                      }
                      }
                      else 
                      {
                        echo "Naranja Fanta";
                      }
                      ?>

                    </div>
                    <div style="display:none;" id="exterior">
                        <br><h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Aspecto Exterior</strong></h4>
                        <?php
                        //echo "ID Cliente: ",$id;
                        $sql_ext = "SELECT * FROM aspecto_exterior WHERE id_cliente='$id'";
                        $resultado_ext = mysqli_query($conn, $sql_ext) or die ('Error en el query database');
                        $fila_ext = mysqli_fetch_array($resultado_ext);
                        $id_ext = $fila_ext['id'];
                        if (mysqli_num_rows($resultado_ext) > 0 )
                        {
                          ?>
                          <h6>Tuvo algun choque fuerte?</h6>
                          <?php
                          if ($fila_ext["choque_fuerte"] == "si")
                          {
                          ?>
                          <input type="radio"  class="radio"name="choque" value="si" required checked>Si
                          <input type="radio"  class="radio"name="choque" value="no" required>No                                            
                          <?php
                          }
                          else 
                          {
                          ?>    
                          <input type="radio"  class="radio"name="choque" value="si" required>Si
                          <input type="radio"  class="radio"name="choque" value="no" required checked>No
                          <?php
                          }
                          ?>
  

                          <h6>El parabrisas esta rajado o tiene piquetes?</h6>
                          <?php
                          if ($fila_ext["parabrisas_roto"] == "si")
                          {
                          ?>
                          <input id="cotitu" class="radio" type="radio" name="parabri" value="si" required checked>Si
                          <input id="cotitu" class="radio" type="radio" name="parabri" value="no" required>No                                            
                          <?php
                          }
                          else 
                          {
                          ?>    
                          <input id="cotitu" class="radio" type="radio" name="parabri" value="si" required>Si
                          <input id="cotitu" class="radio" type="radio" name="parabri" value="no" required checked>No
                          <?php
                          }
                          ?>

                          
                          <h6>Las ópticas delanteras están sanas?</h6>
                          <?php
                          if ($fila_ext["opticas_del_rotas"] == "si")
                          {
                          ?>
                          <input id="uso" class="radio" type="radio" name="opticas" value="si" required checked>Si
                          <input id="uso" class="radio" type="radio" name="opticas" value="no" required>No                                            
                          <?php
                          }
                          else 
                          {
                          ?>    
                          <input id="uso" class="radio" type="radio" name="opticas" value="si" required>Si
                          <input id="uso" class="radio" type="radio" name="opticas" value="no" required checked>No
                          <?php
                          }
                          ?>                        

                          
                          <h6>Los faros traseros están sanos?</h6>
                          <?php
                          if ($fila_ext["faros_atras_rotos"] == "si")
                          {
                          ?>
                          <input type="radio" class="radio" name="faros" value="si" required checked>Si
                          <input type="radio" class="radio" name="faros" value="no" required>No                                            
                          <?php
                          }
                          else 
                          {
                          ?>    
                          <input type="radio" class="radio" name="faros" value="si" required>Si
                          <input type="radio" class="radio" name="faros" value="no" required checked>No
                          <?php
                          }
                          ?>                      

                          
                          <h6>Tiene algún daño por granizo?</h6>
                          <?php
                          if ($fila_ext["danio_granizo"] == "si")
                          {
                          ?>
                          <input type="radio" class="radio" name="grani" value="si" required checked>Si
                          <input type="radio" class="radio" name="grani" value="no" required>No                                            
                          <?php
                          }
                          else 
                          {
                          ?>    
                          <input type="radio" class="radio" name="grani" value="si" required>Si
                          <input type="radio" class="radio" name="grani" value="no" required checked>No
                          <?php
                          }
                          ?>                        

                          <br><br>
                          <h6>Estado general de la pintura</h6>

                          <select class="col-lg-8" name="pintura" required>
                              <?php
                                if($fila_ext['estado_pintura']==1)
                                {
                                  $value = "Muy bueno";
                                }
                                elseif($fila_ext['estado_pintura']==2)
                                {
                                  $value = "Levemente rayado";
                                }
                                elseif($fila_ext['estado_pintura']==3)
                                {
                                  $value = "Muy rayado";
                                }
                              ?>
                              <option value="<?php echo $fila_ext['estado_pintura'];?>"><?php echo $value;?></option>    
                              <option value="1">Muy bueno</option>
                              <option value="2">Levemente rayado</option>
                              <option value="3">Muy rayado</option>
                          </select><BR><BR>
                          
                          <h6>La pintura tiene paneles rayados?</h6>
                          <?php
                          if ($fila_ext["paneles_rayados"] == "si")
                          {
                          ?>
                          
                          <input type="radio" class="radio" name="panel" id="panel" value="si" required onclick="return myFunction2(0)" checked>Si
                          <input type="radio" class="radio" name="panel" value="no" required onclick="return myFunction2(1)">No                                              
                          <?php
                          }
                          else 
                          {
                          ?>
                        
                          <input type="radio" class="radio" name="panel" id="panel" value="si" required onclick="return myFunction2(0)">Si
                          <input type="radio" class="radio" name="panel" value="no" required onclick="return myFunction2(1)" checked>No
                          <?php
                          }
                          ?>

                          <div id="paneles">
                              <br>
                              <?php
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'cap'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox1"  value="cap" checked>Capot</label><br>                    
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox1"  value="cap">Capot</label><br>
                              <?php
                              }
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'bau'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox2"  value="bau" checked>Baul</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox2"  value="bau">Baul</label><br>
                              <?php
                              }   
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'tec'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox3"  value="tec" checked>Techo</label><br>                              
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox3"  value="tec">Techo</label><br>
                              <?php
                              }                           
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'pdi'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox4"  value="pdi" checked>Puerta delantera izquierda</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox4"  value="pdi">Puerta delantera izquierda</label><br>
                              <?php
                              }                           
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'pdd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox5"  value="pdd" checked>Puerta delantera derecha</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox5"  value="pdd">Puerta delantera derecha</label><br>
                              <?php
                              }                           
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'pti'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox6"  value="pti" checked>Puerta trasera izquierda</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox6"  value="pti">Puerta trasera izquierda</label><br>
                              <?php
                              } 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'ptd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox7"  value="ptd" checked>Puerta trasera derecha</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox7"  value="ptd">Puerta trasera derecha</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'gdi'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox8"  value="gdi" checked>Guardabarro delantero izquierdo</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox8"  value="gdi">Guardabarro delantero izquierdo</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'gdd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox9"  value="gdd" checked>Guardabarro delantero derecho</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox9"  value="gdd">Guardabarro delantero derecho</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'gti'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox10" value="gti" checked>Guardabarro trasero izquierdo</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox10" value="gti">Guardabarro trasero izquierdo</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_pintura WHERE id_exterior = '$id_ext' AND item = 'gtd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox11" value="gtd" checked>Guardabarro trasero derecho</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="paneles[]" class="checkbox" type="checkbox" id="cbox11" value="gtd">Guardabarro trasero derecho</label><br>
                              <?php
                              }                                 

                              ?>
                          </div><br>
                          <h6>La chapa tiene rayas profundas?</h6>
                          <?php
                          if ($fila_ext["rayas_profundas"] == "si")
                          {
                          ?>
                          <input type="radio" class="radio" name="profundo" id="profu" value="si" required onclick="return myFunction3(0)" checked> Si
                          <input type="radio" class="radio" name="profundo" value="no" required onclick="return myFunction3(1)">No
                          <?php
                          }
                          else 
                          {
                          ?>    
                         
                          <input type="radio" class="radio" name="profundo" id="profu" value="si" required onclick="return myFunction3(0)"> Si
                          <input type="radio" class="radio" name="profundo" value="no" required onclick="return myFunction3(1)" checked>No
                          <?php
                          }
                          ?>
                        
                          <div id="paneles2">
                              <br>
                              <?php
                              $sql_ext_paneles2 = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'cap'";
                              $resultado_paneles2 = mysqli_query($conn, $sql_ext_paneles2) or die ('Error en el query database');
                              $fila_paneles2 = mysqli_fetch_array( $resultado_paneles2 );
                              if (mysqli_num_rows($resultado_paneles2) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox1"  value="cap" checked>Capot</label><br>                    
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox1"  value="cap">Capot</label><br>
                              <?php
                              }
                              $sql_ext_paneles2 = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'bau'";
                              $resultado_paneles2 = mysqli_query($conn, $sql_ext_paneles2) or die ('Error en el query database');
                              $fila_paneles2 = mysqli_fetch_array( $resultado_paneles2 );
                              if (mysqli_num_rows($resultado_paneles2) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox2"  value="bau" checked>Baul</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox2"  value="bau">Baul</label><br>
                              <?php
                              }   
                              $sql_ext_paneles2 = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'tec'";
                              $resultado_paneles2 = mysqli_query($conn, $sql_ext_paneles2) or die ('Error en el query database');
                              $fila_paneles2 = mysqli_fetch_array( $resultado_paneles2 );
                              if (mysqli_num_rows($resultado_paneles2) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox3"  value="tec" checked>Techo</label><br>                              
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox3"  value="tec">Techo</label><br>
                              <?php
                              }                           
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'pdi'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox4"  value="pdi" checked>Puerta delantera izquierda</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox4"  value="pdi">Puerta delantera izquierda</label><br>
                              <?php
                              }                           
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'pdd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox5"  value="pdd" checked>Puerta delantera derecha</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox5"  value="pdd">Puerta delantera derecha</label><br>
                              <?php
                              }                           
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'pti'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox6"  value="pti" checked>Puerta trasera izquierda</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox6"  value="pti">Puerta trasera izquierda</label><br>
                              <?php
                              } 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'ptd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox7"  value="ptd" checked>Puerta trasera derecha</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="produ[]" class="checkbox" type="checkbox" id="cbox7"  value="ptd">Puerta trasera derecha</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'gdi'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox8"  value="gdi" checked>Guardabarro delantero izquierdo</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox8"  value="gdi">Guardabarro delantero izquierdo</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'gdd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox9"  value="gdd" checked>Guardabarro delantero derecho</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox9"  value="gdd">Guardabarro delantero derecho</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'gti'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox10" value="gti" checked>Guardabarro trasero izquierdo</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox10" value="gti">Guardabarro trasero izquierdo</label><br>
                              <?php
                              }                                 
                              $sql_ext_paneles = "SELECT DISTINCT id_exterior, item FROM chapa_rayada WHERE id_exterior = '$id_ext' AND item = 'gtd'";
                              $resultado_paneles = mysqli_query($conn, $sql_ext_paneles) or die ('Error en el query database');
                              $fila_paneles = mysqli_fetch_array( $resultado_paneles );
                              if (mysqli_num_rows($resultado_paneles) > 0 )
                              {
                              ?>
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox11" value="gtd" checked>Guardabarro trasero derecho</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                              <label><input name="profu[]" class="checkbox" type="checkbox" id="cbox11" value="gtd">Guardabarro trasero derecho</label><br>
                              <?php
                              }                                 

                              ?>
                          </div>
                          
                          <br><br>
                          <h6>Estado general del paragolpe delantero</h6>
                          <select class="col-lg-8" name="paradel" required>
                              
                              <?php
                                if($fila_ext['paragolpe_del']==1)
                                {
                                  $value = "Perfecto";
                                }
                                elseif($fila_ext['paragolpe_del']==2)
                                {
                                  $value = "Levemente rayado";
                                }
                                elseif($fila_ext['paragolpe_del']==3)
                                {
                                  $value = "Roto";
                                }
                              ?>
                              
                              <option value="<?php echo $fila_ext['paragolpe_del'];?>"><?php echo $value;?></option>    
                              <option value="1">Perfecto</option>
                              <option value="2">Levemente rayado</option>
                              <option value="3">Chocado o roto</option>
                          </select><BR><BR>
                          <h6>Estado general del paragolpe trasero</h6>
                          <select class="col-lg-8" name="paratra" required>
                           
                              <?php
                                if($fila_ext['paragolpe_tras']==1)
                                {
                                  $value = "Perfecto";
                                }
                                elseif($fila_ext['paragolpe_tras']==2)
                                {
                                  $value = "Levemente rayado";
                                }
                                elseif($fila_ext['paragolpe_tras']==3)
                                {
                                  $value = "Roto";
                                }
                              ?>
                              
                              <option value="<?php echo $fila_ext['paragolpe_tras'];?>"><?php echo $value;?></option>    
                              <option value="1">Perfecto</option>
                              <option value="2">Levemente rayado</option>
                              <option value="3">Chocado o roto</option>
                          </select><BR><BR>
                          <?php
                        }
                     
                      else 
                      {
                        echo "Naranja Fanta";
                      }
                      ?>
                    </div>
                    <div id="interior" style="display:none;">
                       <br><h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Interior y climatización</strong></h4>
                        <h6>Estado general del tapizado</h6>
                            <select class="col-lg-8" name="tapi" required>
                            
                            <?php
                                $sql_int = "SELECT * FROM interior WHERE id_cliente='$id'";
                                $resultado_int = mysqli_query($conn, $sql_int) or die ('Error en el query database');
                                $fila_int = mysqli_fetch_array($resultado_int);
                                $id_int = $fila_int['id'];
                                if($fila_int['tapizado']==1)
                                {
                                  $value = "Sano y limpio";
                                }
                                elseif($fila_int['tapizado']==2)
                                {
                                  $value = "Algo manchado";
                                }
                                elseif($fila_int['tapizado']==3)
                                {
                                  $value = "Tiene partes rotas";
                                }
                                elseif($fila_int['tapizado']==4)
                                {
                                  $value = "Muy roto o muy manchado";
                                }
                              ?>
                              
                              <option value="<?php echo $fila_int['tapizado'];?>"><?php echo $value;?></option>    
                              
                                <option value="1">Sano y limpio</option>
                                <option value="2">Algo manchado</option>
                                <option value="3">Tiene partes rotas</option>
                                <option value="4">Muy roto o muy manchado</option>
                            </select><BR><BR>
                    
                        <h6>Polarizado?</h6>
                               <?php
                                
                                if($fila_int['polarizado']==1)
                                {
                                  $value = "No tiene";
                                }
                                elseif($fila_int['polarizado']==2)
                                {
                                  $value = "En buenas condiciones";
                                }
                                elseif($fila_int['polarizado']==3)
                                {
                                  $value = "ALgo descolorido";
                                }
                                elseif($fila_int['polarizado']==4)
                                {
                                  $value = "En malas condiciones";
                                }
                              ?>
                            <select class="col-lg-8" name="pola" required>
                                <option value="<?php echo $fila_int['polarizado'];?>"><?php echo $value;?></option>    
                                <option value="1">No tiene</option>
                                <option value="2">En buenas condiciones</option>
                                <option value="3">Algo descolorido</option>
                                <option value="4">En malas condiciones</option>
                            </select><BR><BR>
                        
                        <h6>El AA enfría?</h6>
                         <?php
                          if ($fila_int["aa_funciona"] == "si")
                          {
                          ?>
                            <input id="aa" class="radio" type="radio" name="aa" value="si" required checked>Si
                            <input id="aa" class="radio" type="radio" name="aa" value="no" required>No                                    
                          <?php
                          }
                          else 
                          {
                          ?>    
                            <input id="aa" class="radio" type="radio" name="aa" value="si" required>Si
                            <input id="aa" class="radio" type="radio" name="aa" value="no" required checked>No
                          <?php
                          }
                          ?>
                        
                        <h6>La calefaccion funciona?</h6>
                          <?php
                          if ($fila_int["calefac_funciona"] == "si")
                          {
                          ?>
                            <input id="cale" class="radio" type="radio" name="cale" value="si" required checked>Si
                            <input id="cale" class="radio" type="radio" name="cale" value="no" required>No                            
                          <?php
                          }
                          else 
                          {
                          ?>    
                            <input id="cale" class="radio" type="radio" name="cale" value="si" required>Si
                            <input id="cale" class="radio" type="radio" name="cale" value="no" required checked>No
                          <?php
                          }
                          ?>                        
                            
                        <h6>Los vidrios electricos funcionan?</h6>
                          <?php
                          if ($fila_int["levantacrist_funciona"] == "si")
                          {
                          ?>
                            <input id="vid" class="radio" type="radio" name="vid" value="si" required checked>Si
                            <input id="vid" class="radio" type="radio" name="vid" value="no" required>No
                          <?php
                          }
                          else 
                          {
                          ?>    
                             <input id="vid" class="radio" type="radio" name="vid" value="si" required>Si
                            <input id="vid" class="radio" type="radio" name="vid" value="no" required checked>No
                          <?php
                          }
                          ?>              
                       
                        <h6>Cierre centralizado</h6>
                        <select class="col-lg-8" name="cierre" required>
                                <?php
                               
                                if($fila_int['cierre_central']==1)
                                {
                                  $value = "No tiene";
                                }
                                elseif($fila_int['cierre_central']==2)
                                {
                                  $value = "Funciona";
                                }
                               
                              ?>
                              
                              <option value="<?php echo $fila_int['tapizado'];?>"><?php echo $value;?></option>    
                                <option value="">Seleccionar</option>    
                                <option value="1">No tiene</option>
                                <option value="2">Funciona</option>
                        </select><BR><BR>
                    </div>
                    <div id="accesorios" style="display:none;">
                        <br><h4 style="background:darkgrey; border 1px;border-radius:5px"><strong>Cubiertas y accesorios</strong></h4>
                        <h6>Kilometros de los neumáticos</h6>
                            <select class="col-lg-8" name="neuma" required>
                                <?php
                                $sql_cub = "SELECT * FROM cub_accesorios WHERE id_cliente='$id'";
                                $resultado_cub = mysqli_query($conn, $sql_cub) or die ('Error en el query database');
                                $fila_cub = mysqli_fetch_array($resultado_cub);
                                $id_cub = $fila_cub['id'];
                                if($fila_cub['km_gomas']==1)
                                {
                                  $value = "0 a 20.000 km";
                                }
                                elseif($fila_cub['km_gomas']==2)
                                {
                                  $value = "De 20.000 a 40.000 km";
                                }
                                elseif($fila_cub['km_gomas']==3)
                                {
                                  $value = "Mas de 40.000 km";
                                }
                                elseif($fila_cub['km_gomas']==4)
                                {
                                  $value = "No sabe";
                                }
                              ?>
                                <option value="<?php echo $fila_cub['km_gomas'];?>"><?php echo $value;?></option>    
                                <option value="1">de 0 a 20.000 km</option>
                                <option value="2">de 20.000 a 40.000 km</option>
                                <option value="3">Mas de 40.000 km</option>
                                <option value="4">No sabe</option>
                            </select><BR><BR>
                        <h6>Llantas o tasas</h6>
                            <select class="col-lg-8" name="llantas" required>
                                <?php
                         
                                if($fila_cub['llantas_tasas']==1)
                                {
                                  $value = "En perfecto estado";
                                }
                                elseif($fila_cub['llantas_tasas']==2)
                                {
                                  $value = "Levemente rayadas";
                                }
                                elseif($fila_cub['llantas_tasas']==3)
                                {
                                  $value = "Muy golpeadas";
                                }
                                
                              ?>
                                <option value="<?php echo $fila_cub['llantas_tasas'];?>"><?php echo $value;?></option>    
                                <option value="1">En perfecto estado</option>
                                <option value="2">Levemente rayadas</option>
                                <option value="3">Muy golpeadas</option>
                            </select><br><br>
                        <h6>LLave comando, segunda llave, rueda de auxilio y llave cruz/cricket</h6>
                            (Seleccionar lo que no anda o no tiene)
                            </select><BR>
                             <?php
                              if ($fila_cub["llave_comando"] <> "si")
                              {
                              ?>
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="llave_c" checked>LLave comando</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="llave_c">LLave comando</label><br>
                              <?php
                              }
                              ?>
                              <?php
                              if ($fila_cub["segunda_llave"] <> "si")
                              {
                              ?>
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="llave_2" checked>Segunda llave</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="llave_2">Segunda llave</label><br>
                              <?php
                              }
                              ?>
                              <?php
                              if ($fila_cub["auxilio"] <> "si")
                              {
                              ?>
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="auxilio" checked>Rueda de auxilio</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="auxilio">Rueda de auxilio</label><br>
                              <?php
                              }
                              ?>
                               <?php
                              if ($fila_cub["cruz"] <> "si")
                              {
                              ?>
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="cruz" checked>LLave cruz</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="cruz">LLave cruz</label><br>
                              <?php
                              }
                              ?>
                               <?php
                              if ($fila_cub["cricket"] <> "si")
                              {
                              ?>
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="cricket" checked>Cricket</label><br>
                              <?php
                              }
                              else 
                              {
                              ?>    
                                <label><input name="llave[]" type="checkbox" class="checkbox" id="llave" value="cricket">Cricket</label><br>
                              <?php
                              }
                              ?>
                            <h6>Observaciones</h6>
                            <textarea name="obs" style="float: left;width: 100%;min-height:75px;outline: none;resize: none;border: 1px solid grey;"><?php echo $fila_cub['obs']?></textarea>
                    </div>
                    
                    <!--<input id="mySubmit" class="btn btn-light" disabled="disabled" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Continuar"/>-->
                    <a href="javascript: history.go(-1)">
                            <button type="button" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs">Atrás
                            </button>
                        </a>
                    <input id="mySubmit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" type="submit" name="sub" value="Guardar cambios"/>
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
