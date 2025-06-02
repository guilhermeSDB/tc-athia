<?php

namespace App\Application\UseCases\Setor;

use App\Domain\Repositories\SetorRepositoryInterface;
use App\Domain\Entities\Setor;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<int, bool>
 */
class SoftDeleteSetorUseCase implements UseCaseInterface
{
	public function __construct(private SetorRepositoryInterface $repository) {}

	public function execute($id): mixed
	{
		if (!$this->repository->findById($id)) {
			throw new \Exception('Setor não encontrado.');
		}

		return $this->repository->softDelete($id);
	}
}
