<?php

namespace App\Domain\Contracts;

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
 * * class MyUseCase implements UseCaseInterface
 * * {
 * * *     public function __construct(RepositoryInterface $repository, ValidatorServiceInterface $validatorService) {}
 * 
 * * *     public function execute($dto): mixed
 * * *     {
 * * *         $this->validatorService->validate($dto);
 * * *  			 $newEntity = Entity::create($dto->property)
 * * *         return $this->repository->create($entity);
 * * *     }
 * * *}
 * 
 *
 * @package App\Domain\Contracts
 */


/**
 * @template TRepository
 * @template TValidatorService
 * @template TInput 
 * @template TOutput
 */
interface UseCaseInterface
{
	/**
	 * @param TInput $input
	 * @return TOutput
	 */
	public function execute(mixed $input): mixed;
}
