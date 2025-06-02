<?php

namespace App\Application\DTO\EmpresaSetor;

use OpenApi\Attributes as OAT;
use App\Application\DTO\Empresa\EmpresaResponseDTO;
use App\Application\DTO\Setor\SetorResponseDTO;

#[OAT\Schema(
	schema: 'EmpresaSetorReportDTO',
	title: 'EmpresaSetorReportDTO',
	description: 'DTO para trazer Empresa Setor'
)]
class EmpresaSetorReportDTO
{
	#[OAT\Property(type: 'integer', format: 'int64')]
	public int $id;

	#[OAT\Property(example: "Empresa XPTO")]
	public ?string $nome_fantasia = null;

	#[OAT\Property(example: 1)]
	public int $empresa_id;

	#[OAT\Property(example: "Empresa XPTO")]
	public string $razao_social;

	#[OAT\Property(example: "12345678000199")]
	public string $cnpj;

	/** @var SetorResponseDTO[] */
	#[OAT\Property(
		type: 'array',
		items: new OAT\Items(ref: SetorResponseDTO::class)
	)]
	public array $setores;

	public static function fromEntity(object $empresa): self
	{
		$dto = new self();
		$dto->empresa_id = $empresa->id;
		$dto->razao_social = $empresa->razao_social;
		$dto->nome_fantasia = $empresa->nome_fantasia ?? null;
		$dto->cnpj = $empresa->cnpj;
		$dto->setores = array_map(
			fn($setor) => SetorResponseDTO::fromEntity($setor),
			$empresa->setores ?? []
		);

		return $dto;
	}

	public static function fromModel(mixed $model): self
	{
		$dto = new self();
		$dto->id = $model->id;
		$dto->cnpj = $model->cnpj;
		$dto->razao_social = $model->razao_social;
		$dto->nome_fantasia = $model->nome_fantasia ?? null;

		$dto->setores = $model->setores->map(fn($setor) => [
			'id' => $setor->id,
			'descricao' => $setor->descricao
		])->all();

		return $dto;
	}
}
