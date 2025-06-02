<?php

use App\Application\DTO\Setor\CreateSetorDTO;
use App\Application\DTO\Setor\UpdateSetorDTO;
use App\Interface\Http\Controllers\Setor\CountSetorController;
use App\Interface\Http\Controllers\Setor\CreateSetorController;
use App\Interface\Http\Controllers\Setor\DeleteSetorController;
use App\Interface\Http\Controllers\Setor\FindAllSetorController;
use App\Interface\Http\Controllers\Setor\FindByIdSetorController;
use App\Interface\Http\Controllers\Setor\SoftDeleteSetorController;
use App\Interface\Http\Controllers\Setor\UpdateSetorController;
use Slim\App;
use App\Interface\Http\Factories\ValidationMiddlewareFactory;

return function (App $app) {
	$container = $app->getContainer();
	$validationFactory = $container->get(ValidationMiddlewareFactory::class);

	$app->get('/setores/count', function ($request, $response, $args) use ($container) {
		$controller = $container->get(CountSetorController::class);
		return $controller($request, $response, $args);
	});

	$app->post('/setores', function ($request, $response, $args) use ($container) {
		$controller = $container->get(CreateSetorController::class);
		return $controller($request, $response, $args = null);
	})->add($validationFactory->make(CreateSetorDTO::class));

	$app->put('/setores/{id}', function ($request, $response, $args) use ($container) {
		$controller = $container->get(UpdateSetorController::class);
		return $controller($request, $response, $args);
	})->add($validationFactory->make(UpdateSetorDTO::class));

	$app->get('/setores', function ($request, $response, $args) use ($container) {
		$controller = $container->get(FindAllSetorController::class);
		return $controller($request, $response, $args = null);
	});

	$app->get('/setores/{id}', function ($request, $response, $args) use ($container) {
		$controller = $container->get(FindByIdSetorController::class);
		return $controller($request, $response, $args);
	});

	$app->delete('/setores/{id}', function ($request, $response, $args) use ($container) {
		$controller = $container->get(DeleteSetorController::class);
		return $controller($request, $response, $args);
	});

	$app->patch('/setores/{id}/soft-delete', function ($request, $response, $args) use ($container) {
		$controller = $container->get(SoftDeleteSetorController::class);
		return $controller($request, $response, $args);
	});
};
