<?php

namespace App\Application\UseCases\Empresa;

use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @param RepositoryInterface<Empresa> $repository
 * @implements UseCaseInterface<CountEmpresaUseCase, int>
 */
class CountEmpresaUseCase implements UseCaseInterface
{
	public function __construct(
		private EmpresaRepositoryInterface $repository,
	) {}

	public function execute($input): mixed
	{
		return $this->repository->count();
	}
}
