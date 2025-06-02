<?php

namespace App\Application\DTO\Setor;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
	schema: 'CreateSetorDTO',
	title: 'CreateSetorDTO',
	description: 'DTO para atualização de setor'
)]
class CreateSetorDTO
{
	#[OAT\Property(
		property: 'descricao',
		type: 'string',
		description: 'Nome do setor',
		example: 'Contabilidade.'
	)]
	#[Assert\NotBlank(message: "Descrição não pode ser vazia")]
	#[Assert\Length(
		min: 1,
		max: 100,
		minMessage: "Descrição muito curta",
		maxMessage: "Descrição muito longa"
	)]
	public string $descricao;

	public function __construct(string $descricao)
	{
		$this->descricao = $descricao;
	}

	public static function fromArray(array $data): self
	{
		return new self(
			$data['descricao'] ?? '',
		);
	}
}
