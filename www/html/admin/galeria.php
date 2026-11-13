<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es"> 
<head>    
 <title>GALERIA DINÁMICA</title>         
 <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />     
 <script type="text/javascript" src="js/prototype.js"></script>
 <script type="text/javascript" src="js/effects.js"></script>
 <script type="text/javascript" src="js/builder.js"></script>
 <script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
 <script type="text/javascript" src="js/lightbox.js"></script>  
 <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" /> 
</head>       
<body>  
<h1>Galeria Dinámica</h1>
<div id="galeria">
<?php 
 //extensiones validas 
 $arr_ext=array("jpg","png","gif"); 
 //directorio donde se encuentran 
 $mydir=opendir("imagenes/"); 
 //leer archivos 
 while($archivo=readdir($mydir)) 
 { 
 $ext=substr($archivo,-3); 
 //si la extension del archivo es correcta muestra la imagen 
 if(in_array($ext,$arr_ext)) 
 { 
 echo '<a href="imagenes/'.$archivo.'" rel="lightbox[roadtrip]" title="Titulo de la imagen.'.'"><img src="imagenes/'.$archivo.'" alt="Descripcion imagen"/></a>'; 
 } 
 }
?> 
</div>          
</body> 
</html>