<?php

function cotizador_config($key)
{
    $name = 'COTIZADOR_' . $key;
    $value = getenv($name);
    if ($value !== false && $value !== '') {
        return $value;
    }

    static $settings = null;
    if ($settings === null) {
        $loaded = array();
        $path = dirname(dirname(__DIR__)) . '/config.local.json';
        if (is_file($path)) {
            $contents = file_get_contents($path);
            if ($contents === false) {
                throw new RuntimeException('No se pudo leer config.local.json');
            }
            $decoded = json_decode($contents);
            if (json_last_error() !== JSON_ERROR_NONE || !is_object($decoded)) {
                throw new RuntimeException('config.local.json debe contener un objeto JSON valido');
            }
            $loaded = get_object_vars($decoded);
        }
        $settings = $loaded;
    }

    if (!isset($settings[$key]) || !is_string($settings[$key]) || $settings[$key] === '') {
        throw new RuntimeException('Falta configurar ' . $name . ' o su valor en config.local.json');
    }
    return $settings[$key];
}
