<?php
require_once __DIR__ . '/config.php';
session_start();
$usuario = $_SESSION["admin"];
//echo "UasiaRIO: ".$usuario;
define('DB_SERVER', cotizador_config('DB_HOST'));
define('DB_SERVER_USERNAME', cotizador_config('DB_USER'));
define('DB_SERVER_PASSWORD', cotizador_config('DB_PASSWORD'));
define('DB_DATABASE', cotizador_config('DB_NAME'));

$connexion = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

$html = '';
$key = $_POST['key'];

$result = $connexion->query(
    'SELECT * FROM cotizados WHERE patente LIKE "%'.strip_tags($key).'%"');
    //    'SELECT * FROM cotizados WHERE usuario="'.$usuario.'" AND patente LIKE "%'.strip_tags($key).'%"');
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {                
        $html .= '<div><a class="suggest-element" data="'.$row['id'].'_'.
                                                        utf8_encode($row['nombre']).' '.utf8_encode($row['apellido']).'<br>'.
                                                        utf8_encode($row['patente']).' '.
                                                        utf8_encode($row['marca']).' '.
                                                        utf8_encode($row['modelo']).' '.
                                                        utf8_encode($row['version']).' '.
                                                        utf8_encode($row['ano']).' '.
                                                        '" id="product'.$row['id'].'">'
        .$row['id'].' '.$row['patente'].' '.utf8_encode($row['marca']).' '.utf8_encode($row['modelo']).' '.utf8_encode($row['version']).' '.utf8_encode($row['nombre']).' '.utf8_encode($row['apellido']).'</a></div>';
    }
}
echo $html;
?>