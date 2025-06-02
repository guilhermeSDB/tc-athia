<?php

namespace App\Interface\Http\Controllers\Setor;

use OpenApi\Attributes as OAT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\DTO\Setor\UpdateSetorDTO;
use App\Application\DTO\Setor\SetorResponseDTO;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Setores')]
class UpdateSetorController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to update an existing setor.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param?array $args
	 * @return Response
	 */
	#[OAT\Put(
		path: '/setores/{id}',
		tags: ['Setores'],
		operationId: 'updateSetor',
		requestBody: new OAT\RequestBody(
			description: 'Dados para atualizacao de um setor existente',
			required: true,
			content: new OAT\JsonContent(ref: '#/components/schemas/UpdateSetorDTO')
		),
		parameters: [
			new OAT\Parameter(
				name: 'id',
				in: 'path',
				required: true,
				description: 'ID do Setor a ser deletado',
				schema: new OAT\Schema(type: 'string', format: 'uuid')
			)
		],
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Setor atualizado com sucesso',
				content: new OAT\JsonContent(ref: '#/components/schemas/SetorResponseDTO')
			),
			new OAT\Response(
				response: 400,
				description: 'Requisição inválida (ex.: dados faltando ou formato incorreto)',
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		$body = $request->getParsedBody();
		$dto = UpdateSetorDTO::fromArray($args['id'], $body);

		try {
			$entity = $this->useCase->execute($dto);
			return ApiResponse::success($response, SetorResponseDTO::fromEntity($entity));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
