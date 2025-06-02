<?php

namespace App\Domain\Entities;

use App\Domain\Entities\Entity;

class Empresa extends Entity
{
	private string  $razao_social;
	private ?string $nome_fantasia;
	private string  $cnpj;
	private array   $setores;

	public function __construct(
		?int    $id,
		string  $razao_social,
		?string $nome_fantasia,
		string  $cnpj,
		array   $setores,
		string  $created_at,
		string  $updated_at,
		?string $deleted_at
	) {
		parent::__construct($id, $created_at, $updated_at, $deleted_at);
		$this->razao_social  = $razao_social;
		$this->nome_fantasia = $nome_fantasia;
		$this->cnpj          = $cnpj;
		$this->setores       = $setores;
	}

	/**
	 * Fábrica para criar uma nova empresa ainda não persistida.
	 */
	public static function create(string $razao_social, ?string $nome_fantasia, string $cnpj, array $setores = []): self
	{
		return new self(
			null,
			$razao_social,
			$nome_fantasia,
			$cnpj,
			$setores,
			'',
			'',
			null
		);
	}

	// ─────────── Getters e Setters ───────────

	public function getRazaoSocial(): string
	{
		return $this->razao_social;
	}

	public function setRazaoSocial(string $razao_social): void
	{
		$this->razao_social = $razao_social;
	}

	public function getNomeFantasia(): ?string
	{
		return $this->nome_fantasia;
	}

	public function setNomeFantasia($nome_fantasia): void
	{
		$this->nome_fantasia = $nome_fantasia;
	}

	public function getCnpj(): string
	{
		return $this->cnpj;
	}

	public function setCnpj(string $cnpj): void
	{
		$this->cnpj = $cnpj;
	}

	public function getSetores(): array
	{
		return $this->setores;
	}

	public function setSetores(array $setores): void
	{
		$this->setores = $setores;
	}

	public function addSetor(int $setorId): void
	{
		if (!in_array($setorId, $this->setores, true)) {
			$this->setores[] = $setorId;
		}
	}

	public function removeSetor(int $setorId): void
	{
		$this->setores = array_filter(
			$this->setores,
			fn(int $id) => $id !== $setorId
		);
		// Se desejar reindexar:
		$this->setores = array_values($this->setores);
	}
}
