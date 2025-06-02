<?php

namespace App\Application\UseCases\Setor;

use App\Domain\Contracts\ValidatorServiceInterface;
use App\Domain\Repositories\SetorRepositoryInterface;
use App\Domain\Entities\Setor;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<Setor, Setor>
 */
class CreateSetorUseCase implements UseCaseInterface
{
	public function __construct(private SetorRepositoryInterface $repository, private ValidatorServiceInterface $validatorService) {}

	public function execute($input): mixed
	{
		$this->validatorService->validate($input);
		$newSetor = Setor::create($input->descricao);
		return $this->repository->create($newSetor);
	}
}
