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
      $cod_personal = $row["cod_personal"];
      $fecha_actual = date("d-m-Y");
        //sumo 1 día
      $fecha_ven = date("Y-m-d h:i:s",strtotime($fecha_actual."+ 30 days")); 
      //echo "fecha vencimiento: ".$fecha_ven;
      $ano = $_POST['ano'];
      $marca = $_POST['marca'];
      $precio = $_POST['precio'];
      $modelo = $_POST['modelo'];
      $version = $_POST['version'];
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
      //  echo $moneda;
      $nom = $_POST['nom'];
      $ape = $_POST['ape'];
      $mail = $_POST['mail'];
      //$loc = $_POST['loca1'];
      if (!empty($_POST['loca1']))
      {
        $loc = $_POST['loca1'];
      }
      else
      {
          $loca1 = "";
      }
      if (!empty($_POST['key']))
      {
        $key = $_POST['key'];
      }
      else
      {
          $key = "";
      }
      /*if (!empty($_POST['loca1']))
      {
        $key = $_POST['key'];
      }*/

      /*$sql_loc = "SELECT * FROM municipios WHERE id='$loc'";
      $resultado_loc = mysqli_query($conn, $sql_loc) or die ('Error en el query database');
      $row_loc = mysqli_fetch_array($resultado_loc);
      echo "<br>Busqueda: ".mysqli_num_rows($resultado_loc);
      $loc = $row_loc['localidad'];*/
      if (!empty($_POST['pro']))
      {
        $pro = $_POST['pro'];  
        $sql_pro = "SELECT * FROM provincias WHERE codigo='$pro'";
        $resultado_pro = mysqli_query($conn, $sql_pro) or die ('Error en el query database');
        $row_pro = mysqli_fetch_array($resultado_pro);
        $pro = $row_pro['nombre'];
      }
      else
      {
        $pro = "";
      }
      
      
      
      $pat = $_POST['pat'];
      $kil = $_POST['kil'];
      $col = $_POST['color'];
      $pais = $_POST['pais'];
      $area = $_POST['area'];
      $cel = $_POST['cel'];
      $cel_completo =$pais.$area.$cel;
      $cotitu = $_POST['cotitu'];
      $uso = $_POST['uso'];
      $asientos = $_POST['asientos'];
      $combustible = $_POST['combustible'];
      $cilin = $_POST['cilin'];
      $trans = $_POST['trans'];
      $prenda = $_POST['prenda'];
      $gnc = $_POST['gnc'];
      //$entrega = $_POST['entrega'];
      $entrega = 1;
      if (!empty($_POST['tel']))
      {
        $tel = $_POST['tel'];  
      }
      else
      {
          $tel = "";
      }
      
      $dni = $_POST['dni'];
      $servername = cotizador_config('DB_HOST');
      $database = cotizador_config('DB_NAME');
      $username = cotizador_config('DB_USER');
      $password = cotizador_config('DB_PASSWORD');
      $precio_info_dto = $precio-($precio*15/100);
      $precio_dto1000 = $precio_info_dto*1000*$valor_dolar;
      $precio_1000 = $precio*1000*$valor_dolar; 
            // Create connection
      $conn = mysqli_connect($servername, $username, $password, $database);
      // Check connection
      if (!$conn) 
      {
        die("Connection failed: " . mysqli_connect_error());
      }
      else
      {
        
        //echo "Connected successfully<br>";
        
        //$sql = "INSERT INTO cotizados (nombre) 
        //        VALUES ('$nom')";
        $busca_patente = "SELECT * FROM cotizados WHERE patente='$pat'";
        $query_patente = mysqli_query($conn, $busca_patente) or die ('Error en el query database');
        if(mysqli_num_rows($query_patente) <= 0)
        {

            $noencuentra =0;
             $sql = "INSERT INTO cotizados (nombre, apellido, email, ciudad, provincia, patente, kilometros, cotitular, tax_rem_uber, prendado, entrega, telefono,
            celular, dni, marca, modelo, version, ano, precio_info, fecha_vencimiento, precio_info_dto, usuario, color, asientos, combustible, transmision, cilindrada, gnc) 
            VALUES ('$nom', '$ape', '$mail', '$key', '$pro', '$pat', '$kil', '$cotitu', '$uso',  '$prenda', '$entrega', '$tel', '$cel_completo','$dni', '$marca', 
            '$modelo', '$version', '$ano', '$precio_1000', '$fecha_ven', '$precio_dto1000', '$usuario', '$col', '$asientos', '$combustible', '$trans', '$cilin', '$gnc')";
             if (mysqli_query($conn, $sql)) 
             {
                //echo "Datos guardados";
                
                //printf ("Nuevo registro con el id %d.\n", mysqli_insert_id($conn));
                $id_cliente = mysqli_insert_id($conn);
                //echo "ENTYRO";


            } 
            else 
            {
                echo "no ENTRO";   
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        }
        else
        {
            $noencuentra = 1;
        }
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
<style type="text/css">
.radio {
	width: 1.5em;
    height: 1.5em;
    margin-left:1em;
	}
</style>

<body id="page-top">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top"><strong>MONTIRONI</strong></a>
      <h6 style="color:white">Usuario:<?php echo $noencuentra.' '.$nombre_usuario; ?>
			<a id="salir" style="margin-left:1em;"  href="salir.php">Cerrar Sesión</a></h6>
    </div> 
  </nav>
	<section class="bg-primary text-white">
    <div class="container text-center">
		<div class="row">
			<div class="col-lg-8 mx-auto" style="margin-top:-4em">
            <?php
            if($noencuentra == 0)
            {
            ?>
            <form action="cotiz_ext.php" method="POST"> 
               
                <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
                    <?php
                    
                        $conn = mysqli_connect($servername, $username, $password, $database);
                        $sql = "SELECT nombre, apellido, marca, modelo, version, ano, precio_info FROM cotizados WHERE id = $id_cliente";
                        //echo $id_cliente;
                        $resultado = mysqli_query($conn, $sql) or die ('Error en el query 2 database');
                        while ($fila = mysqli_fetch_array( $resultado ))
                        {
                            $cliente = $fila["apellido"].' '.$fila["nombre"];
                            $auto = $fila["marca"].' '.$fila["modelo"].' '.$fila["version"].' modelo '.$fila["ano"];
                        }

                        ?>
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
                    <input hidden type="text" name="id" value="<?php echo $id_cliente; ?>"/>
                    <input hidden type="text" name="ano" value="<?php echo $ano; ?>"/>
                    <input hidden type="text" name="cliente" value="<?php echo $cliente; ?>"/>
                    <input hidden type="text" name="auto" value="<?php echo $auto; ?>"/>
                    <input hidden type="text" name="cod" value="<?php echo $cod_personal; ?>"/>
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
                    <div>
                         <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Funcionamiento</strong></h4>
                        <h6>El auto funciona correctamente?</h6>
                        <input id="cotitu" type="radio" class="radio" name="funcion" value="si" required>Si
                        <input id="cotitu" type="radio" class="radio" name="funcion" value="no" required>No
                        
                        <h6>El motor presenta alguna falla?</h6>
                        <input id="uso" type="radio" class="radio" name="falla" value="si" required>Si
                        <input id="uso" type="radio" class="radio" name="falla" value="no" required>No
                        
                        <h6>La caja de cambios tiene algun desperfecto?</h6>
                        <input type="radio" class="radio" name="caja" value="si" required>Si
                        <input type="radio" class="radio" name="caja" value="no" required>No
                        
                        <h6>Los frenos tienen alguna falla?</h6>
                        <input type="radio" class="radio" name="frenos" value="si" required>Si
                        <input type="radio" class="radio" name="frenos" value="no" required>No

                        <h6>La suspensión o el tren delantero hacen ruidos anormales?</h6>
                        <input type="radio" class="radio" name="sus_tren" value="si" required>Si
                        <input type="radio" class="radio" name="sus_tren" value="no" required>No
                        
                        <h6>Con el auto en marcha se prenden luces de advertencia?</h6>
                        <input type="radio" class="radio" name="adver" value="si" required>Si
                        <input type="radio" class="radio" name="adver" value="no" required>No
                        
                        <h6>Hay algun indicador del tablero que no funciona?</h6>
                        <input type="radio" class="radio" name="indi" value="si" required>Si
                        <input type="radio" class="radio" name="indi" value="no" required>No

                        <h6>Los airbags funcionan?</h6>
                            <input type="radio" class="radio" name="airbag" value="si" required>Si
                            <input type="radio" class="radio" name="airbag" value="no" required>No
                         <h6>El  ABS funciona?</h6>
                            <input type="radio" class="radio" name="abs" value="si" required>Si
                            <input type="radio" class="radio" name="abs" value="no" required>No
                    </div>
                 
                    <input type="submit" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit" value="avanzar" />
                    
                    </a><br><br>
                    <a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
                </form>
                <?php
                    }
                    else
                    {
                        echo "<h4>patente existente</h4>";
                        ?>
                        <a href="index.php">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
                    <?php
                    }
                ?>
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
             
            </div>
        </div>
    </div>
    
	</section>