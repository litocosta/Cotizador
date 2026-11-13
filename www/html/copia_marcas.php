<?php
require_once __DIR__ . '/config.php';
 
      //$usuario = $_SESSION["admin"];
      $servername = cotizador_config('DB_HOST');
      $database = cotizador_config('DB_NAME');
      $username = cotizador_config('DB_USER');
      $password = cotizador_config('DB_PASSWORD');
      $conn = mysqli_connect($servername, $username, $password, $database);
      $sql = "SELECT * FROM acara ORDER BY marca";
      $marca = '';
      $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
      while($fila = mysqli_fetch_array( $resultado ) )
        {
            echo $fila['marca'].'<BR>';
            if($marca <> $fila["marca"])
            {
                $marca = $fila["marca"];
                echo "Variable es: ".$marca."<BR>";
                $up = "INSERT INTO marcas (marca) VALUE ('$marca')";
                mysqli_query($conn, $up);
            }
            
            
        }
      //$row = mysqli_fetch_array($resultado);
      //$nombre_usuario = $row["nombre"].' '.$row['apellido'];


?>
