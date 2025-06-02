<?php

/**
 * API Public Entry Point
 *
 * This file serves as the entry point for the API, handling requests and routing them to the appropriate controllers.
 *
 * @package    API
 * @subpackage Public
 * @version    1.0.0
 */
date_default_timezone_set('America/Sao_Paulo');
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';
$app = require __DIR__ . '/../bootstrap.php';

$app->get('/', function ($request, $response) {
	return $response
		->withHeader('Location', '/swagger')
		->withStatus(302);
});

$app->run();
