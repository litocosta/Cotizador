<?php
			 echo 'Hola'.date('Y');
			?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>ABM</title>
	<link rel="stylesheet" href="css/estilo.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/codi.js"></script>	
</head>
<body>
	<h2></h2>
	<!--<h1>Solicitud de Compra</h1>-->
	<br>
	<div id="login">
		Usuario:
		{foreach name=valorar from=$valor item=valores}
			{$valores.nombre}{' '}{$valores.apellido}
		{/foreach}
		<a id="salir" href="salir.php">Cerrar Sesión</a>
		<br>

	</div>
	<div id="servicios">
		<div id="clientes">
			<div id="pri_c">
			<?php
			 echo 'Hola'.date('Y');
			?>
			<a href="servicios.php?turno=martin&nuevo_ano='<?php date(Y); ?>'&nuevo_mes=<?php date(m); ?>">
			<figure>
				<img src="imagenes/clientes.png" width="150" height="150" />
				<figcaption>Martin</figcaption>
			</figure></a>
		</div>
		<div id="clientes">
			<div id="pri_c">
			<a href="servicios.php?turno='lopez'">
			<figure>
				<img src="imagenes/clientes.png" width="150" height="150" />
				<figcaption>Lopez</figcaption>
			</figure></a>
		</div>
	
	</div>
	
</body>
<footer>
	Sistema de Gestión de Solicitud de Turnos de Servicios - Selva SA
	- Versión 1.0 -
</footer>
</html>