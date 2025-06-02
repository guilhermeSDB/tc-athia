<?php

use DI\Container;
use Slim\Factory\AppFactory;

$container = new Container();

require __DIR__ . '/bootstrap/repositories.php';
require __DIR__ . '/bootstrap/services.php';
require __DIR__ . '/bootstrap/usecases.php';
require __DIR__ . '/bootstrap/controllers.php';
require __DIR__ . '/bootstrap/middlewares.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

(require __DIR__ . '/bootstrap/global_middlewares.php')($app);
(require __DIR__ . '/routes/api.php')($app);

return $app;
