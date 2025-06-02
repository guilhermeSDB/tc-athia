<?php

namespace App\Domain\Contracts;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Interface ControllerInterface
 *
 * Defines the contract for controllers in the application.
 * 
 * This interface requires controllers to implement an `__invoke` method
 * which handles HTTP requests and returns a response.
 * * Controllers should also accept a UseCaseInterface instance in their constructor
 * to perform business logic operations.
 * * The `__invoke` method should be used to process the request and return a response.
 * * The `args` parameter is optional and can be used to pass route parameters.
 * * Example usage:
 * * ```php
 * * class MyController implements ControllerInterface
 * * {
 * * *     public function __construct(UseCaseInterface $useCase)
 * * *     {
 * * *         $this->useCase = $useCase;
 * * *     }
 * 
 * * *     public function __invoke(Request $request, Response $response,  ?array $args): Response
 * * *     {
 * * *         // Process the request and return a response
 * * *         $data = $this->useCase->execute($args);
 * * *         return $response->withJson($data);
 * * *     }
 * * *}
 * 
 *
 * @package App\Domain\Contracts
 */

interface ControllerInterface
{
	public function __construct(UseCaseInterface $useCase);
	public function __invoke(Request $request, Response $response,  ?array $args): Response;
}
