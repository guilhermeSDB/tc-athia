<?php

namespace App\Application\DTO\Setor;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
	schema: 'CountSetorDTO',
	title: 'CountSetorDTO',
	description: 'DTO para criação de setor'
)]
class CountSetorDTO
{
	#[OAT\Property(
		property: 'count',
		type: 'integer',
		description: 'Quantidade de setores cadastradas',
		example: 42
	)]
	#[Assert\NotBlank(message: "Count não pode ser vazio")]
	public int $count;

	public static function fromCount(int $count): self
	{
		$dto = new self();
		$dto->count = $count;
		return $dto;
	}
}
