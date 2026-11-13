<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Editar</title>
	<script type="text/javascript" src="js/modificarEstiloInputFile.js"></script>
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<h1>Modificar Invenrtario Nº: {$bienes.numero}</h1>
		<div id="imagen">
			<form id="margen" action="editar.php" method="post">
				<label for="numero">Inventario</label><br>
				<input type="hidden" id="id" name="id" value="{$bienes.id}"/>
				<input type="text" name="numero" class="inputImagen" id="numero" value='{$bienes.numero}' readonly><br><br><br>
				<label for="numero">Detalle</label><br>
				
				<textarea type="text" name="detalle" rows="5" cols="40" class="inputImagen" id="detalle" ><?php echo($bienes.detalle); ?></textarea>
				<!--<input type="text" name="detalle" class="inputImagen" id="detalle" value='{$bienes.detalle}'><br><br><br>-->
				<input type="submit" value="Editar Usuario" class="botonInputFileModificado1"/>
				<input type="submit" value="Cerrar" onclick="window.close()" class="botonInputFileModificado1"/>
			</form>
			<!--<form action="salir.php" method="post">
				<input type="submit" value="Salir" class="botonInputFileModificado1"/>
			</form>-->
		</div>
</body>
</html>