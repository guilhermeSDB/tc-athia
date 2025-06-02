<?php

use App\Domain\Contracts\ValidatorServiceInterface;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Repositories\SetorRepositoryInterface;

// Empresa Use Cases
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
// Setor Use Cases
use App\Application\UseCases\Setor\{
	CreateSetorUseCase,
	UpdateSetorUseCase,
	FindAllSetorUseCase,
	FindByIdSetorUseCase,
	SoftDeleteSetorUseCase,
	DeleteSetorUseCase,
	CountSetorUseCase
};
use App\Domain\Repositories\EmpresaSetorRepositoryInterface;

$container->set(CreateSetorUseCase::class, fn($c) => new CreateSetorUseCase(
	$c->get(SetorRepositoryInterface::class),
	$c->get(ValidatorServiceInterface::class),
));
$container->set(UpdateSetorUseCase::class, fn($c) => new UpdateSetorUseCase(
	$c->get(SetorRepositoryInterface::class),
	$c->get(ValidatorServiceInterface::class),
));
$container->set(FindAllSetorUseCase::class, fn($c) => new FindAllSetorUseCase($c->get(SetorRepositoryInterface::class)));
$container->set(FindByIdSetorUseCase::class, fn($c) => new FindByIdSetorUseCase($c->get(SetorRepositoryInterface::class)));
$container->set(SoftDeleteSetorUseCase::class, fn($c) => new SoftDeleteSetorUseCase($c->get(SetorRepositoryInterface::class)));
$container->set(DeleteSetorUseCase::class, fn($c) => new DeleteSetorUseCase($c->get(SetorRepositoryInterface::class)));
$container->set(CountSetorUseCase::class, fn($c) => new CountSetorUseCase($c->get(SetorRepositoryInterface::class)));

$container->set(CreateEmpresaUseCase::class, fn($c) => new CreateEmpresaUseCase(
	$c->get(EmpresaRepositoryInterface::class),
	$c->get(SetorRepositoryInterface::class),
	$c->get(ValidatorServiceInterface::class),
));
$container->set(UpdateEmpresaUseCase::class, fn($c) => new UpdateEmpresaUseCase(
	$c->get(EmpresaRepositoryInterface::class),
	$c->get(SetorRepositoryInterface::class),
	$c->get(ValidatorServiceInterface::class),
));
$container->set(FindAllEmpresaUseCase::class, fn($c) => new FindAllEmpresaUseCase(
	$c->get(EmpresaRepositoryInterface::class),
));
$container->set(FindByIdEmpresaUseCase::class, fn($c) => new FindByIdEmpresaUseCase(
	$c->get(EmpresaRepositoryInterface::class),
));
$container->set(SoftDeleteEmpresaUseCase::class, fn($c) => new SoftDeleteEmpresaUseCase(
	$c->get(EmpresaRepositoryInterface::class),
));
$container->set(DeleteEmpresaUseCase::class, fn($c) => new DeleteEmpresaUseCase(
	$c->get(EmpresaRepositoryInterface::class),
));
$container->set(CountEmpresaUseCase::class, fn($c) => new CountEmpresaUseCase(
	$c->get(EmpresaRepositoryInterface::class),
));

// Empresa Setor Use Cases
$container->set(ListReportEmpresaSetorUseCase::class, fn($c) => new ListReportEmpresaSetorUseCase(
	$c->get(EmpresaRepositoryInterface::class),
	$c->get(SetorRepositoryInterface::class),
	$c->get(ValidatorServiceInterface::class),
));
