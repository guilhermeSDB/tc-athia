<?php

use App\Interface\Http\Factories\ValidationMiddlewareFactory;

$container->set(ValidationMiddlewareFactory::class, function ($c) {
	return new ValidationMiddlewareFactory($c);
});
