<?php
require_once __DIR__ . '/config.php';
$curl = curl_init('https://test-info_auto.gestion.online/oauth/token');

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

curl_setopt($curl, CURLOPT_POST, true);

$fields = array(
  'client_id' => cotizador_config('INFOAUTO_OAUTH_CLIENT_ID'),
  'client_secret' => cotizador_config('INFOAUTO_OAUTH_CLIENT_SECRET'),
  'grant_type' => 'password',
  'response_type' => 'code',
  'username' => cotizador_config('INFOAUTO_OAUTH_USERNAME'),
  'password' => cotizador_config('INFOAUTO_OAUTH_PASSWORD'));

curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($fields));

$response = curl_exec($curl);
echo $response;
?>