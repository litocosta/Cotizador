 <?php
require_once __DIR__ . '/config.php';
    
     /* require_once 'HTTP/Request2.php';
      include 'genera_token.php';
      
      
      $request = new HTTP_Request2();
      $request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/');
      $request->setMethod(HTTP_Request2::METHOD_GET);
      $request->setConfig(array(
        'follow_redirects' => TRUE
      ));
      $request->setHeader(array(
        'Authorization' => 'Bearer '.$token,
        'Accept' => 'application/vnd.gestion.online+json',
        'X-Force-Content-Type' => 'application/json'
      ));

      try {
        $response = $request->send();
        if ($response->getStatus() == 200) 
        {
  
          $muestra = $response->getbody();
          echo $muestra."<br>";
          $total_caracteres = strlen($muestra);
          $muestra = substr($muestra,1,$total_caracteres-3);
          //echo $muestra."<br>";
          //echo $total_caracteres."<br>";
          $cursor = 0;
          //$inicio = '[';
          //$fin = ']';
          $corchete_i = '{';
          $corchete_f = '}';
         // $busca_id = 'id';
          //$busca_nombre = 'name';
          //$busca_coma = ',';
          //$busca_dospuntos = ':';
          //$salida = true;
          //echo $_POST['titular'];
          //echo $_POST['cotitu'];
         
          //  echo'<input hidden name="id_cliente" value="'.$id_cliente.'">';
           
              while ($cursor < $total_caracteres-2)
              {
                $principio_registro = strpos($muestra,$corchete_i,$cursor);
                $fin_registro = strpos($muestra,$corchete_f,$cursor);
                //echo '<BR>Principio: '.$principio_registro;
               // echo '<BR>Fin: '.$fin_registro;
                $registro = substr($muestra,$cursor,($fin_registro-$principio_registro)+1);
                //echo "<BR>El registro es: ".$registro.'<BR> ';
                $obj = json_decode($registro);
                //echo '<option value="'.$obj->{'id'}.' '.$obj->{'name'}.'">'.$obj->{'name'}.'</option>';
                print $obj->{'name'}; // 12345
                $cursor = $fin_registro+2;
              }
          
          
        }
        else 
        {
          echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
          $response->getReasonPhrase();
        }
      }
      catch(HTTP_Request2_Exception $e) {
        echo 'Error: ' . $e->getMessage();
      }*/
     
      require_once 'HTTP/Request2.php';
      include 'genera_token.php';
      
      
      $request = new HTTP_Request2();
      $request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/');
      $request->setMethod(HTTP_Request2::METHOD_GET);
      $request->setConfig(array(
        'follow_redirects' => TRUE
      ));
      $request->setHeader(array(
        'Authorization' => 'Bearer '.$token,
        'Accept' => 'application/vnd.gestion.online+json',
        'X-Force-Content-Type' => 'application/json'
      ));

      try 
      {
        $response = $request->send();
        if ($response->getStatus() == 200) 
        {
  
          $muestra = $response->getbody();
          echo $muestra."<br>";
        
        }
        else 
        {
          echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
          $response->getReasonPhrase();
        }
       }
       catch(HTTP_Request2_Exception $e) {
        echo 'Error: ' . $e->getMessage();
      }
        //$jsonFile = fopen("marcas.json", 'w') or die("Se produjo un error al crear el archivo");
      $jsonFile="marcas1.json";
      
        $jsondata = file_get_contents($jsonFile);
        $data = json_decode($jsondata, true);

        $array_data = $data['marcas'];

        $servername = cotizador_config('DB_HOST');
        $username = cotizador_config('DB_USER');
        $password = cotizador_config('DB_PASSWORD');
        $dbname = cotizador_config('DB_NAME');

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        foreach ($array_data as $row) {
            $sql = "INSERT INTO marcas (marca, id_marca) VALUES ('" . $row["name"] . "', '" . $row["id"] . "')";
            $conn->query($sql);
        }
     
        $conn->close();
    
?>