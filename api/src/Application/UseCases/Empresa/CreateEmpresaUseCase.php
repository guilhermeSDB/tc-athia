<?php

namespace App\Application\UseCases\Empresa;

use App\Domain\Contracts\ValidatorServiceInterface;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Domain\Contracts\UseCaseInterface;
use App\Domain\Repositories\SetorRepositoryInterface;

/**
 * @param RepositoryInterface<Empresa> $repository
 * @implements UseCaseInterface<CreateEmpresaDTO, EmpresaEntity>
 */
class CreateEmpresaUseCase implements UseCaseInterface
{
	public function __construct(
		private EmpresaRepositoryInterface $repository,
		private SetorRepositoryInterface $setorRepository,
		private ValidatorServiceInterface $validatorService
	) {}

	public function execute($dto): mixed
	{
		$this->validatorService->validate($dto);

		if ($this->repository->existCnpj($dto->cnpj)) {
			throw new \Exception('Empresa com este CNPJ já existe.');
		}

		$idsDeSetores = is_array($dto->setores) ? $dto->setores : [];

		if (!empty($idsDeSetores)) {
			$setoresExistentes = $this->setorRepository->findByIds($idsDeSetores);

			if (count($setoresExistentes) !== count($idsDeSetores)) {
				throw new \Exception('Alguns setores informados não existem.');
			}
		}
		
		$newEmpresa = Empresa::create($dto->razao_social, $dto->nome_fantasia, $dto->cnpj, $dto->setores);
		return $this->repository->create($newEmpresa);
	}
}
