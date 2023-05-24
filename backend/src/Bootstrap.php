<?php

use Api\Application;

chdir(dirname(__DIR__));

include __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';

if ($config['mode'] == Application::MODE_PRODUCTION) {
    error_reporting(0);
    ini_set('display_errors', '0');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

ini_set('log_errors', '1');

return new Application($config);
