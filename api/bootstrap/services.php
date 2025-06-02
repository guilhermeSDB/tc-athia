<?php

use App\Domain\Contracts\ValidatorServiceInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Application\Services\ValidatorService;


$container->set(ValidatorInterface::class, function () {
	return Validation::createValidatorBuilder()
		->enableAttributeMapping()
		->getValidator();
});


$container->set(ValidatorServiceInterface::class, function ($container) {
	return new ValidatorService($container->get(ValidatorInterface::class));
});
