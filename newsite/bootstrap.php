<?php

// Auto-loading
require_once "Autoloader.php";
require_once 'newsite/helper/Session.php';
spl_autoload_register("\\Autoloader::loader");

// Load configuration files
use Newsite\core\Config;
require_once 'newsite/config/services.php';



// Include routes
require_once "routes/public.php";

// Error handling override
$error_handler = set_error_handler('\Newsite\Logger\Logger::catchError');

// Database config injection
$config = new Config();
 if($dbConfig = $config->get('database'))
 {
 	\Newsite\Database\Database::setConfig($dbConfig);
 }



