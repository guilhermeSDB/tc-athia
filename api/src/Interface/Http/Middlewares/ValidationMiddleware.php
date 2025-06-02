<?php

namespace App\Interface\Http\Middlewares;

use App\Interface\Http\Helpers\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Middleware to validate request data against a DTO (Data Transfer Object).
 * It checks for required fields and validates the DTO using Symfony Validator.
 * If validation fails, it returns a 422 Unprocessable Entity response with error details.
 */
class ValidationMiddleware implements MiddlewareInterface
{
	public function __construct(
		private string $dtoClass,
		private ValidatorInterface $validator
	) {}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$body = (array) $request->getParsedBody();
		$args = $request->getAttribute('__route__')?->getArguments() ?? [];
		$reflection = new \ReflectionClass($this->dtoClass);
		$constructor = $reflection->getConstructor();
		$params = $constructor?->getParameters() ?? [];
		$missing = [];
		foreach ($params as $param) {
			$name = $param->getName();
			if (
				!array_key_exists($name, $body)
				&& !array_key_exists($name, $args)
				&& !$param->isOptional()
			) {
				$missing[] = $name;
			}
		}

		if (!empty($missing)) {
			return $this->errorResponse($request, "Campos obrigatórios ausentes: " . implode(', ', $missing));
		}

		$values = [];
		foreach ($params as $p) {
			$n = $p->getName();
			if (array_key_exists($n, $args)) {
				$values[] = $args[$n];
			} elseif (array_key_exists($n, $body)) {
				$values[] = $body[$n];
			} else {
				$values[] = $p->getDefaultValue();
			}
		}

		$dto = new $this->dtoClass(...$values);
		$violations = $this->validator->validate($dto);
		if (count($violations) > 0) {
			$errors = [];
			foreach ($violations as $violation) {
				$errors[$violation->getPropertyPath()] = $violation->getMessage();
			}
			return $this->validationErrorResponse($request, $errors);
		}

		$request = $request->withAttribute('dto', $dto);

		return $handler->handle($request);
	}

	private function errorResponse(ServerRequestInterface $request, string $message): ResponseInterface
	{
		$responseFactory = new ResponseFactory();
		$response = $responseFactory->createResponse(400);
		return JsonResponse::create(
			$response,
			[
				'status' => 'ERROR',
				'statusCode' => 400,
				'message' => 'Campos obrigatórios ausentes',
				'errors' => ['campos' => $message]
			],
			400
		);
	}

	private function validationErrorResponse(ServerRequestInterface $request, array $errors): ResponseInterface
	{
		$responseFactory = new ResponseFactory();
		$response = $responseFactory->createResponse(422);
		return JsonResponse::create(
			$response,
			[
				'status' => 'ERROR',
				'statusCode' => 422,
				'message' => 'Erros de validação',
				'errors' => $errors
			],
			422
		);
	}
}
