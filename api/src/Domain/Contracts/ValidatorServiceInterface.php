<?php

namespace App\Domain\Contracts;

interface ValidatorServiceInterface
{
	/**
	 * Valida o objeto, lança exceção se inválido
	 *
	 * @param object $dto
	 * @throws \App\Application\Exceptions\ValidationException
	 */
	public function validate(object $dto): void;
}
