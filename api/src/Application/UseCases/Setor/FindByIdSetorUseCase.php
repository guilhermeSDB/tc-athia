<?php

namespace App\Application\UseCases\Setor;

use App\Domain\Repositories\SetorRepositoryInterface;
use App\Domain\Entities\Setor;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<int, Setor|null>
 */
class FindByIdSetorUseCase implements UseCaseInterface
{
	public function __construct(private SetorRepositoryInterface $repository) {}

	public function execute($id): mixed
	{
		return $this->repository->findById($id);
	}
}
