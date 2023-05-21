<?php
declare(strict_types=1);
error_reporting(E_ALL);
require_once 'newsite/bootstrap.php';
use Newsite\Core\Application;
$app = new Application(dirname(__DIR__));
$app->run();