<?php
require_once __DIR__ . '/config.php';
require_once 'HTTP/Request2.php';
$request = new HTTP_Request2();
$request->setUrl('https://demo.api.infoauto.com.ar/cars/auth/login');
$request->setMethod(HTTP_Request2::METHOD_POST);
$request->setConfig(array(
  'follow_redirects' => TRUE
));
$request->setHeader(array(
  'Authorization' => cotizador_config('INFOAUTO_AUTHORIZATION_2'),
  'Cookie' => cotizador_config('INFOAUTO_COOKIE_2')
));
try {
  $response = $request->send();
  if ($response->getStatus() == 200) {
    //echo $response->getBody();
    $choto = cotizador_config('INFOAUTO_LEGACY_TOKEN');
    //echo strlen($choto);
    $todo = $response->getBody();
    $refre = "refresh_token";
    //echo strpos($todo, $refre);
    //echo '<BR>'.strpos($todo,'"}');
    //echo '<BR>'.strpos($todo,'"}');
    $token = substr($todo,17,484);
    echo '<BR>HOLAAAAA  '.$token;
  }
  else {
    echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
    $response->getReasonPhrase();
  }
}
catch(HTTP_Request2_Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
?>