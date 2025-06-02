<?php

use Slim\App;

use App\Interface\Http\Middlewares\ErrorHandlerMiddleware;
use App\Interface\Http\Middlewares\JsonBodyParserMiddleware;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
	if (!$app) {
		throw new RuntimeException('App instance not available in global_middlewares.php.');
	}

	$app->add(JsonBodyParserMiddleware::class);
	$app->add(ErrorHandlerMiddleware::class);

	$app->add(function (Request $request, RequestHandlerInterface $handler): Response {
		if ($request->getMethod() === 'OPTIONS') {
			$response = new \Slim\Psr7\Response();
			return $response
				->withStatus(200)
				->withHeader('Access-Control-Allow-Origin', '*')
				->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
				->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
		}
		
		$response = $handler->handle($request);

		return $response
			->withoutHeader('X-Powered-By')
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
	});
};
