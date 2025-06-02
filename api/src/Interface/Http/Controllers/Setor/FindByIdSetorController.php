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
class FindByIdSetorController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to find an setor by ID.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param?array $args
	 * @return Response
	 */
	#[OAT\Get(
		path: '/setores/{id}',
		tags: ['Setores'],
		operationId: 'findByIdSetor',
		description: 'Busca um setor pelo ID',
		parameters: [
			new OAT\Parameter(
				name: 'id',
				in: 'path',
				required: true,
				description: 'ID do Setor a ser buscado',
				schema: new OAT\Schema(type: 'number', format: 'uuid')
			)
		],
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Setor encontrado',
				content: new OAT\JsonContent(ref: '#/components/schemas/SetorResponseDTO')
			),
			new OAT\Response(
				response: 404,
				description: 'Setor não encontrado',
				content: new OAT\JsonContent(
					example: '{"error": "Setor não encontrado"}'
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		try {
			$entity = $this->useCase->execute($args['id']);

			if (!$entity) {
				return ApiResponse::notFound($response, 'Setor não encontrado');
			}

			return ApiResponse::success($response, SetorResponseDTO::fromEntity($entity));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
