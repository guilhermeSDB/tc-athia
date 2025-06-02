<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Setor;
use App\Domain\Contracts\RepositoryInterface;

/**
 * @extends RepositoryInterface<Setor>
 */
interface SetorRepositoryInterface extends RepositoryInterface
{
	/**
	 * Retorna todos os modelos Setor cujos IDs estejam em $ids.
	 *
	 * @param int[] $ids
	 * @return array<\App\Infrastructure\Database\Eloquent\Models\Setor>
	 */
	public function findByIds(array $ids): array;
}
