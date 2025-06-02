<?php

namespace App\Interface\Http\Controllers\Setor;

use App\Application\DTO\Setor\CountSetorDTO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OAT;
use App\Interface\Http\Helpers\ApiResponse;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

/**
 * @implements UseCaseInterface<CountSetorUseCase, Setor>
 */
#[OAT\Tag(name: 'Setores')]
class CountSetorController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to count setor.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @return Response
	 */
	#[OAT\Get(
		path: '/setores/count',
		tags: ['Setores'],
		operationId: 'countSetor',
		responses: [
			new OAT\Response(
				response: 200,
				description: 'Contagem de setores',
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
			return ApiResponse::success($response, CountSetorDTO::fromCount($count));
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400, $e->getMessage());
		}
	}
}
