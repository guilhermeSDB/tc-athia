<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Empresa;
use App\Domain\Contracts\RepositoryInterface;

/**
 * @extends RepositoryInterface<Empresa>
 */
interface EmpresaSetorRepositoryInterface extends RepositoryInterface
{
	/**
	 * @param mixed $ids
	 * @return Empresa|null
	 */
	public function createReport(?int $empresaId = null, ?int $setorId = null): ?Empresa;
}
