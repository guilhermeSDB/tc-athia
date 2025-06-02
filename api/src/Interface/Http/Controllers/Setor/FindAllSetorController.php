<?php

namespace App\Interface\Http\Controllers\Setor;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Application\DTO\Setor\SetorResponseDTO;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Setores')]
class FindAllSetorController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to find all setor.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param ?array $args
	 * @return Response
	 */
	#[OAT\Get(
		path: '/setores',
		tags: ['Setores'],
		operationId: 'findAllSetor',
		description: 'Busca todos os setores',
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Lista de setores',
				content: new OAT\JsonContent(
					type: 'array',
					items: new OAT\Items(ref: SetorResponseDTO::class)
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		try {
			$entity = $this->useCase->execute(null);
			$responseDTO = array_map(fn($setor) => SetorResponseDTO::fromEntity($setor), $entity);
			return ApiResponse::success($response, $responseDTO);
		} catch (\Exception $e) {
			return ApiResponse::error($response, 500, $e->getMessage());
		}
	}
}
