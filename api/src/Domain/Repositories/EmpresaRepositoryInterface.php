<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Empresa;
use App\Domain\Contracts\RepositoryInterface;

/**
 * @extends RepositoryInterface<Empresa>
 */
interface EmpresaRepositoryInterface extends RepositoryInterface
{
	/**
	 * @param string $cnpj
	 * @return Empresa|null
	 */
	public function findByCnpj(string $cnpj): ?Empresa;

	/**
	 * @param string $cnpj
	 * @return bool
	 */
	public function existCnpj(string $cnpj): bool;

	/**
	 * @param mixed $ids
	 * @return Empresa|null
	 */
	public function createReport(?int $empresaId = null, ?int $setorId = null): mixed;
}
