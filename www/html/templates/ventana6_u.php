<script languaje="javascript">


function envia(num,nome,cata,color,pedido,serie,stock)
{

opener.document.form1.id_auto.value = num;
opener.document.form1.catalogo.value = cata;
opener.document.form1.modelo.value = nome;
opener.document.form1.colorito.value = color;
opener.document.form1.pedido.value = pedido;
opener.document.form1.serie.value = serie;
opener.document.form1.stock.value = stock;
opener.document.form1.ano.value = '2016';
close();
}

function trae()
{
	var form = document.getElementById("form-id");
	document.getElementById("your-id").addEventListener("click", function () {
  	form.submit();
});
}
</script>

<?php
require_once __DIR__ . '/../config.php';
include 'php_conexion.php';
include('contra.php');
$db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), $contra, cotizador_config('DB_NAME_5'));
$cola5="select * from stock_usados";
	$res5=$db->query($cola5);
	$cuenta = 0;
	$orden = 2;
	$bande = 0;
	while($resultado5 = $res5->fetch_array())
	{
		$mystring = $resultado5['marca_modelo'];
		$findme   = '-';
		$pos = strpos($mystring, $findme);
		//echo $pos;
		$catalogo = substr($mystring, 0, $pos);
		$buscar_marca = substr($mystring, $pos+1);
		$findme   = ' ';
		$pos = strpos($buscar_marca, $findme);
		$marca = substr($buscar_marca, 0, $pos);
		$auto = "select * from marca where auto = '$marca'";
			$busca = $db->query($auto);
			//echo $db->affected_rows; 
			if ($db->affected_rows <= 0)
			{
				if ($marca == 'FORD')
				{
					$guarda = "insert into marca(auto,orden) values ('$marca','1')";
					$res_auto = $db->query($guarda);
				}
				else
				{
					$guarda = "insert into marca(auto,orden) values ('$marca','$orden')";
					$res_auto = $db->query($guarda);
					$orden++;
				}
				
				$cuenta ++;	
			}
	}
?>
<form id="form-id" action="" method="post">
	<input type="radio" name="global" value="nada" hidden checked>
	<?php
	$auto = "select * from marca where auto = '$marca'";
	$res5=$db->query($cola5);
	while($resultado5 = $res5->fetch_array())
	{
	?>	
	<input type="radio" onclick="document.getElementById('form-id').submit();" name="global" value="<?php echo $resultado5['auto']; ?>"><?php echo $resultado5['auto']; ?>
	<?php

	}
	?>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{  
	$auto = $_POST["global"];
	echo $auto;
	$sql = "SELECT * FROM stock WHERE marca_modelo LIKE '%$auto%'";
	$result = mysql_query($sql,$con);
	echo '<br>';
	echo "<table border='1'>";
	echo '<tr><td>CATALOGO</td><td>MODELO</td><td>COLOR</td><td>SERIE</td><td>PEDIDO</td><td>STOCK</td><td>SELECIONAR</td></TR>';
	while ($row = mysql_fetch_array($result))
	{
		$mystring = $row['marca_modelo'];
		$findme   = '-';
		$pos = strpos($mystring, $findme);
		//echo $pos;
		$catalogo = substr($mystring, 0, $pos);
		//echo $catalogo;

		$cuenta = count($mystring);
		$nombre = substr($mystring, $pos+1);
		//echo $nombre;
		?>
		<form enctype="multipart/form-data" name="form2">
		<?php echo '<tr><td>'.$catalogo.'</td><td>'.$nombre.'</td><td>'.$row["color"].'</td><td>'.$row["serie"].'</td>
		<td>'.$row["pedido"].'</td><td>'.$row["codigo"].'</td><td>'?>
		<a href="#" onclick="envia(<?php print $row["id"]; ?>, 
								  '<?php print $nombre; ?>', 
								  '<?php print $catalogo; ?>',
								  '<?php print $row["color"]; ?>',
								  '<?php print $row["serie"]; ?>',
								  '<?php print $row["pedido"]; ?>',
								  '<?php print $row["codigo"]; ?>');"

		>enviar</td></tr>
		</a>
		</form>

	<?php
	}
	echo '</table>';
}
?>
