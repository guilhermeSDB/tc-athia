<?php

namespace App\Application\DTO\EmpresaSetor;

use Symfony\Component\Validator\Constraints as Assert;

class EmpresaSetorFilterDTO
{
	#[Assert\Type("int")]
	public ?int $empresa_id = null;

	#[Assert\Type("int")]
	public ?int $setor_id = null;

	public function __construct(?int $empresa_id = null, ?int $setor_id = null){
		$this->empresa_id = $empresa_id;
		$this->setor_id = $setor_id;
	}
}
