<?php

namespace App\Application\DTO\Empresa;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
	schema: 'UpdateEmpresaDTO',
	title: 'UpdateEmpresaDTO',
	description: 'DTO para atualização de empresa'
)]
class UpdateEmpresaDTO
{
	#[OAT\Property(
		property: 'razao_social',
		type: 'string',
		description: 'Razão Social da empresa',
		example: 'Acme Indústria e Comércio Ltda.'
	)]
	#[Assert\NotBlank(message: "Razao social não pode ser vazia")]
	#[Assert\Length(
		max: 60,
		maxMessage: "Sua Razao Social nao pode ultrapassar 60 caracteres, valor recomendado pelos manuais de NF-e/NFC-e para emitir notas fiscais sem rejeições"
	)]
	public string $razao_social;

	#[OAT\Property(
		property: 'cnpj',
		type: 'string',
		format: 'cnpj',
		description: 'CNPJ da empresa (somente números)',
		example: '12345678000199'
	)]
	#[Assert\Regex(
		pattern: '/^(?:\d{14}|\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2})$/',
		message: 'CNPJ deve ser “12345678000199” ou “12.345.678/0001-99”.'
	)]
	#[Assert\NotBlank(message: "CNPJ não pode ser vazio")]
	public string $cnpj;

	#[OAT\Property(
		property: 'nome_fantasia',
		type: 'string',
		description: 'Nome fantasia da empresa',
		example: 'Acme Indústria'
	)]
	#[Assert\Length(
		max: 55,
		maxMessage: "Seu Nome Fantasia nao pode ultrapassar 60 caracteres, conforme orienta a própria Receita Federal para o “Título do Estabelecimento”"
	)]
	public ?string $nome_fantasia;

	#[OAT\Property(
		property: 'setores',
		type: 'array',
		description: 'IDs dos setores a serem vinculados a esta empresa',
		example: '[1, 3, 5]'
	)]
	#[Assert\Type(type: 'array', message: 'setores deve ser um array de inteiros')]
	public array $setores = [];

	#[OAT\Property(
		property: 'id',
		type: 'integer',
		format: 'int64',
		description: 'Id da empresa',
		example: '1.'
	)]
	#[Assert\Positive(message: "ID deve ser um número positivo")]
	public int $id;

	public function __construct(int $id, string $razao_social, string $cnpj, ?string $nome_fantasia = null, ?array $setores = [])
	{
		$this->id = $id;
		$this->nome_fantasia = $nome_fantasia;
		$this->cnpj = $cnpj;
		$this->razao_social = $razao_social;
		$this->setores = $setores;
	}

	public static function fromArray(int $id, array $data): self
	{
		return new self(
			$id,
			$data['razao_social'] ?? '',
			$data['cnpj'] ?? '',
			$data['nome_fantasia'] ?? null,
			$data['setores'] ?? []
		);
	}

	public static function fromRequest(int $id, self $dto): self
	{
		return new self(
			$id,
			$dto->razao_social,
			$dto->nome_fantasia,
			$dto->cnpj,
			$dto->setores,
		);
	}
}
