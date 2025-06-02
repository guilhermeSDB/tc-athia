<?php

namespace App\Interface\Http\Controllers\Setor;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Application\DTO\Setor\CreateSetorDTO;
use App\Application\DTO\Setor\SetorResponseDTO;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Setores')]
class CreateSetorController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to create a new setor.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	#[OAT\Post(
		path: '/setores',
		tags: ['Setores'],
		operationId: 'createSetor',
		requestBody: new OAT\RequestBody(
			description: 'Dados para criação de um novo setor',
			required: true,
			content: new OAT\JsonContent(ref: '#/components/schemas/CreateSetorDTO')
		),
		responses: [
			new OAT\Response(
				response: 201,
				description: 'Setor criado com sucesso',
				content: new OAT\JsonContent(ref: '#/components/schemas/SetorResponseDTO')
			),
			new OAT\Response(
				response: 400,
				description: 'Requisição inválida (ex.: dados faltando ou formato incorreto)',
				content: new OAT\JsonContent(
					example: '{"errors": {"descricao": ["A descrição é obrigatória."]}}'
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		$body = $request->getParsedBody();
		$dto = CreateSetorDTO::fromArray($body);

		try {
			$entity = $this->useCase->execute($dto);
			return ApiResponse::created($response, SetorResponseDTO::fromEntity($entity));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
