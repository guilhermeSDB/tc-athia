<?php

use Slim\App;
use App\Interface\Http\Controllers\EmpresaSetor\ListReportEmpresaSetorController;

return function (App $app) {
	$container = $app->getContainer();

	$app->get('/empresas-setores/relatorio', function ($request, $response, $args) use ($container) {
		$controller = $container->get(ListReportEmpresaSetorController::class);
		return $controller($request, $response, $args);
	});
};
