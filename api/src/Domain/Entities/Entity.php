<?php

namespace App\Domain\Entities;

use App\Domain\Contracts\EntityInterface;

/**
 * Entity class that implements the EntityInterface.
 * This class represents a base entity with common properties such as id, created_at, updated_at, and deleted_at.
 */
class Entity implements EntityInterface
{
	public function __construct(
		public readonly ?int $id,
		public readonly string $created_at,
		public readonly string $updated_at,
		public readonly ?string $deleted_at
	) {}

	public function getId(): ?string
	{
		return $this->id;
	}

	public function setId(?string $id): void
	{
		$this->id = $id;
	}

	public function getCreatedAt(): string
	{
		return $this->created_at;
	}

	public function setCreatedAt(string $created_at): void
	{
		$this->created_at = $created_at;
	}

	public function getUpdatedAt(): string
	{
		return $this->updated_at;
	}

	public function setUpdatedAt(string $updated_at): void
	{
		$this->updated_at = $updated_at;
	}

	public function getDeletedAt(): ?string
	{
		return $this->deleted_at;
	}

	public function setDeletedAt(?string $deleted_at): void
	{
		$this->deleted_at = $deleted_at;
	}
}
