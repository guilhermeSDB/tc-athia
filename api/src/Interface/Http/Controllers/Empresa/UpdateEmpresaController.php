<?php

namespace App\Interface\Http\Controllers\Empresa;

use OpenApi\Attributes as OAT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\DTO\Empresa\UpdateEmpresaDTO;
use App\Application\DTO\Empresa\EmpresaResponseDTO;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Empresas')]
class UpdateEmpresaController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to update an existing empresa.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param?array $args
	 * @return Response
	 */
	#[OAT\Put(
		path: '/empresas/{id}',
		tags: ['Empresas'],
		operationId: 'updateEmpresa',
		requestBody: new OAT\RequestBody(
			description: 'Dados para atualizacao de uma empresa existente',
			required: true,
			content: new OAT\JsonContent(ref: '#/components/schemas/UpdateEmpresaDTO')
		),
		parameters: [
			new OAT\Parameter(
				name: 'id',
				in: 'path',
				required: true,
				description: 'ID da Empresa a ser deletada',
				schema: new OAT\Schema(type: 'string', format: 'uuid')
			)
		],
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Empresa atualizada com sucesso',
				content: new OAT\JsonContent(ref: '#/components/schemas/EmpresaResponseDTO')
			),
			new OAT\Response(
				response: 400,
				description: 'Requisição inválida (ex.: dados faltando ou formato incorreto)',
				content: new OAT\JsonContent(
					// ref: '#/components/schemas/ValidationErrorResponse',
					// example: '{"errors": {"cnpj": ["O CNPJ é obrigatório."]}}'
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		$body = $request->getParsedBody();
		$body['cnpj'] = preg_replace('/\D/', '', $body['cnpj']);
		$dto = UpdateEmpresaDTO::fromArray($args['id'], $body);

		try {
			$entity = $this->useCase->execute($dto);
			return ApiResponse::success($response, EmpresaResponseDTO::fromEntity($entity));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
