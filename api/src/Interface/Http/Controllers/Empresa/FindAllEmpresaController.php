<?php

namespace App\Interface\Http\Controllers\Empresa;

use App\Application\DTO\Empresa\EmpresaResponseDTO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Empresas')]
class FindAllEmpresaController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to find all empresas.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param ?array $args
	 * @return Response
	 */
	#[OAT\Get(
		path: '/empresas',
		tags: ['Empresas'],
		operationId: 'findAllEmpresas',
		description: 'Busca todas as empresas',
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Lista de empresas',
				content: new OAT\JsonContent(
					type: 'array',
					items: new OAT\Items(ref: EmpresaResponseDTO::class)
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		try {
			$entity = $this->useCase->execute(null);
			$responseDTO = array_map(fn($empresa) => EmpresaResponseDTO::fromEntity($empresa), $entity);
			return ApiResponse::success($response, $responseDTO);
		} catch (\Exception $e) {
			return ApiResponse::error($response, 500, $e->getMessage());
		}
	}
}
