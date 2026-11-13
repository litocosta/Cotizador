# Cotizador

Aplicacion existente para cotizar vehiculos usados, con paginas PHP, plantillas
Smarty e importadores de inventario en Node.js.

Repositorio: https://github.com/litocosta/Cotizador. Rama principal: `main`.
El proyecto tiene su propio repositorio Git, independiente de la carpeta personal.

## Configuracion privada

Las credenciales no forman parte del codigo publicado. PHP y Node.js comparten
el archivo `config.local.json`, ubicado en la raiz del proyecto, fuera de
`www/html`. Para una instalacion nueva:

1. Copiar `config.example.json` como `config.local.json`.
2. Completar los valores necesarios para los servicios utilizados.
3. Configurar el servidor web con `www/html` como raiz publica, nunca la raiz
   del repositorio.

Tambien se pueden proporcionar variables de entorno con el prefijo `COTIZADOR_`.
Por ejemplo, `COTIZADOR_DB_PASSWORD` reemplaza la clave `DB_PASSWORD` del archivo
local. Una variable no vacia tiene prioridad. Si un valor requerido falta, esta
vacio o tiene un tipo incorrecto, se informa un error: no hay contrasenas de
respaldo.

Las claves `DB_HOST`, `DB_USER`, `DB_PASSWORD` y `DB_NAME` corresponden a MySQL.
Las claves `FTP_*`, `SQLSERVER_*` e `INFOAUTO_*` corresponden a las integraciones
opcionales existentes. Las claves con sufijos numericos conservan configuraciones
distintas de paginas antiguas; revisar sus usos antes de cambiarlas. Las
autorizaciones de InfoAuto incluyen el esquema del encabezado (`Basic` o
`Bearer`) cuando el codigo lo requiere.

En la copia local original se conservaron los valores anteriores en el archivo
ignorado para no perder la configuracion. Deben reemplazarse por credenciales
nuevas antes de volver a utilizar servicios reales.

## Ejecucion y datos

Se necesita un servidor PHP compatible con este codigo heredado y sus
extensiones MySQL/mysqli, cURL, FTP y PDO/SQL Server segun la pagina utilizada.
Algunas paginas antiguas usan `mysql_*`, eliminado desde PHP 7: la publicacion
no constituye una migracion de esas paginas a PHP moderno.

Los importadores Node.js utilizan las dependencias de
[`www/html/package.json`](www/html/package.json). El esquema de base de datos
y los datos de produccion no se incluyen.

Los datos de clientes y usuarios, CSV de inventario, fotos subidas, registros,
plantillas compiladas, configuracion local y `node_modules` se excluyen mediante
`.gitignore`. Las carpetas de trabajo se conservan vacias cuando corresponde.
Los archivos privados originales no se eliminan del equipo.

El ZIP original se retira de la version actual porque contiene una copia sin
depurar. Puede seguir disponible en commits anteriores: eliminarlo de `main`
no borra el historial ni revoca credenciales. Es necesario rotarlas; no se
reescribe el historial compartido automaticamente.

## Verificacion

Con Node.js 18 o posterior y PHP disponible en `PATH`:

```powershell
node --test tests\config.test.js
```

Si PHP no esta en `PATH`, definir `PHP_BINARY` con la ruta a `php.exe`.
Las pruebas verifican los dos lectores de configuracion sin conectarse a
servicios externos. No prueban el funcionamiento integral del sistema heredado.
