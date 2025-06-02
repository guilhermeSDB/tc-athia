<?php

namespace App\Application\UseCases\Empresa;

use App\Application\DTO\Empresa\UpdateEmpresaDTO;
use App\Domain\Contracts\ValidatorServiceInterface;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Domain\Contracts\UseCaseInterface;
use App\Domain\Repositories\SetorRepositoryInterface;

/**
 * @implements UseCaseInterface<UpdateEmpresaDTO, Empresa>
 */
class UpdateEmpresaUseCase implements UseCaseInterface
{
	public function __construct(
		private EmpresaRepositoryInterface $repository,
		private SetorRepositoryInterface $setorRepository,
		private ValidatorServiceInterface $validatorService
	) {}

	public function execute($dto): mixed
	{
		$this->validatorService->validate($dto);

		if (!$this->repository->findById($dto->id)) {
			throw new \Exception('Empresa não encontrada.');
		}

		$idsDeSetores = is_array($dto->setores) ? $dto->setores : [];

		if (!empty($idsDeSetores)) {
			$setoresExistentes = $this->setorRepository->findByIds($idsDeSetores);

			if (count($setoresExistentes) !== count($idsDeSetores)) {
				throw new \Exception('Alguns setores informados não existem.');
			}
		}

		$updatedEmpresa = Empresa::create($dto->razao_social, $dto->nome_fantasia, $dto->cnpj, $dto->setores);

		return $this->repository->update($dto->id, $updatedEmpresa);
	}
}
