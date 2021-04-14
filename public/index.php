<?php

use Core\FastRouter;

require "../vendor/autoload.php";


$routes = require '../core/routes.php';
$container = require '../core/bootstrap.php';

FastRouter::load($routes, $container);