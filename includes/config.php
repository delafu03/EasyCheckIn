<?php

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'vm004.db.swarm.test');
define('BD_NAME', 'checkin_hotel');
define('BD_USER', 'super_admin');
define('BD_PASS', 'vm004aw');

/**
 * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
 */
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '');
define('RUTA_IMGS', RUTA_APP.'/img');
define('RUTA_CSS', RUTA_APP.'/css');
define('RUTA_JS', RUTA_APP.'/js');

// // /**
// //  * Parámetros de conexión a la BD
// //  */
// define('BD_HOST', 'localhost');
// define('BD_NAME', 'checkin_hotel');
// define('BD_USER', 'root');
// define('BD_PASS', '1234');

// /**
//  * Parámetros de configuración utilizados para generar las URLs y las rutas a ficheros en la aplicación
//  */
// define('RAIZ_APP', __DIR__);
// define('RUTA_APP', '/EASYCHECKIN');
// define('RUTA_IMGS', RUTA_APP.'/img/');
// define('RUTA_CSS', RUTA_APP.'/css/');
// define('RUTA_JS', RUTA_APP.'/js/');




/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'es\\ucm\\fdi\\aw\\';

    // base directory for the namespace prefix
    $base_dir = implode(DIRECTORY_SEPARATOR, [__DIR__, 'clases', '']);

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
