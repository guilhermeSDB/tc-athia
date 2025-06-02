<?php

namespace App\Interface\Http\Controllers\Empresa;

use App\Application\DTO\Empresa\CountEmpresaDTO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<CountEmpresaUseCase, Empresa>
 */
#[OAT\Tag(name: 'Empresas')]
class CountEmpresaController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to count empresa.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	#[OAT\Get(
		path: '/empresas/count',
		tags: ['Empresas'],
		operationId: 'countEmpresa',
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Contagem de empresas',
				content: new OAT\JsonContent(
					example: '{"count": 10}',
				)
			),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		try {
			$count = $this->useCase->execute(null);
			return ApiResponse::success($response, CountEmpresaDTO::fromCount($count));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
