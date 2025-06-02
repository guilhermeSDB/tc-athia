<?php

use App\Domain\Entities\Entity;


class EmpresaSetor extends Entity
{
	public function __construct(
		public readonly int $empresa_id,
		public readonly int $setor_id
	) {}
}
