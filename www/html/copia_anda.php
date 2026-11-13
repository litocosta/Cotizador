 <?php
require_once __DIR__ . '/config.php';
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
          //echo $muestra."<br>";
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
  
    $comienzo = '{"marcas":';
    $final = ',"StartTime":"2016-11-05 07:20:34","EndTime":"2016-11-05 07:20:34"}';
    //$jsonFile="marcas.json";
    $jsonFile = fopen("marcas1.json", 'w') or die("Se produjo un error al crear el archivo");
    fwrite($jsonFile, $comienzo) or die("No se pudo escribir en el archivo");
    fwrite($jsonFile, $muestra) or die("No se pudo escribir en el archivo");
    fwrite($jsonFile, $final) or die("No se pudo escribir en el archivo");
    fclose($jsonFile);
    $jsonFile = "marcas1.json";
    $jsondata = file_get_contents($jsonFile);
    $data = json_decode($jsondata, true);
    //echo "DATA ".$data;
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
    $sql = "TRUNCATE TABLE marcas";
    $conn->query($sql);
    $sql = "TRUNCATE TABLE grupos";
    $conn->query($sql);
    $sql = "TRUNCATE TABLE versiones";
    $conn->query($sql);
    foreach ($array_data as $row) {
        $sql = "INSERT INTO marcas (marca, id_marca) VALUES ('" . $row["name"] . "', '" . $row["id"] . "')";
        $conn->query($sql);
    }


    $conn->close();
    //echo "HOLA";
    $mysqli = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
    $sql = "SELECT * FROM marcas";
    $resultado = $mysqli->query($sql);
    //echo $resultado;
    $comienzo = '{"grupos":';
    //$final = ',"StartTime":"2016-11-05 07:20:34","EndTime":"2016-11-05 07:20:34"}';
    while($row = $resultado->fetch_array())
    {
        $request = new HTTP_Request2();
       
        $request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/'.$row['id_marca'].'/groups/');
        //$request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/'.$row['id_marca'].'/groups/');
        $id_marca = $row['id_marca'];
        //$request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/18/groups/');
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            //'Authorization' => cotizador_config('INFOAUTO_AUTHORIZATION'),
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/vnd.gestion.online+json',
            'X-Force-Content-Type' => 'application/json'
        ));
        try 
        {
            $response = $request->send();
            if ($response->getStatus() == 200) 
            {
            //echo "MICHOTA<BR>";
            $muestra = $response->getbody();
            //echo $muestra."<br>";
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
        $jsonFile = fopen("grupos.json", 'w') or die("Se produjo un error al crear el archivo");
        fwrite($jsonFile, $comienzo) or die("No se pudo escribir en el archivo");
        fwrite($jsonFile, $muestra) or die("No se pudo escribir en el archivo");
        fwrite($jsonFile, $final) or die("No se pudo escribir en el archivo");
        fclose($jsonFile);
        $jsonFile = "grupos.json";
        $jsondata = file_get_contents($jsonFile);
        $data = json_decode($jsondata, true);
        //echo "DATA ".$data;
        $array_data = $data['grupos'];
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
        //$sql = "TRUNCATE TABLE ";
        //$conn->query($sql);
        foreach ($array_data as $row) {
            $sql = "INSERT INTO grupos (grupo, id_grupo, id_marca) VALUES ('" . $row["name"] . "', '" . $row["id"] . "', '" . $id_marca . "')";
            $conn->query($sql);
        }
    }


    $sql = "SELECT * FROM marcas";
    $resultado = $mysqli->query($sql);
    //echo $resultado;
    
    //$final = ',"StartTime":"2016-11-05 07:20:34","EndTime":"2016-11-05 07:20:34"}';
    while($row = $resultado->fetch_array())
    {
        $id_marca = $row["id_marca"];
        echo "Cantidads de marcas encontrados: ".$resultado->num_rows.'<BR>';
        echo "Id marca es: ".$id_marca.'<BR>';
        $sql_grupo = "SELECT * FROM grupos WHERE id_marca='$id_marca'";
        $resultado_grupo = $mysqli->query($sql_grupo);
        $comienzo = '{"versiones":';
        while($row_grupo = $resultado_grupo->fetch_array()){
            $id_grupo = $row_grupo["id_grupo"];
            echo "Cantidads de grupos encontrados: ".$resultado_grupo->num_rows.'<BR>';
            
            echo "Id grupo es: ".$id_grupo;
            $request = new HTTP_Request2();
            $request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/'.$id_marca.'/groups/'.$id_grupo.'/models/');
            //$request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/18/groups/16/models/');
            $request->setMethod(HTTP_Request2::METHOD_GET);
            $request->setConfig(array(
                'follow_redirects' => TRUE
            ));
            $request->setHeader(array(
                //'Authorization' => cotizador_config('INFOAUTO_AUTHORIZATION'),
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/vnd.gestion.online+json',
                'X-Force-Content-Type' => 'application/json'
            ));
            try 
            {
                $response = $request->send();
                if ($response->getStatus() == 200) 
                {
                //echo "MICHOTA<BR>";
                $muestra = $response->getbody();
                //echo $muestra."<br>";
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
            
            $muestra = $response->getbody();
          $total_caracteres = strlen($muestra);
          $json = substr($muestra,1,$total_caracteres-3);
          
          //$json ='{"as_codia":true,"brand":{"id":1,"name":"ACURA"},"codia":10001,"description":"INTEGRA LS SM","group":{"id":1,"name":"INTEGRA"},"list_price":false,"photo_url":"https://storage.googleapis.com/preciosa-staging-cars-images/78092543-b34f-4886-976e-1b966d8d377c.jpg","position":1,"prices":true,"prices_from":1992,"prices_to":1997,"r_codia":null,"summary":""},{"as_codia":true,"brand":{"id":1,"name":"ACURA"},"codia":10003,"description":"INTEGRA RS SM","group":{"id":1,"name":"INTEGRA"},"list_price":false,"photo_url":null,"position":2,"prices":true,"prices_from":1992,"prices_to":1997,"r_codia":null,"summary":""}';
          //echo $json."<br>";
          $fin = '},{';
          $busco = strpos($json, $fin, 0);
          $bandera = true;
          //echo '<BR>Busco: '.$busco;
          if ($busco=='')
          {
            $registro = substr($json,0);  
          }
          else {
            $registro = substr($json,0,$busco+1);  # code...
          }
          
          echo '<BR>REgistro: '.$registro;
          $obj = json_decode($registro);
          $nombre = $obj->{'brand'}->{'name'};
          
          while($bandera or strlen($registro) > 6 )
          {
            if($bandera)
            {
              echo 'entro por bandera verdad<BR>';
              $restito = substr($json,$busco+2);
            }
            //echo 'Bandera: '.$bandera;
            $bandera = false;
            
            //echo '<BR>REgistro: '.$registro;
            
           // echo '<BR><BR>REstito: '.$restito;
            $obj = json_decode($registro);
            echo $obj->{'codia'}.'Marca: '.$nombre.' Modelo: '.$obj->{'description'}.' Id marca: '.$obj->{'brand'}->{'id'}.' Id grupo: '.$obj->{'group'}->{'id'}.'<BR>';
            //print '<BR><BR>'.$obj->{'codia'}.' '.$obj->{'description'}.'<BR>';
            $sql = "INSERT INTO versiones (versio, id_grupo, id_marca, codia) 
                VALUES ('" . $obj->{'description'} . "', '" . $obj->{'group'}->{'id'} . "', '" . $obj->{'brand'}->{'id'} . "', '" . $obj->{'codia'} . "')";
            $conn->query($sql);
            $busco = strpos($restito, $fin, 0);
            $registro = substr($restito,0,$busco+1);
            $restito = substr($restito,$busco+2);
            //echo 'largo registro: '.strlen($registro);
            //echo '<BR>Busco: '.$busco;
           
          }
            
            
           
                // $nombre = $row->{'brand'}->{'name'};
                // echo $nombre;
                 //$codia = $data->{'codia'};
               // echo $codia;
                //$sql = "INSERT INTO versiones (versio, id_grupo, id_marca, id_version) VALUES ('" . $row["name"] . "', '" . $id_grupo . "', '" . $id_marca . ", '" . $row["id"] . "')";
                //$conn->query($sql);
           
        }
    }

    $curl = curl_init();
    
    //$recibido = $_POST['id_version'];
    //$num_espacio = strpos($recibido,' ',0);
    //$marca = substr($recibido,$num_espacio);
    
    //$id = substr($recibido,0,$num_espacio);
    
    curl_setopt_array($curl, array(
    //CURLOPT_URL => "https://demo.api.infoauto.com.ar/cars/pub/models/".$id."/prices",
    CURLOPT_URL => "https://demo.api.infoauto.com.ar/cars/pub/models/180594/prices",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$token.'',
        cotizador_config('INFOAUTO_COOKIE')
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo "Esto es todo: ".$response;
    $total_caracteres = strlen($response);
    $json = substr($response,1,$total_caracteres-3);
    $fin = '},{';
    $busco = strpos($json, $fin, 0);
    //echo '<BR>Busco: '.$busco;
    $registro = substr($json,0,$busco+1);
    //echo '<BR>REgistro: '.$registro;
    $obj = json_decode($registro);

    ECHO "<BR>FIN";
    

    
?>