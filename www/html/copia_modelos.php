<?php
require_once __DIR__ . '/config.php';
 
      //$usuario = $_SESSION["admin"];
      $servername = cotizador_config('DB_HOST');
      $database = cotizador_config('DB_NAME');
      $username = cotizador_config('DB_USER');
      $password = cotizador_config('DB_PASSWORD');
      $conn = mysqli_connect($servername, $username, $password, $database);
      $sql = "SELECT * FROM acara ORDER BY modelo";
      $modelo = '';
      $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
      while($fila = mysqli_fetch_array( $resultado ) )
        {
            echo $fila['modelo'].'<BR>';
            if($modelo <> $fila["modelo"])
            {
                $modelo = $fila["modelo"];
                $marca = $fila["marca"];
                $sqlMarca = "SELECT * FROM marcas WHERE marca = '$marca'";
                $resultado1 = mysqli_query($conn, $sqlMarca);
                $resultado_marca = mysqli_fetch_array($resultado1);
                //echo 

                $id_marca = $resultado_marca['id'];
                echo "Variable es: ".$modelo."<BR>";
                echo "Variable2 es: ".$marca."<BR>";
                echo "Variable2 es: ".$id_marca."<BR>";
                $up = "INSERT INTO modelos (modelo, id_marca) VALUE ('$modelo', '$id_marca')";
                mysqli_query($conn, $up);
            }
            
            
        }
      //$row = mysqli_fetch_array($resultado);
      //$nombre_usuario = $row["nombre"].' '.$row['apellido'];


?>
