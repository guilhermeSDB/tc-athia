<?php

use App\Domain\Repositories\{
	EmpresaRepositoryInterface,
    EmpresaSetorRepositoryInterface,
    SetorRepositoryInterface
};

use App\Infrastructure\Database\Repositories\{
	EmpresaRepository,
    EmpresaSetorRepository,
    SetorRepository
};

$container->set(EmpresaRepositoryInterface::class, fn() => new EmpresaRepository());
$container->set(SetorRepositoryInterface::class, fn() => new SetorRepository());
$container->set(EmpresaSetorRepositoryInterface::class, fn() => new EmpresaSetorRepository());
