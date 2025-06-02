<?php

namespace App\Domain\Contracts;

use App\Domain\Entities\Entity;

/**
 * EntityInterface defines the contract for all entities in the domain.
 * It provides methods to access common properties such as id, created_at, updated_at, and deleted_at.
 * @template T
 */
interface RepositoryInterface
{
	/**
	 * @param T $entity
	 * @return T
	 */
	public function create($entity): Entity;

	/**
	 * @param T $entity
	 * @param int $id
	 * @return T
	 */
	public function update(int $id, $entity): Entity;

	/**
	 * @return T[]
	 */
	public function findAll(): array;

	/**
	 * @param int $id
	 * @return T
	 */
	public function findById(int $id): ?Entity;

	/**
	 * @param int $id
	 * @return void
	 */
	public function delete(int $id): void;

	/**
	 * @param int $id
	 * @return void
	 */
	public function softDelete(int $id): void;

	/**
	 * @param int $id
	 * @return void
	 */
	public function restore(int $id): void;

	/**
	 * @return int
	 */
	public function count(): int;
}
