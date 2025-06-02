<?php

namespace App\Interface\Http\Factories;

use App\Interface\Http\Middlewares\ValidationMiddleware;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationMiddlewareFactory
{
	public function __construct(private ContainerInterface $container) {}

	public function make(string $dtoClass): ValidationMiddleware
	{
		$validator = $this->container->get(ValidatorInterface::class);
		return new ValidationMiddleware($dtoClass, $validator);
	}
}
