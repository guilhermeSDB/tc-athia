<?php

namespace App\Infrastructure\Database\Repositories;

use App\Domain\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Entities\Entity;

/**
 * @template TModel of Model
 * @template TEntity of Entity
 * @implements RepositoryInterface<TEntity>
 */
abstract class BaseRepository
{
	/**
	 * Classe do Eloquent Model (ex.: App\Infrastructure\Database\Eloquent\Models\Empresa)
	 *
	 * @var class-string<TModel>
	 */
	protected string $modelClass;

	/**
	 * Classe da Entidade de Domínio (ex.: App\Domain\Entities\Empresa)
	 *
	 * @var class-string<TEntity>
	 */
	protected string $entityClass;

	/**
	 * Construtor do BaseRepository.
	 *
	 * @param class-string<TModel>   $modelClass
	 * @param class-string<TEntity>  $entityClass
	 */
	public function __construct(string $modelClass, string $entityClass)
	{
		$this->modelClass  = $modelClass;
		$this->entityClass = $entityClass;
	}

	/**
	 * Cria um novo registro no banco a partir da entidade de domínio.
	 *
	 * @param TEntity $entity
	 * @return TEntity
	 */
	public function create(object $entity): object
	{
		/** @var TModel $model */
		$model = new ($this->modelClass)();

		// Preenche atributos do model a partir da entidade (ex.: setRazaoSocial, etc.)
		$this->updateModelFromEntity($model, $entity);

		$model->save();

		// Recarrega relacionamentos se necessário (belongsToMany, etc.)
		$this->loadRelations($model);

		// Converte para entidade e retorna
		return $this->toEntity($model);
	}

	/**
	 * Atualiza um registro existente pelo seu ID e retorna a entidade atualizada.
	 *
	 * @param int     $id
	 * @param TEntity $entity
	 * @return TEntity
	 *
	 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	 */
	public function update(int $id, object $entity): object
	{
		/** @var TModel $model */
		$model = ($this->modelClass)::findOrFail($id);

		$this->updateModelFromEntity($model, $entity);
		$model->save();

		$this->loadRelations($model);

		return $this->toEntity($model);
	}

	/**
	 * Retorna todos os registros do model convertidos para entidade.
	 *
	 * @return TEntity[]
	 */
	public function findAll(): array
	{
		/** @var \Illuminate\Database\Eloquent\Collection<TModel> $collection */
		$collection = ($this->modelClass)::all();

		return $collection
			->each(fn($m) => $this->loadRelations($m))
			->map(fn($m) => $this->toEntity($m))
			->all();
	}

	/**
	 * Retorna a entidade correspondente ao ID ou null.
	 *
	 * @param int $id
	 * @return TEntity|null
	 */
	public function findById(int $id): ?object
	{
		/** @var TModel|null $model */
		$model = ($this->modelClass)::find($id);

		if (!$model) {
			return null;
		}

		$this->loadRelations($model);
		return $this->toEntity($model);
	}

	/**
	 * Exemplo específico (caso queira um método genérico em BaseRepository).
	 * Você pode remover se não fizer sentido aqui.
	 */
	public function findByCnpj(string $cnpj): ?object
	{
		/** @var TModel|null $model */
		$model = ($this->modelClass)::where('cnpj', $cnpj)->first();

		if (!$model) {
			return null;
		}

		$this->loadRelations($model);
		return $this->toEntity($model);
	}

	/**
	 * Verifica se já existe um registro com este campo “cnpj”.  
	 * Caso sua entidade genérica não tenha cnpj, esse método poderia ser abstrato.
	 */
	public function existCnpj(string $cnpj): bool
	{
		return ($this->modelClass)::where('cnpj', $cnpj)->exists();
	}

	/**
	 * Deleta (soft delete) pelo ID, se existir.
	 *
	 * @param int $id
	 * @return void
	 */
	public function delete(int $id): void
	{
		/** @var TModel|null $model */
		$model = ($this->modelClass)::find($id);
		if ($model) {
			$model->delete();
		}
	}

	/**
	 * Soft delete (igual a delete, visto que o Model usa SoftDeletes).
	 *
	 * @param int $id
	 * @return void
	 */
	public function softDelete(int $id): void
	{
		$this->delete($id);
	}

	/**
	 * Converte um Eloquent Model ($model) em Entidade de Domínio ($entityClass).
	 *
	 * @param TModel $model
	 * @return TEntity
	 */
	protected function toEntity(Model $model): object
	{
		$entityClass = $this->entityClass;

		return new $entityClass(
			$model->id,
			$model->razao_social,
			$model->nome_fantasia,
			$model->cnpj,
			$model->relationLoaded('setores')
				? $model->setores->pluck('id')->toArray()
				: [],
			$model->created_at?->toDateTimeString() ?? '',
			$model->updated_at?->toDateTimeString() ?? '',
			$model->deleted_at?->toDateTimeString() ?? null
		);
	}

	/**
	 * Preenche os atributos do Eloquent Model a partir da Entidade de Domínio.
	 * Aqui você pode chamar $model->setores()->sync($entity->getSetores()), etc.
	 *
	 * @param TModel   $model
	 * @param TEntity  $entity
	 * @return TModel
	 */
	protected function updateModelFromEntity(Model $model, object $entity): Model
	{
		// Preencha somente os campos comuns (razao_social, nome_fantasia, cnpj)
		$model->id  				= $entity->getId();
		$model->created_at  = $entity->getCreatedAt();
		$model->updated_at 	= $entity->getUpdatedAt();
		$model->deleted_at  = $entity->getDeletedAt();

		// Se a entidade tiver setores (array de IDs), sincronize:
		// $idsDeSetores = $entity->getSetores() ?? [];
		// if (method_exists($model, 'setores') && is_array($idsDeSetores)) {
		// 	$model->setores()->sync($idsDeSetores);
		// }

		return $model;
	}

	/**
	 * Caso queira garantir que o relacionamento “setores” já esteja carregado,
	 * chame $model->load('setores') em create/update/findAll/findById...
	 */
	protected function loadRelations(Model $model, ?array $relations = []): void
	{
		// if (method_exists($model, 'setores')) {
		// 	$model->load('setores');
		// }
	}
}
