<?php

namespace App\Application\Services;

use App\Domain\Contracts\ValidatorServiceInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidatorService implements ValidatorServiceInterface
{
	private ValidatorInterface $validator;

	public function __construct(ValidatorInterface $validator)
	{
		$this->validator = $validator;
	}

	public function validate(object $dto): void
	{
		$errors = $this->validator->validate($dto);

		if (count($errors) > 0) {
			$messages = [];
			foreach ($errors as $error) {
				$messages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
			}

			throw new \App\Application\Exceptions\ValidationException(implode(", ", $messages));
		}
	}
}
