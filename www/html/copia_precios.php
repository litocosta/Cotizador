<?php
require_once __DIR__ . '/config.php';
 
      //$usuario = $_SESSION["admin"];
      $servername = cotizador_config('DB_HOST');
      $database = cotizador_config('DB_NAME');
      $username = cotizador_config('DB_USER');
      $password = cotizador_config('DB_PASSWORD');
      $conn = mysqli_connect($servername, $username, $password, $database);
      //$sql = "SELECT * FROM acara WHERE id>0 AND id<10000";
      //$sql = "SELECT * FROM acara WHERE id>=10000 AND id<20000";
      $sql = "SELECT * FROM acara WHERE id>=20000  AND id<30000";
      //$sql = "SELECT * FROM acara WHERE id>=30000  AND id<40000";
      //$sql = "SELECT * FROM acara WHERE id>=40000  AND id<50000";
      //$sql = "SELECT * FROM acara WHERE id>=50000";
      $resultado = mysqli_query($conn, $sql) or die ('Error en el query database');
      while($fila = mysqli_fetch_array( $resultado ) )
      {
        $id = $fila["id"];
        if($fila['precio']==0.000)
          {
            //echo "Entro por cero".$fila['precio']."<BR>";  
            $numero_final = 0;
            echo "No tien precio: ".$numero_final." Marca: ".$fila['marca'].' '.$fila['modelo'].' '. $fila['version']."<BR>";
          }
          else
          {
            $entero = intval($fila['precio']);
            //echo "Moneda: ".$fila['moneda'];
            if($entero < 50 and $fila['moneda']=="$")
            {
              //$numero = settype($fila['precio'], 'string');
              $numero_cadena = strval($fila['precio']);
              //$numero_resta = substr($numero_cadena,0,-1);
              $numero_final = str_replace('.','',$numero_cadena);
              $num = $numero_final*2;
              echo "numero cambiado a cadena: ".$numero_final." Marca: ".$fila['marca'].' '.$fila['modelo'].' '. $fila['version']."<BR>";
              //var_dump($numero);
              

            }
            else
            {
              $numero_final = $entero;
              echo "Precio en dolares o menos de 1 millon de pesos: ".$numero_final." Marca: ".$fila['marca'].' '.$fila['modelo'].' '. $fila['version']."<BR>";
            }
            //echo $entero."<BR>";  
          }
          $up = "UPDATE acara SET precio_entero=$numero_final WHERE id=$id";
          $conn->query($up);
        }
      //$row = mysqli_fetch_array($resultado);
      //$nombre_usuario = $row["nombre"].' '.$row['apellido'];


?>
