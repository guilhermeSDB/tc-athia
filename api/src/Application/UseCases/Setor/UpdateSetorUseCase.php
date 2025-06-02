<?php

namespace App\Application\UseCases\Setor;

use App\Application\DTO\Setor\UpdateSetorDTO;
use App\Domain\Contracts\ValidatorServiceInterface;
use App\Domain\Repositories\SetorRepositoryInterface;
use App\Domain\Entities\Setor;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<UpdateSetorDTO, Setor>
 */
class UpdateSetorUseCase implements UseCaseInterface
{
	public function __construct(private SetorRepositoryInterface $repository, private ValidatorServiceInterface $validatorService) {}

	public function execute($requestDTO): mixed
	{
		$this->validatorService->validate($requestDTO);

		if (!$this->repository->findById($requestDTO->id)) {
			throw new \Exception('Setor não encontrado.');
		}

		$updatedSetor = Setor::create($requestDTO->descricao);

		return $this->repository->update($requestDTO->id, $updatedSetor);
	}
}
