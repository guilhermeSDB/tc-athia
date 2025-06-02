<?php

namespace App\Application\UseCases\Setor;

use App\Domain\Repositories\SetorRepositoryInterface;
use App\Domain\Entities\Setor;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<null, Setor[]>
 */
class FindAllSetorUseCase implements UseCaseInterface
{
	public function __construct(private SetorRepositoryInterface $repository) {}

	public function execute($input): mixed
	{
		return $this->repository->findAll();
	}
}
