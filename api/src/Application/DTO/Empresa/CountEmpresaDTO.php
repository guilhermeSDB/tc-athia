<?php

namespace App\Application\DTO\Empresa;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
	schema: 'CountEmpresaDTO',
	title: 'CountEmpresaDTO',
	description: 'DTO para contagem de empresa'
)]
class CountEmpresaDTO
{
	#[OAT\Property(
		property: 'count',
		type: 'integer',
		description: 'Quantidade de empresas cadastradas',
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
