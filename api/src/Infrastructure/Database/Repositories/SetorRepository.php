<?php

namespace App\Infrastructure\Database\Repositories;

use App\Domain\Entities\Setor as SetorEntity;
use App\Domain\Repositories\SetorRepositoryInterface;
use App\Infrastructure\Database\Eloquent\Models\Setor as SetorModel;

class SetorRepository implements SetorRepositoryInterface
{
	public function create($entity): SetorEntity
	{
		$model = new SetorModel();
		$model = $this->updateModelFromEntity($model, $entity);
		$model->save();

		return $this->toEntity($model);
	}

	public function update($id, $entity): SetorEntity
	{
		$model = SetorModel::findOrFail($id);
		$model = $this->updateModelFromEntity($model, $entity);
		$model->save();

		return $this->toEntity($model);
	}

	public function findAll(): array
	{
		$models = SetorModel::all();
		return $models->map(fn($model) => $this->toEntity($model))->all();
	}

	public function findById(int $id): ?SetorEntity
	{
		$model = SetorModel::find($id);
		return $this->toEntity($model);
	}

	public function findByIds(array $ids): array
	{
		return SetorModel::whereIn('id', $ids)->get()->all();
	}

	public function delete(int $id): void
	{
		$model = SetorModel::find($id);
		$model->delete();

	}

	public function softDelete(int $id): void
	{
		$model = SetorModel::find($id);
		$model->delete();
	}

	public function restore(int $id): void
	{
		$model = SetorModel::withTrashed()->find($id);

		if ($model) {
			$model->restore();
		}
	}

	public function count(): int
	{
		return SetorModel::count();
	}

	private function toEntity(SetorModel $model): SetorEntity
	{
		$entity = new SetorEntity(
			$model->id,
			$model->descricao,
			$model->created_at?->toDateTimeString(),
			$model->updated_at?->toDateTimeString(),
			$model->deleted_at?->toDateTimeString()
		);

		return $entity;
	}

	private function updateModelFromEntity(SetorModel $model, SetorEntity $entity): SetorModel
	{
		$model->descricao = $entity->descricao;
		return $model;
	}
}
