<?php

use App\Application\UseCases\Setor\{
	CountSetorUseCase,
	CreateSetorUseCase,
	UpdateSetorUseCase,
	FindAllSetorUseCase,
	FindByIdSetorUseCase,
	SoftDeleteSetorUseCase,
	DeleteSetorUseCase
};

use App\Application\UseCases\Empresa\{
	CountEmpresaUseCase,
	CreateEmpresaUseCase,
	UpdateEmpresaUseCase,
	FindAllEmpresaUseCase,
	FindByIdEmpresaUseCase,
	SoftDeleteEmpresaUseCase,
	DeleteEmpresaUseCase
};
use App\Application\UseCases\EmpresaSetor\ListReportEmpresaSetorUseCase;
use App\Interface\Http\Controllers\Empresa\CountEmpresaController;
use App\Interface\Http\Controllers\Empresa\CreateEmpresaController;
use App\Interface\Http\Controllers\Empresa\DeleteEmpresaController;
use App\Interface\Http\Controllers\Empresa\FindAllEmpresaController;
use App\Interface\Http\Controllers\Empresa\FindByIdEmpresaController;
use App\Interface\Http\Controllers\Empresa\SoftDeleteEmpresaController;
use App\Interface\Http\Controllers\Empresa\UpdateEmpresaController;
use App\Interface\Http\Controllers\EmpresaSetor\ListReportEmpresaSetorController;
use App\Interface\Http\Controllers\Setor\CountSetorController;
use App\Interface\Http\Controllers\Setor\CreateSetorController;
use App\Interface\Http\Controllers\Setor\DeleteSetorController;
use App\Interface\Http\Controllers\Setor\FindAllSetorController;
use App\Interface\Http\Controllers\Setor\FindByIdSetorController;
use App\Interface\Http\Controllers\Setor\SoftDeleteSetorController;
use App\Interface\Http\Controllers\Setor\UpdateSetorController;

$container->set(CountEmpresaController::class, fn($c) => new CountEmpresaController(
	$c->get(CountEmpresaUseCase::class),
));

$container->set(CreateEmpresaController::class, fn($c) => new CreateEmpresaController(
	$c->get(CreateEmpresaUseCase::class),
));

$container->set(UpdateEmpresaController::class, fn($c) => new UpdateEmpresaController(
	$c->get(UpdateEmpresaUseCase::class)
));

$container->set(FindAllEmpresaController::class, fn($c) => new FindAllEmpresaController(
	$c->get(FindAllEmpresaUseCase::class),
));

$container->set(FindByIdEmpresaController::class, fn($c) => new FindByIdEmpresaController(
	$c->get(FindByIdEmpresaUseCase::class),
));

$container->set(SoftDeleteEmpresaController::class, fn($c) => new SoftDeleteEmpresaController(
	$c->get(SoftDeleteEmpresaUseCase::class),
));

$container->set(DeleteEmpresaController::class, fn($c) => new DeleteEmpresaController(
	$c->get(DeleteEmpresaUseCase::class),
));

$container->set(CountSetorController::class, fn($c) => new CountSetorController(
	$c->get(CountSetorUseCase::class),
));

$container->set(CreateSetorController::class, fn($c) => new CreateSetorController(
	$c->get(CreateSetorUseCase::class),
));

$container->set(UpdateSetorController::class, fn($c) => new UpdateSetorController(
	$c->get(UpdateSetorUseCase::class)
));

$container->set(FindAllSetorController::class, fn($c) => new FindAllSetorController(
	$c->get(FindAllSetorUseCase::class),
));

$container->set(FindByIdSetorController::class, fn($c) => new FindByIdSetorController(
	$c->get(FindByIdSetorUseCase::class),
));

$container->set(SoftDeleteSetorController::class, fn($c) => new SoftDeleteSetorController(
	$c->get(SoftDeleteSetorUseCase::class),
));

$container->set(DeleteSetorController::class, fn($c) => new DeleteSetorController(
	$c->get(DeleteSetorUseCase::class),
));

$container->set(ListReportEmpresaSetorController::class, fn($c) => new ListReportEmpresaSetorController(
	$c->get(ListReportEmpresaSetorUseCase::class),
));
