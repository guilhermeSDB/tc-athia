<?php

namespace App\Domain\Entities;

use App\Domain\Entities\Entity;

class Setor extends Entity
{
	public function __construct(
		?int   		$id,
		public readonly string $descricao,
		string 		$created_at,
		string 		$updated_at,
		?string 	$deleted_at
	) {
		parent::__construct($id, $created_at, $updated_at, $deleted_at);
	}

	public static function create(string $descricao): self
	{
		return new self(
			null,
			$descricao,
			'',
			'',
			null
		);
	}

	public function getDescricao(): string
	{
		return $this->descricao;
	}

	public function setDescricao(string $descricao): void
	{
		$this->descricao = $descricao;
	}
}
