<?php

namespace App\Application\UseCases\Empresa;

use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<int, Empresa|null>
 */
class FindByIdEmpresaUseCase implements UseCaseInterface
{
	public function __construct(private EmpresaRepositoryInterface $repository) {}

	public function execute($id): mixed
	{
		return $this->repository->findById($id);
	}
}
