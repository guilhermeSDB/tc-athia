<?php

namespace App\Application\DTO\Setor;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
	schema: 'UpdateSetorDTO',
	title: 'UpdateSetorDTO',
	description: 'DTO para atualização de setor'
)]
class UpdateSetorDTO
{
	#[OAT\Property(
		property: 'descricao',
		type: 'string',
		description: 'Nome do setor',
		example: 'Contabilidade.'
	)]
	#[Assert\NotBlank(message: "Descrição não pode ser vazia")]
	#[Assert\Length(
		min: 3,
		max: 100,
		minMessage: "Descrição muito curta",
		maxMessage: "Descrição muito longa"
	)]
	public string $descricao;

	#[OAT\Property(
		property: 'id',
		type: 'integer',
		format: 'int64',
		description: 'Id do setor',
		example: '1.'
	)]
	#[Assert\Positive(message: "ID deve ser um número positivo")]
	public int $id;

	public function __construct(int $id, string $descricao)
	{
		$this->id = $id;
		$this->descricao = $descricao;
	}

	public static function fromArray(int $id, array $data): self
	{
		return new self(
			$id,
			$data['descricao'] ?? null
		);
	}

	public static function fromRequest(int $id, self $dto): self
	{
		return new self(
			$id,
			$dto->descricao,
		);
	}
}
