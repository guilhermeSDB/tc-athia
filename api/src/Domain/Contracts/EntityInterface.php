<?php

namespace App\Domain\Contracts;

/**
 * EntityInterface defines the contract for all entities in the domain.
 * It provides methods to access common properties such as id, created_at, updated_at, and deleted_at.
 */
interface EntityInterface
{
	public function getId(): ?string;
	public function setId(?string $id): void;
	public function getCreatedAt(): string;
	public function setCreatedAt(string $created_at): void;
	public function getUpdatedAt(): string;
	public function setUpdatedAt(string $updated_at): void;
	public function getDeletedAt(): ?string;
	public function setDeletedAt(?string $deleted_at): void;
}
