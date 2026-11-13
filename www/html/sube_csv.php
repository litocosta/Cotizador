<?php
require_once __DIR__ . '/config.php';
    //$csv = $_GET['archivo'];
    //echo 'Archivo CSV '.$csv;
    # conectare la base de datos
    function sube($archivo)
    {
        $con=@mysqli_connect(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
        if(!$con){
            die("imposible conectarse: ".mysqli_error($con));
        }
        if (@mysqli_connect_errno()) {
            die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
        }
        
        //$productos = fopen ("products.csv" , "r" );//leo el archivo que contiene los datos del producto
        $productos = fopen ($archivo , "r" );//leo el archivo que contiene los datos del producto
        while (($datos =fgetcsv($productos,1000,",")) !== FALSE )//Leo linea por linea del archivo hasta un maximo de 1000 caracteres por linea leida usando coma(,) como delimitador
        {
            $linea[]=array('id_usados_proyaut'=>$datos[0],'empresa'=>$datos[1],'descripcion'=>$datos[2],'anio'=>$datos[3],'color'=>$datos[4],
                    'km'=>$datos[5],'valor_sugerido'=>$datos[6],'id_cotizados'=>$datos[7],'ubicacion'=>$datos[8],'patente'=>$datos[9],'tipousado'=>$datos[10]);//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
        }
        fclose ($productos);//Cierra el archivo
    
        $ingresado=0;//Variable que almacenara los insert exitosos
        $error=0;//Variable que almacenara los errores en almacenamiento
        $duplicado=0;//Variable que almacenara los registros duplicados
        foreach($linea as $indice=>$value) //Iteracion el array para extraer cada uno de los valores almacenados en cada items
        {
            $id_usados_proyaut=$value["id_usados_proyaut"];//Codigo del producto
            $empresa=$value["empresa"];//fabricante del producto
            $descripcion=$value["descripcion"];//descripcion del producto
            $anio=$value["anio"];
            $color=$value["color"];
            $km=$value["km"];
            $valor_sugerido=$value["valor_sugerido"];
            $id_cotizados=$value["id_cotizados"];
            $ubicacion=$value["ubicacion"];
            $patente=$value["patente"];
            $tipousado=$value["tipousado"];

            //$insert = "insert into usados (id_usados_proyaut, empresa, descripcion, anio, color, km, valor_sugerido, id_cotizados, ubicacion, patente, tipousado) 
            //        values('$id_usados_proyaut','$empresa','$descripcion','$anio','$color','$km','$valor_sugerido','$id_cotizados','$ubicacion','$patente','$tipousado')";
            //$insert = "insert into usados (id_usados_proyaut, empresa, descripcion, anio, color, km, valor_sugerido, id_cotizados, ubicacion, patente, tipousado) 
            //        values('$id_usados_proyaut','$empresa','$descripcion','$anio','$color','$km','$valor_sugerido','$id_cotizados','$ubicacion','$patente','$tipousado')";
           // mysqli_query($con,$insert);
            echo "inserto";
        };
    };
	?>