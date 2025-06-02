<?php

namespace App\Interface\Http\Controllers\Setor;

use OpenApi\Attributes as OAT;
use App\Interface\Http\Helpers\ApiResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Contracts\ControllerInterface;
use App\Domain\Contracts\UseCaseInterface;

#[OAT\Tag(name: 'Setores')]
class SoftDeleteSetorController implements ControllerInterface
{
	public function __construct(
		private readonly UseCaseInterface $useCase
	) {}

	/**
	 * Handle the request to soft delete an setor by ID.
	 *
	 * @param Request $req
	 * @param Response $res
	 * @param?array $args
	 * @return Response
	 */
	#[OAT\Delete(
		path: '/setores/{id}/soft-delete',
		tags: ['Setores'],
		operationId: 'softDeleteSetor',
		description: 'Deleta um setor pelo ID',
		parameters: [
			new OAT\Parameter(
				name: 'id',
				in: 'path',
				required: true,
				description: 'ID da Setor a ser deletado',
				schema: new OAT\Schema(type: 'string', format: 'uuid')
			)
		],
		responses: [
			new OAT\Response(
				response: 204,
				description: 'Setor deletado com sucesso'
			),
			new OAT\Response(
				response: 400,
				description: 'Erro ao tentar excluir o setor, setor não encontrado ou não pode ser excluído',
				content: new OAT\JsonContent(
					example: '{"error": "Setor não encontrado ou não pode ser excluído"}'
				)
			),
			new OAT\Response(response: 404, description: 'Setor não encontrado'),
			new OAT\Response(response: 500, description: 'Erro interno do servidor')
		]
	)]
	public function __invoke(Request $request, Response $response, ?array $args): Response
	{
		try {
			$this->useCase->execute($args['id']);
			return ApiResponse::noContent($response);
		} catch (\Exception $e) {
			return ApiResponse::error($response, 400,  $e->getMessage());
		}
	}
}
