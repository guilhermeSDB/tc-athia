<?php

namespace App\Interface\Http\Controllers\Empresa;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Application\DTO\Empresa\CreateEmpresaDTO;
use App\Application\DTO\Empresa\EmpresaResponseDTO;
use App\Application\UseCases\Empresa\CreateEmpresaUseCase;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<CreateEmpresaUseCase, Empresa>
 */
#[OAT\Tag(name: 'Empresas')]
class CreateEmpresaController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to create a new empresa.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	#[OAT\Post(
		path: '/empresas',
		tags: ['Empresas'],
		operationId: 'createEmpresa',
		requestBody: new OAT\RequestBody(
			description: 'Dados para criação de uma nova empresa',
			required: true,
			content: new OAT\JsonContent(ref: '#/components/schemas/CreateEmpresaDTO')
		),
		responses: [
			new OAT\Response(
				response: 201,
				description: 'Empresa criada com sucesso',
				content: new OAT\JsonContent(ref: '#/components/schemas/EmpresaResponseDTO')
			),
			new OAT\Response(
				response: 400,
				description: 'Requisição inválida (ex.: dados faltando ou formato incorreto)',
				content: new OAT\JsonContent(
					example: '{"errors": {"cnpj": ["O CNPJ é obrigatório."]}}'
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		$body = $request->getParsedBody();
		$body['cnpj'] = preg_replace('/\D/', '', $body['cnpj']);
		$dto = CreateEmpresaDTO::fromArray($body);

		try {
			$entity = $this->useCase->execute($dto);
			return ApiResponse::created($response, EmpresaResponseDTO::fromEntity($entity));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
