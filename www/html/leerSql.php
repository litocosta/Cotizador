<?php
require_once __DIR__ . '/config.php';
phpinfo();
/*
CRUD con SQL Server y PHP
@author parzibyte [parzibyte.me/blog]
@date 2019-06-03

================================
Este archivo se encarga de conectar a la base de datos
y traer un objeto PDO

Recuerda cambiar tus credenciales, y tal vez ponerlas en
un archivo env: https://parzibyte.me/blog/2018/06/30/leer-archivo-configuracion-ini-php/
================================
 */
$contraseña = cotizador_config('SQLSERVER_PASSWORD');
$usuario = cotizador_config('SQLSERVER_USER');
$nombreBaseDeDatos = cotizador_config('SQLSERVER_NAME');
# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
$rutaServidor = cotizador_config('SQLSERVER_HOST');
try {
    $base_de_datos = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contraseña);
    $base_de_datos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "entroli";
} catch (Exception $e) {
    echo "Ocurrió un error con la base de datos: " . $e->getMessage();
}