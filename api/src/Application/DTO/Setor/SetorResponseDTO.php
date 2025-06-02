<?php

namespace App\Application\DTO\Setor;

use App\Domain\Entities\Setor;
use JsonSerializable;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
	schema: 'SetorResponseDTO',
	title: 'SetorResponseDTO',
	description: 'Resposta após criar/recuperar setor'
)]
class SetorResponseDTO implements JsonSerializable
{

	public function __construct(
		public readonly int $id,
		public readonly string $descricao,
		public readonly string $created_at,
		public readonly string $updated_at,
		public readonly ?string $deleted_at = null
	) {}

	public static function fromEntity(Setor $entity): self
	{
		return new self(
			$entity->getId(),
			$entity->getDescricao(),
			$entity->getCreatedAt(),
			$entity->getUpdatedAt(),
			$entity->getDeletedAt()
		);
	}

	public function jsonSerialize(): array
	{
		return get_object_vars($this);
	}
}
