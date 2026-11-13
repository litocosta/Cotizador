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

</style>


<body id="page-top">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    
  </nav>
	<section class="bg-primary text-white">
    <div class="container text-center">
		<div class="row">
			<div class="col-lg-8 mx-auto" style="margin-top:-4em">
          
               
                <h4 style="background:darkgrey; border: 1px;border-radius:5px"><strong>Peritaje</strong></h4>
                   
           
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
                        <input id="cotitu" type="radio" name="funcion" value="si">Si
                        <input id="cotitu" type="radio" name="funcion" value="no">No
                        
                        <h6>El motor presenta alguna falla?</h6>
                        <input id="uso" type="radio" name="falla" value="si">Si
                        <input id="uso" type="radio" name="falla" value="no">No
                        
                        <h6>La caja de cambios tiene algun desperfecto?</h6>
                        <input type="radio" name="caja" value="si" >Si
                        <input type="radio" name="caja" value="no">No
                        
                        <h6>Los frenos tienen alguna falla?</h6>
                        <input type="radio" name="frenos" value="si">Si
                        <input type="radio" name="frenos" value="no">No

                        <h6>La suspensión o el tren delantero hacen ruidos anormales?</h6>
                        <input type="radio" name="sus_tren" value="si">Si
                        <input type="radio" name="sus_tren" value="no">No
                        
                        <h6>Con el auto en marcha se prenden luces de advertencia?</h6>
                        <input type="radio" name="adver" value="si">Si
                        <input type="radio" name="adver" value="no">No
                        
                        <h6>Hay algun indicador del tablero que no funciona?</h6>
                        <input type="radio" name="indi" value="si">Si
                        <input type="radio" name="indi" value="no">No

                        <h6>Los airbags funcionan?</h6>
                            <input type="radio" name="airbag" value="si">Si
                            <input type="radio" name="airbag" value="no">No
                         <h6>El  ABS funciona?</h6>
                            <input type="radio" name="abs" value="si">Si
                            <input type="radio" name="abs" value="no">No
                    </div>
                   
                    
                    
                    <button id="btnRate" class="btn btn-light" style="font-size:1.5em;" data_but="btn-xs" name="Submit">Submit</button>
                    
                    <br><br>
                    <a href="">
                        <button type="button" style="background:#DE6B6C;color:white" class="btn btn-light" data_but="btn-xs">Volver al inicio
                        </button>
                    </a>
               
              
            </div>
        </div>
    </div>
    
	</section>
    <script>
        let btn = document.getElementById('btnRate');

        btn.addEventListener('click', () => {
            let rates = document.getElementsByName('funcion');
            rates.forEach((rate) => {
                if (rate.checked) {
                    alert(`You rated: ${rate.value}`);
                }
               
            })
        });
</script>