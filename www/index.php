<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Settting APPLICATION_ENV
$config = @parse_ini_file('config/env.ini');
define('APPLICATION_ENV', (isset($config['APPLICATION_ENV'])) ? $config['APPLICATION_ENV'] : 'local');
define('APPLICATION_PATH', __DIR__  . '/../module/Application');

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
