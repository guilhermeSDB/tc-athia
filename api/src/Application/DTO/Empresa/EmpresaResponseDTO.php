<?php

namespace App\Application\DTO\Empresa;

use App\Domain\Entities\Empresa;
use JsonSerializable;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
	schema: 'EmpresaResponseDTO',
	title: 'EmpresaResponseDTO',
	description: 'Resposta após criar/recuperar empresa'
)]
class EmpresaResponseDTO implements JsonSerializable
{

	public function __construct(
		public readonly int $id,
		public readonly string $razao_social,
		public readonly string $cnpj,
		public readonly string $created_at,
		public readonly string $updated_at,
		public readonly ?array $setores = [],
		public readonly ?string $nome_fantasia = null,
		public readonly ?string $deleted_at = null
	) {}

	public static function fromEntity(Empresa $entity): self
	{
		return new self(
			$entity->getId(),
			$entity->getRazaoSocial(),
			$entity->getCnpj(),
			$entity->getCreatedAt(),
			$entity->getUpdatedAt(),
			$entity->getSetores(),
			$entity->getNomeFantasia(),
			$entity->getDeletedAt(),
		);
	}

	public function jsonSerialize(): array
	{
		return get_object_vars($this);
	}
}
