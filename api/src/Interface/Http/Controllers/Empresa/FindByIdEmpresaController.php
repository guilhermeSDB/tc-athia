<?php

namespace App\Interface\Http\Controllers\Empresa;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Application\DTO\Empresa\EmpresaResponseDTO;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Empresas')]
class FindByIdEmpresaController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to find an empresa by ID.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param ?array $args
	 * @return Response
	 */
	#[OAT\Get(
		path: '/empresas/{id}',
		tags: ['Empresas'],
		operationId: 'findByIdEmpresa',
		description: 'Busca uma empresa pelo ID',
		parameters: [
			new OAT\Parameter(
				name: 'id',
				in: 'path',
				required: true,
				description: 'ID da Empresa a ser buscada',
				schema: new OAT\Schema(type: 'number', format: 'uuid')
			)
		],
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Empresa encontrada',
				content: new OAT\JsonContent(ref: '#/components/schemas/EmpresaResponseDTO')
			),
			new OAT\Response(
				response: 404,
				description: 'Empresa não encontrada',
				content: new OAT\JsonContent(
					example: '{"error": "Empresa não encontrada"}'
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
				return ApiResponse::notFound($response, 'Empresa não encontrada');
			}

			return ApiResponse::success($response, EmpresaResponseDTO::fromEntity($entity));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
