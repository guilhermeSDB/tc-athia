<?php

namespace App\Application\UseCases\Empresa;

use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<int, bool>
 */
class SoftDeleteEmpresaUseCase implements UseCaseInterface
{
	public function __construct(private EmpresaRepositoryInterface $repository) {}

	public function execute($id): mixed
	{
		if (!$this->repository->findById($id)) {
			throw new \Exception('Empresa não encontrada.');
		}

		return $this->repository->softDelete($id);
	}
}
