<?php

namespace App\Application\UseCases\EmpresaSetor;

use App\Application\DTO\EmpresaSetor\EmpresaSetorFilterDTO;
use App\Domain\Contracts\ValidatorServiceInterface;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Domain\Entities\Empresa;
use App\Domain\Contracts\UseCaseInterface;
use App\Domain\Repositories\SetorRepositoryInterface;


/**
 * @param RepositoryInterface<Empresa> $repository
 * @implements UseCaseInterface<CreateEmpresaDTO, EmpresaEntity>
 */
class ListReportEmpresaSetorUseCase implements UseCaseInterface
{
	public function __construct(
		private EmpresaRepositoryInterface $repository,
		private SetorRepositoryInterface $setorRepository,
		private ValidatorServiceInterface $validatorService
	) {}

	public function execute($dto): mixed
	{
		$this->validatorService->validate($dto);
		$ids = new EmpresaSetorFilterDTO($dto->empresa_id, $dto->setor_id);
		return $this->repository->createReport($ids->empresa_id, $ids->setor_id);
	}
}
