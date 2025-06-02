<?php

namespace App\Infrastructure\Database\Repositories;

use App\Application\DTO\EmpresaSetor\EmpresaSetorReportDTO;
use App\Domain\Entities\Empresa as EmpresaEntity;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Infrastructure\Database\Eloquent\Models\Empresa as EmpresaModel;

class EmpresaRepository implements EmpresaRepositoryInterface
{
	public function createReport(?int $empresaId = null, ?int $setorId = null): mixed
	{
		$model = EmpresaModel::query()
			  ->with(['setores'])
				->when($empresaId, fn($q) => $q->where('id', $empresaId))
        ->when($setorId, fn($q) =>
            $q->whereHas('setores', fn($sub) => 
                $sub->where('setor.id', $setorId)
            )
        )
        ->get();


		return $model->map(function (EmpresaModel $empresa) {
			return EmpresaSetorReportDTO::fromModel($empresa);
		})->all();
	}

	public function create($entity): EmpresaEntity
	{
		$model = new EmpresaModel();
		$model->razao_social  = $entity->getRazaoSocial();
		$model->nome_fantasia = $entity->getNomeFantasia();
		$model->cnpj          = $entity->getCnpj();

		$model->save();

		$setores = $entity->getSetores();
		if (!empty($setores)) {
			$model->setores()->sync($setores);
		}

		$model->load('setores');
		return $this->toEntity($model);
	}

	public function update($id, $entity): EmpresaEntity
	{
		$model = EmpresaModel::findOrFail($id);

		$model->razao_social  = $entity->getRazaoSocial();
		$model->nome_fantasia = $entity->getNomeFantasia();
		$model->cnpj          = $entity->getCnpj();

		$model->save();
		$model->setores()->sync($entity->getSetores());
		$model->load('setores');
		return $this->toEntity($model);
	}

	public function findAll(): array
	{
		$models = EmpresaModel::all();
		return $models->map(fn(EmpresaModel $model) => $this->toEntity($model))->all();
	}

	public function findById(int $id): ?EmpresaEntity
	{
		$model = EmpresaModel::find($id);

		if (!$model) {
			return null;
		}

		return $this->toEntity($model);
	}

	public function findByCnpj(string $cnpj): ?EmpresaEntity
	{
		$model = EmpresaModel::where('cnpj', $cnpj)->first();

		if (!$model) {
			return null;
		}

		return $this->toEntity($model);
	}

	public function existCnpj(string $cnpj): bool
	{
		return EmpresaModel::where('cnpj', $cnpj)->exists();
	}

	public function delete(int $id): void
	{
		$model = EmpresaModel::find($id);

		if ($model) {
			$model->delete();
		}
	}

	public function softDelete(int $id): void
	{
		$model = EmpresaModel::find($id);

		if ($model) {
			$model->delete();
		}
	}

	public function restore(int $id): void
	{
		$model = EmpresaModel::withTrashed()->find($id);

		if ($model) {
			$model->restore();
		}
	}

	public function count(): int
	{
		return EmpresaModel::count();
	}

	private function toEntity(EmpresaModel $model): EmpresaEntity
	{

		return new EmpresaEntity(
			$model->id,
			$model->razao_social,
			$model->nome_fantasia,
			$model->cnpj,
			$model->setores->pluck('id')->all(),
			$model->created_at?->toDateTimeString(),
			$model->updated_at?->toDateTimeString(),
			$model->deleted_at?->toDateTimeString()
		);
	}
}
