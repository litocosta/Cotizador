<?php
require_once __DIR__ . '/../config.php';
include('contra.php');
session_start();
$vari1 = ' ';
$vari2 = ' ';
$vari3 = ' ';
if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
    $sesion=$_SESSION["admin"];
    $db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), $contra, cotizador_config('DB_NAME_5'));
	$cola = "select * from usuarios where usuario='$sesion'";
	$res = $db->query($cola);
	$resultado = $res->fetch_array();
	$comple = $resultado['nombre'].' '.$resultado['apellido'];
?>   
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>ABM</title>
	<link rel="stylesheet" href="css/estilo.css">
	<SCRIPT Language=Javascript SRC="java.js">
	</SCRIPT>
	<script>
	var parametro;
	function popup()
	{
	parametro = window.open("ventana5.php","","width=400,height=300");
	//parametro.document.getElementById('form2').value = "num" ;
	//parametro.document.getElementById('form2').value = "valor" ;
	}
	</script>
</head>

<body>

    <h2></h2>
	<!--<h1>Clientes</h1>-->
	<br>
	
	<div id="login">
		Usuario: <?php  echo $comple;?> <a id="salir" href="salir.php">Cerrar Sesión</a>
	</div>
	<nav>
		<a id="volver" href="index.php">Volver al inicio</a>
	</nav>
	<h4>Propuesta</h4>
	Ingrese el Cliente:
	    <form name="form1" action="imprimir_propuesta2.php" method="post" id="margen" onkeyup="buscarDato(); return false">
		    <div id="operacion">
			<?php
						//$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), "", cotizador_config('DB_NAME_5'));
						$cola="select * from cliente where usuario='$sesion'";
						$res=$db->query($cola);
						
						echo "<select id='select2' onChange='cambia();' name='select2'>";
						echo "<option value='-1'></option>";
						while($resultado=$res->fetch_array())
						{
							/*header('Content-Type: text/html; charset=iso-8859-1');*/ 
							/*header('Content-Type: text/html; charset=utf8');*/
							echo utf8_encode("<option  name='inicia'  value='".$resultado['id']."'>".$resultado['nombre']." ".$resultado['apellido']."</option>");
						}
						echo "</select>";
						//echo "el cliente es: ".$_POST["select2"];
					?>
			</div><br>
			<div>
				<textarea COLS=40 ROWS=2 NAME="obs"></textarea>
			</div>

			
			<div id="agrega">
				<br><input type="submit" name="sub" disabled value="Imprimir"/> <a href="index.php">Cancelar</a><br><br>
			</div>
		</form>
		
<footer>
	Sistema de Gestión de Solicitud de Compras - Selva SA
	- Versión 1.0 -
</footer>
</body>
</html>