<?php

use Slim\App;
use App\Application\DTO\Empresa\CreateEmpresaDTO;
use App\Application\DTO\Empresa\UpdateEmpresaDTO;
use App\Interface\Http\Controllers\Empresa\CountEmpresaController;
use App\Interface\Http\Controllers\Empresa\CreateEmpresaController;
use App\Interface\Http\Controllers\Empresa\DeleteEmpresaController;
use App\Interface\Http\Controllers\Empresa\FindAllEmpresaController;
use App\Interface\Http\Controllers\Empresa\FindByIdEmpresaController;
use App\Interface\Http\Controllers\Empresa\SoftDeleteEmpresaController;
use App\Interface\Http\Controllers\Empresa\UpdateEmpresaController;
use App\Interface\Http\Factories\ValidationMiddlewareFactory;

return function (App $app) {
	$container = $app->getContainer();
	$validationFactory = $container->get(ValidationMiddlewareFactory::class);

	$app->get('/empresas/count', function ($request, $response, $args) use ($container) {
		$controller = $container->get(CountEmpresaController::class);
		return $controller($request, $response, $args);
	});

	$app->post(
		'/empresas',
		function ($request, $response, $args) use ($container) {
			$controller = $container->get(CreateEmpresaController::class);
			return $controller($request, $response, $args = null);
		}
	)->add($validationFactory->make(CreateEmpresaDTO::class));

	$app->put('/empresas/{id}', function ($request, $response, $args) use ($container) {
		$controller = $container->get(UpdateEmpresaController::class);
		return $controller($request, $response, $args);
	})->add($validationFactory->make(UpdateEmpresaDTO::class));

	$app->get('/empresas', function ($request, $response, $args) use ($container) {
		$controller = $container->get(FindAllEmpresaController::class);
		return $controller($request, $response, $args = null);
	});

	$app->get('/empresas/{id}', function ($request, $response, $args) use ($container) {
		$controller = $container->get(FindByIdEmpresaController::class);
		return $controller($request, $response, $args);
	});

	$app->delete('/empresas/{id}', function ($request, $response, $args) use ($container) {
		$controller = $container->get(DeleteEmpresaController::class);
		return $controller($request, $response, $args);
	});

	$app->patch('/empresas/{id}/soft-delete', function ($request, $response, $args) use ($container) {
		$controller = $container->get(SoftDeleteEmpresaController::class);
		return $controller($request, $response, $args);
	});
};
