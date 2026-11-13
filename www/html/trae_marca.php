<?php
require_once __DIR__ . '/config.php';
require_once 'HTTP/Request2.php';
        $request = new HTTP_Request2();
      $request->setUrl('https://demo.api.infoauto.com.ar/cars/pub/brands/1/groups/1/models/');
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
        'follow_redirects' => TRUE
         ));
        $request->setHeader(array(
        'Authorization' => cotizador_config('INFOAUTO_AUTHORIZATION_4'),
        'Accept' => 'application/vnd.gestion.online+json',
        'X-Force-Content-Type' => 'application/json'
      ));

      try 
      {
        $response = $request->send();
        if ($response->getStatus() == 200) 
        {
  
          $muestra = $response->getbody();
          $total_caracteres = strlen($muestra);
          $muestra = substr($muestra,1,$total_caracteres-3);
          echo $muestra."<br>";
         
        }  
        else 
        {
          echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
          $response->getReasonPhrase();
        }
      }
      catch(HTTP_Request2_Exception $e) 
      {
        echo 'Error: ' . $e->getMessage();
      }
    
?>